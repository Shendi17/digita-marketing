<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Services/PaymentService.php';
require_once __DIR__ . '/../Models/Order.php';
require_once __DIR__ . '/../Middleware/CsrfMiddleware.php';

/**
 * Contrôleur de paiement
 * Gère le processus de checkout
 */
class CheckoutController extends Controller {
    
    private $paymentService;
    private $orderModel;
    
    public function __construct() {
        $this->paymentService = new PaymentService();
        $this->orderModel = new Order();
    }
    
    /**
     * Afficher la page de checkout
     */
    public function index() {
        $this->requireAuth();
        
        // Récupérer le panier depuis la session
        $cart = $_SESSION['cart'] ?? [];
        
        if (empty($cart)) {
            $_SESSION['error'] = 'Votre panier est vide';
            $this->redirect('/boutique');
        }
        
        $total = array_reduce($cart, function($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);
        
        $this->view('checkout/index', [
            'pageTitle' => 'Paiement - Digita Marketing',
            'cart' => $cart,
            'total' => $total,
            'stripePublicKey' => $this->paymentService->getStripePublicKey()
        ]);
    }
    
    /**
     * Créer une session de paiement
     */
    public function createSession() {
        $this->requireAuth();
        CsrfMiddleware::check();
        
        $cart = $_SESSION['cart'] ?? [];
        
        if (empty($cart)) {
            $this->json(['error' => 'Panier vide'], 400);
        }
        
        try {
            $session = $this->paymentService->createStripeCheckoutSession(
                $cart,
                APP_URL . '/checkout/success?session_id={CHECKOUT_SESSION_ID}',
                APP_URL . '/checkout/cancel'
            );
            
            $this->json(['sessionId' => $session->id]);
        } catch (Exception $e) {
            $this->json(['error' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Page de succès après paiement
     */
    public function success() {
        $this->requireAuth();
        
        $sessionId = $_GET['session_id'] ?? null;
        
        if (!$sessionId) {
            $this->redirect('/boutique');
        }
        
        $payment = $this->paymentService->verifyStripePayment($sessionId);
        
        if ($payment['success']) {
            // Vider le panier
            unset($_SESSION['cart']);
            
            $this->view('checkout/success', [
                'pageTitle' => 'Paiement réussi - Digita Marketing',
                'payment' => $payment
            ]);
        } else {
            $_SESSION['error'] = 'Erreur lors de la vérification du paiement';
            $this->redirect('/checkout/cancel');
        }
    }
    
    /**
     * Page d'annulation
     */
    public function cancel() {
        $this->view('checkout/cancel', [
            'pageTitle' => 'Paiement annulé - Digita Marketing'
        ]);
    }
    
    /**
     * Webhook Stripe
     */
    public function webhook() {
        $payload = @file_get_contents('php://input');
        $signature = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
        
        $result = $this->paymentService->handleStripeWebhook($payload, $signature);
        
        http_response_code($result['success'] ? 200 : 400);
        echo json_encode($result);
    }
}
