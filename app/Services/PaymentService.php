<?php

/**
 * Service de paiement
 * Gère les paiements via Stripe et PayPal
 */
class PaymentService {
    
    private $stripeSecretKey;
    private $stripePublicKey;
    
    public function __construct() {
        $this->stripeSecretKey = Environment::get('STRIPE_SECRET_KEY', '');
        $this->stripePublicKey = Environment::get('STRIPE_PUBLIC_KEY', '');
    }
    
    /**
     * Créer une session de paiement Stripe
     */
    public function createStripeCheckoutSession($items, $successUrl, $cancelUrl) {
        if (empty($this->stripeSecretKey)) {
            throw new Exception('Clé Stripe non configurée');
        }
        
        // Initialiser Stripe (nécessite: composer require stripe/stripe-php)
        \Stripe\Stripe::setApiKey($this->stripeSecretKey);
        
        $lineItems = [];
        foreach ($items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item['name'],
                        'description' => $item['description'] ?? '',
                    ],
                    'unit_amount' => $item['price'] * 100, // Convertir en centimes
                ],
                'quantity' => $item['quantity'] ?? 1,
            ];
        }
        
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'customer_email' => $_SESSION['user_email'] ?? null,
        ]);
        
        return $session;
    }
    
    /**
     * Vérifier un paiement Stripe
     */
    public function verifyStripePayment($sessionId) {
        \Stripe\Stripe::setApiKey($this->stripeSecretKey);
        
        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            return [
                'success' => $session->payment_status === 'paid',
                'amount' => $session->amount_total / 100,
                'currency' => $session->currency,
                'customer_email' => $session->customer_email,
            ];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Traiter un webhook Stripe
     */
    public function handleStripeWebhook($payload, $signature) {
        $webhookSecret = Environment::get('STRIPE_WEBHOOK_SECRET', '');
        
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $signature,
                $webhookSecret
            );
            
            switch ($event->type) {
                case 'checkout.session.completed':
                    $session = $event->data->object;
                    $this->fulfillOrder($session);
                    break;
                    
                case 'payment_intent.succeeded':
                    $paymentIntent = $event->data->object;
                    // Logique de confirmation
                    break;
                    
                case 'payment_intent.payment_failed':
                    $paymentIntent = $event->data->object;
                    // Logique d'échec
                    break;
            }
            
            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Finaliser une commande après paiement
     */
    private function fulfillOrder($session) {
        require_once __DIR__ . '/../Models/Order.php';
        $orderModel = new Order();
        
        // Créer la commande en base de données
        $orderId = $orderModel->create([
            'user_id' => $_SESSION['user_id'] ?? null,
            'stripe_session_id' => $session->id,
            'amount' => $session->amount_total / 100,
            'currency' => $session->currency,
            'status' => 'paid',
            'customer_email' => $session->customer_email,
        ]);
        
        // Envoyer email de confirmation
        require_once __DIR__ . '/EmailService.php';
        $emailService = new EmailService();
        $emailService->sendOrderConfirmation($session->customer_email, $orderId);
        
        return $orderId;
    }
    
    /**
     * Obtenir la clé publique Stripe
     */
    public function getStripePublicKey() {
        return $this->stripePublicKey;
    }
    
    /**
     * Créer un remboursement
     */
    public function createRefund($paymentIntentId, $amount = null) {
        \Stripe\Stripe::setApiKey($this->stripeSecretKey);
        
        $refundData = ['payment_intent' => $paymentIntentId];
        if ($amount !== null) {
            $refundData['amount'] = $amount * 100;
        }
        
        try {
            $refund = \Stripe\Refund::create($refundData);
            return ['success' => true, 'refund' => $refund];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
