<?php

require_once __DIR__ . '/../Models/Order.php';
require_once __DIR__ . '/../Models/Invoice.php';
require_once __DIR__ . '/../Models/Formation.php';
require_once __DIR__ . '/../Services/StripeService.php';
require_once __DIR__ . '/../Helpers/ViewHelper.php';

/**
 * Contrôleur de paiement
 * Gère le checkout Stripe, les confirmations, l'historique et les factures
 */
class PaymentController {
    
    private $orderModel;
    private $invoiceModel;
    private $formationModel;
    private $stripeService;
    
    public function __construct() {
        $this->orderModel = new Order();
        $this->invoiceModel = new Invoice();
        $this->formationModel = new Formation();
        $this->stripeService = new StripeService();
    }
    
    /**
     * Page de checkout pour une formation
     */
    public function checkout($formationId) {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = '/formations/checkout/' . $formationId;
            header('Location: /connexion');
            exit();
        }
        
        $formation = $this->formationModel->find($formationId);
        if (!$formation) {
            header('HTTP/1.0 404 Not Found');
            require_once __DIR__ . '/../Views/errors/404.php';
            return;
        }
        
        // Vérifier si déjà acheté
        if ($this->orderModel->hasUserPurchasedFormation($_SESSION['user_id'], $formationId)) {
            $_SESSION['info_message'] = 'Vous avez déjà acheté cette formation.';
            header('Location: /formations/' . $formation['slug'] . '/learn');
            exit();
        }
        
        // Formation gratuite → inscription directe
        if ((float) $formation['price'] <= 0) {
            $this->enrollFree($formationId);
            return;
        }
        
        // Valider le code promo si soumis
        $promoCode = null;
        $discount = 0;
        $finalPrice = (float) $formation['price'];
        
        if (!empty($_GET['promo'])) {
            $promoCode = $this->orderModel->validatePromoCode($_GET['promo']);
            if ($promoCode) {
                $discount = $this->orderModel->calculateDiscount($promoCode, $finalPrice);
                $finalPrice = max(0, $finalPrice - $discount);
            }
        }
        
        $data = [
            'title' => 'Paiement - ' . $formation['title'] . ' | Digita Marketing',
            'extraCss' => ['/assets/css/formations.css'],
            'formation' => $formation,
            'promoCode' => $promoCode,
            'discount' => $discount,
            'finalPrice' => $finalPrice,
            'stripePublicKey' => $this->stripeService->getPublicKey(),
            'stripeConfigured' => $this->stripeService->isConfigured()
        ];
        
