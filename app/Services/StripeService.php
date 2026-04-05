<?php

require_once __DIR__ . '/../Config/Environment.php';
require_once __DIR__ . '/../Models/Order.php';
require_once __DIR__ . '/../Models/Invoice.php';

/**
 * Service Stripe dédié
 * Gère les sessions Checkout, webhooks et fulfillment
 */
class StripeService {
    
    private $secretKey;
    private $publicKey;
    private $webhookSecret;
    private $isConfigured = false;
    
    public function __construct() {
        try {
            Environment::load();
        } catch (Exception $e) {
            // .env optionnel
        }
        $this->secretKey = Environment::get('STRIPE_SECRET_KEY', '');
        $this->publicKey = Environment::get('STRIPE_PUBLIC_KEY', '');
        $this->webhookSecret = Environment::get('STRIPE_WEBHOOK_SECRET', '');
        $this->isConfigured = !empty($this->secretKey);
    }
    
    /**
     * Vérifier si Stripe est configuré
     */
    public function isConfigured() {
        return $this->isConfigured;
    }
    
    /**
     * Obtenir la clé publique Stripe
     */
    public function getPublicKey() {
        return $this->publicKey;
    }
    
    /**
     * Créer une session Checkout pour une formation
     */
    public function createFormationCheckout($formation, $orderId, $successUrl, $cancelUrl) {
        if (!$this->isConfigured) {
            throw new Exception('Stripe non configuré. Veuillez renseigner STRIPE_SECRET_KEY dans .env');
        }
        
        \Stripe\Stripe::setApiKey($this->secretKey);
        
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $formation['title'],
                        'description' => mb_strimwidth(strip_tags($formation['description'] ?? ''), 0, 200, '...'),
                        'images' => !empty($formation['image']) ? [$formation['image']] : [],
                    ],
                    'unit_amount' => (int) round($formation['price'] * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $successUrl . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $cancelUrl,
            'client_reference_id' => (string) $orderId,
            'customer_email' => $_SESSION['user_email'] ?? null,
            'metadata' => [
                'order_id' => $orderId,
                'formation_id' => $formation['id'],
                'user_id' => $_SESSION['user_id'] ?? null,
            ],
        ]);
        
        // Sauvegarder le session_id sur la commande
        $orderModel = new Order();
        $orderModel->update($orderId, ['stripe_session_id' => $session->id]);
        
        return $session;
    }
    
    /**
     * Créer une session Checkout générique
     */
    public function createCheckoutSession($items, $orderId, $successUrl, $cancelUrl) {
        if (!$this->isConfigured) {
            throw new Exception('Stripe non configuré');
        }
        
        \Stripe\Stripe::setApiKey($this->secretKey);
        
        $lineItems = [];
        foreach ($items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item['name'],
                        'description' => $item['description'] ?? '',
                    ],
                    'unit_amount' => (int) round($item['price'] * 100),
                ],
                'quantity' => $item['quantity'] ?? 1,
            ];
        }
        
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $successUrl . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $cancelUrl,
            'client_reference_id' => (string) $orderId,
            'customer_email' => $_SESSION['user_email'] ?? null,
            'metadata' => ['order_id' => $orderId],
        ]);
        
        $orderModel = new Order();
        $orderModel->update($orderId, ['stripe_session_id' => $session->id]);
        
        return $session;
    }
    
    /**
     * Vérifier une session Checkout après paiement
     */
    public function verifySession($sessionId) {
        if (!$this->isConfigured) {
            return ['success' => false, 'error' => 'Stripe non configuré'];
        }
        
        \Stripe\Stripe::setApiKey($this->secretKey);
        
        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            return [
                'success' => $session->payment_status === 'paid',
                'session' => $session,
                'order_id' => $session->client_reference_id,
                'amount' => $session->amount_total / 100,
                'currency' => $session->currency,
                'customer_email' => $session->customer_email,
                'payment_intent' => $session->payment_intent,
            ];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Traiter un webhook Stripe
     */
    public function handleWebhook($payload, $sigHeader) {
        if (empty($this->webhookSecret)) {
            return ['success' => false, 'error' => 'Webhook secret non configuré'];
        }
        
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
                $this->webhookSecret
            );
        } catch (\UnexpectedValueException $e) {
            return ['success' => false, 'error' => 'Payload invalide'];
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return ['success' => false, 'error' => 'Signature invalide'];
        }
        
        switch ($event->type) {
            case 'checkout.session.completed':
                return $this->handleCheckoutCompleted($event->data->object);
                
            case 'payment_intent.payment_failed':
                return $this->handlePaymentFailed($event->data->object);
                
            case 'charge.refunded':
                return $this->handleRefund($event->data->object);
                
            default:
                return ['success' => true, 'message' => 'Événement ignoré: ' . $event->type];
        }
    }
    
    /**
     * Traiter un checkout complété
     */
    private function handleCheckoutCompleted($session) {
        $orderModel = new Order();
        $invoiceModel = new Invoice();
        
        $orderId = $session->client_reference_id;
        if (!$orderId) {
            // Chercher par session_id
            $order = $orderModel->getByStripeSession($session->id);
            $orderId = $order ? $order['id'] : null;
        }
        
        if (!$orderId) {
            return ['success' => false, 'error' => 'Commande introuvable'];
        }
        
        // Finaliser la commande (inscription formation + promo code)
        $order = $orderModel->fulfillOrder($orderId, $session->id, $session->payment_intent);
        
        // Créer la facture
        if ($order) {
            $invoiceModel->createFromOrder($order);
        }
        
        // Envoyer l'email de confirmation
        $this->sendPurchaseConfirmation($order);
        
        return ['success' => true, 'order_id' => $orderId];
    }
    
    /**
     * Traiter un paiement échoué
     */
    private function handlePaymentFailed($paymentIntent) {
        $orderModel = new Order();
        
        // Chercher la commande liée
        $orders = $orderModel->fetchAll(
            "SELECT * FROM orders WHERE stripe_payment_intent = ? OR stripe_session_id LIKE ?",
            [$paymentIntent->id, '%' . $paymentIntent->id . '%']
        );
        
        foreach ($orders as $order) {
            $orderModel->updateStatus($order['id'], 'cancelled');
        }
        
        return ['success' => true, 'message' => 'Paiement échoué traité'];
    }
    
    /**
     * Traiter un remboursement
     */
    private function handleRefund($charge) {
        $orderModel = new Order();
        
        $order = $orderModel->fetch(
            "SELECT * FROM orders WHERE stripe_payment_intent = ?",
            [$charge->payment_intent]
        );
        
        if ($order) {
            $orderModel->updateStatus($order['id'], 'refunded');
        }
        
        return ['success' => true, 'message' => 'Remboursement traité'];
    }
    
    /**
     * Créer un remboursement
     */
    public function createRefund($paymentIntentId, $amount = null) {
        if (!$this->isConfigured) {
            return ['success' => false, 'error' => 'Stripe non configuré'];
        }
        
        \Stripe\Stripe::setApiKey($this->secretKey);
        
        $refundData = ['payment_intent' => $paymentIntentId];
        if ($amount !== null) {
            $refundData['amount'] = (int) round($amount * 100);
        }
        
        try {
            $refund = \Stripe\Refund::create($refundData);
            return ['success' => true, 'refund' => $refund];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Envoyer l'email de confirmation d'achat
     */
    private function sendPurchaseConfirmation($order) {
        if (!$order || empty($order['customer_email'])) return;
        
        try {
            require_once __DIR__ . '/EmailService.php';
            $emailService = new EmailService();
            $emailService->sendOrderConfirmation($order['customer_email'], $order['id']);
        } catch (Exception $e) {
            error_log('Erreur envoi email confirmation: ' . $e->getMessage());
        }
    }
}