        ViewHelper::render('payment/checkout-content', $data);
    }
    
    /**
     * Inscription gratuite à une formation
     */
    private function enrollFree($formationId) {
        $formation = $this->formationModel->find($formationId);
        
        // Vérifier si déjà inscrit
        $isEnrolled = $this->formationModel->isEnrolled($_SESSION['user_id'], $formationId);
        
        if (!$isEnrolled) {
            $this->formationModel->enroll($_SESSION['user_id'], $formationId);
        }
        
        $_SESSION['success_message'] = 'Vous êtes inscrit à la formation !';
        header('Location: /formations/' . $formation['slug'] . '/learn');
        exit();
    }
    
    /**
     * Créer la session Stripe et rediriger
     */
    public function processCheckout($formationId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /connexion');
            exit();
        }
        
        $formation = $this->formationModel->find($formationId);
        if (!$formation) {
            header('HTTP/1.0 404 Not Found');
            return;
        }
        
        // Valider le code promo
        $promoCode = null;
        if (!empty($_POST['promo_code'])) {
            $promoCode = $this->orderModel->validatePromoCode($_POST['promo_code']);
        }
        
        // Créer la commande
        $orderId = $this->orderModel->createFormationOrder(
            $_SESSION['user_id'],
            $formation,
            $promoCode
        );
        
        // Si prix final = 0 (code promo 100%), inscription directe
        $order = $this->orderModel->find($orderId);
        if ((float) $order['amount'] <= 0) {
            $this->orderModel->fulfillOrder($orderId, 'free_promo', null);
            $this->invoiceModel->createFromOrder($order);
            $_SESSION['success_message'] = 'Formation offerte ! Vous êtes inscrit.';
            header('Location: /formations/' . $formation['slug'] . '/learn');
            exit();
        }
        
        // Créer la session Stripe
        if (!$this->stripeService->isConfigured()) {
            // Mode démo sans Stripe
            $_SESSION['error_message'] = 'Le paiement Stripe n\'est pas encore configuré. Contactez-nous pour finaliser votre inscription.';
            header('Location: /formations/' . $formation['slug']);
            exit();
        }
        
        try {
            $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') 
                       . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');
            
            $session = $this->stripeService->createFormationCheckout(
                $formation,
                $orderId,
                $baseUrl . '/paiement/succes',
                $baseUrl . '/paiement/annulation?order_id=' . $orderId
            );
            
            header('Location: ' . $session->url);
            exit();
        } catch (Exception $e) {
            $this->orderModel->updateStatus($orderId, 'cancelled');
            $_SESSION['error_message'] = 'Erreur lors de la création du paiement : ' . $e->getMessage();
            header('Location: /formations/checkout/' . $formationId);
            exit();
        }
    }
    
    /**
     * Page de succès après paiement
     */
    public function success() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /connexion');
            exit();
        }
        
        $sessionId = $_GET['session_id'] ?? null;
        $order = null;
        $formation = null;
        
        if ($sessionId && $this->stripeService->isConfigured()) {
            // Vérifier le paiement Stripe
            $result = $this->stripeService->verifySession($sessionId);
            
            if ($result['success']) {
                $order = $this->orderModel->getByStripeSession($sessionId);
                
                // Fulfillment si pas encore fait (webhook peut l'avoir fait)
                if ($order && $order['status'] !== 'paid') {
                    $this->orderModel->fulfillOrder($order['id'], $sessionId, $result['payment_intent']);
                    $this->invoiceModel->createFromOrder($this->orderModel->find($order['id']));
                    $order = $this->orderModel->find($order['id']);
                }
                
                // Récupérer la formation
                if ($order) {
                    $items = $this->orderModel->getOrderItems($order['id']);
                    foreach ($items as $item) {
                        if ($item['product_type'] === 'formation') {
                            $formation = $this->formationModel->find($item['product_id']);
                            break;
                        }
                    }
                }
            }
        }
        
        $data = [
            'title' => 'Paiement réussi | Digita Marketing',
            'extraCss' => ['/assets/css/formations.css'],
            'order' => $order,
            'formation' => $formation
        ];
        
        ViewHelper::render('payment/success-content', $data);
    }
    
    /**
     * Page d'annulation de paiement
     */
    public function cancel() {
        $orderId = $_GET['order_id'] ?? null;
        $order = null;
        $formation = null;
        
        if ($orderId) {
            $order = $this->orderModel->find($orderId);
            if ($order && $order['status'] === 'pending') {
                $this->orderModel->updateStatus($orderId, 'cancelled');
            }
            
            // Récupérer la formation
            if ($order) {
                $items = $this->orderModel->getOrderItems($order['id']);
                foreach ($items as $item) {
                    if ($item['product_type'] === 'formation') {
                        $formation = $this->formationModel->find($item['product_id']);
                        break;
                    }
                }
            }
        }
        
        $data = [
            'title' => 'Paiement annulé | Digita Marketing',
            'extraCss' => ['/assets/css/formations.css'],
            'order' => $order,
            'formation' => $formation
        ];
        
        ViewHelper::render('payment/cancel-content', $data);
    }
    
    /**
     * Webhook Stripe (endpoint POST)
     */
    public function webhook() {
        $payload = file_get_contents('php://input');
        $sigHeader = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
        
        $result = $this->stripeService->handleWebhook($payload, $sigHeader);
        
        if ($result['success']) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
        
        header('Content-Type: application/json');
        echo json_encode($result);
        exit();
    }
    
    /**
     * Valider un code promo (AJAX)
     */
    public function validatePromo() {
        header('Content-Type: application/json');
        
        $code = $_POST['code'] ?? $_GET['code'] ?? '';
        $formationId = $_POST['formation_id'] ?? $_GET['formation_id'] ?? 0;
        
        if (empty($code)) {
            echo json_encode(['valid' => false, 'message' => 'Code promo requis']);
            exit();
        }
        
        $promoCode = $this->orderModel->validatePromoCode($code);
        
        if (!$promoCode) {
            echo json_encode(['valid' => false, 'message' => 'Code promo invalide ou expiré']);
            exit();
        }
        
        $formation = $this->formationModel->find($formationId);
        $discount = 0;
        $finalPrice = 0;
        
        if ($formation) {
            $discount = $this->orderModel->calculateDiscount($promoCode, (float) $formation['price']);
            $finalPrice = max(0, (float) $formation['price'] - $discount);
        }
        
        echo json_encode([
            'valid' => true,
            'discount_type' => $promoCode['discount_type'],
            'discount_value' => $promoCode['discount_value'],
            'discount' => $discount,
            'final_price' => $finalPrice,
            'message' => $promoCode['discount_type'] === 'percent' 
                ? '-' . $promoCode['discount_value'] . '% appliqué !'
                : '-' . number_format($promoCode['discount_value'], 2) . '€ appliqué !'
        ]);
        exit();
    }
    
    /**
     * Historique des commandes de l'utilisateur
     */
    public function myOrders() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /connexion');
            exit();
        }
        
        $orders = $this->orderModel->getUserOrders($_SESSION['user_id']);
        
        $data = [
            'title' => 'Mes commandes | Digita Marketing',
            'extraCss' => ['/assets/css/formations.css'],
            'orders' => $orders
        ];
        
        ViewHelper::render('payment/my-orders-content', $data);
    }
    
    /**
     * Détail d'une commande
     */
    public function orderDetail($orderId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /connexion');
            exit();
        }
        
        $order = $this->orderModel->getFullOrder($orderId);
        
        if (!$order || $order['user_id'] != $_SESSION['user_id']) {
            header('HTTP/1.0 404 Not Found');
            require_once __DIR__ . '/../Views/errors/404.php';
            return;
        }
        
        $invoice = $this->invoiceModel->getByOrderId($orderId);
        
        $data = [
            'title' => 'Commande #' . $orderId . ' | Digita Marketing',
            'extraCss' => ['/assets/css/formations.css'],
            'order' => $order,
            'invoice' => $invoice
        ];
        
        ViewHelper::render('payment/order-detail-content', $data);
    }
    
    /**
     * Afficher une facture
     */
    public function invoice($invoiceId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /connexion');
            exit();
        }
        
        $invoice = $this->invoiceModel->getFullInvoice($invoiceId);
        
        if (!$invoice || $invoice['user_id'] != $_SESSION['user_id']) {
            header('HTTP/1.0 404 Not Found');
            require_once __DIR__ . '/../Views/errors/404.php';
            return;
        }
        
        $data = [
            'title' => 'Facture ' . $invoice['invoice_number'] . ' | Digita Marketing',
            'extraCss' => ['/assets/css/formations.css'],
            'invoice' => $invoice
        ];
        
        ViewHelper::render('payment/invoice-content', $data);
    }
}
