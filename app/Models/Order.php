<?php

require_once __DIR__ . '/Model.php';

/**
 * Modèle Order
 * Gère les commandes
 */
class Order extends Model {
    
    protected $table = 'orders';
    
    /**
     * Récupérer les commandes d'un utilisateur avec détails
     */
    public function getUserOrders($userId, $limit = 20) {
        return $this->fetchAll(
            "SELECT o.*, 
                    GROUP_CONCAT(oi.product_name SEPARATOR ', ') as items_summary,
                    COUNT(oi.id) as item_count
             FROM orders o
             LEFT JOIN order_items oi ON o.id = oi.order_id
             WHERE o.user_id = ?
             GROUP BY o.id
             ORDER BY o.created_at DESC
             LIMIT ?",
            [$userId, $limit]
        );
    }
    
    /**
     * Récupérer une commande complète par ID
     */
    public function getFullOrder($orderId) {
        $order = $this->find($orderId);
        if (!$order) return null;
        
        $order['items'] = $this->getOrderItems($orderId);
        return $order;
    }
    
    /**
     * Récupérer une commande par session Stripe
     */
    public function getByStripeSession($sessionId) {
        return $this->fetch(
            "SELECT * FROM {$this->table} WHERE stripe_session_id = ?",
            [$sessionId]
        );
    }
    
    /**
     * Récupérer les articles d'une commande
     */
    public function getOrderItems($orderId) {
        return $this->fetchAll(
            "SELECT oi.* 
             FROM order_items oi
             WHERE oi.order_id = ?
             ORDER BY oi.id",
            [$orderId]
        );
    }
    
    /**
     * Créer une commande formation
     */
    public function createFormationOrder($userId, $formation, $promoCode = null) {
        $amount = (float) $formation['price'];
        $discount = 0;
        $promoCodeId = null;
        
        // Appliquer le code promo si fourni
        if ($promoCode) {
            $discount = $this->calculateDiscount($promoCode, $amount);
            $promoCodeId = $promoCode['id'];
            $amount = max(0, $amount - $discount);
        }
        
        // Générer le numéro de facture
        $invoiceNumber = $this->generateInvoiceNumber();
        
        // Créer la commande
        $orderId = $this->create([
            'user_id' => $userId,
            'amount' => $amount,
            'currency' => 'EUR',
            'status' => 'pending',
            'customer_email' => $_SESSION['user_email'] ?? null,
            'invoice_number' => $invoiceNumber,
            'promo_code_id' => $promoCodeId,
            'discount_amount' => $discount
        ]);
        
        // Ajouter l'item formation
        $this->query(
            "INSERT INTO order_items (order_id, product_id, product_type, product_name, quantity, price) 
             VALUES (?, ?, 'formation', ?, 1, ?)",
            [$orderId, $formation['id'], $formation['title'], $formation['price']]
        );
        
        return $orderId;
    }
    
    /**
     * Créer une commande avec ses articles
     */
    public function createWithItems($orderData, $items) {
        $orderId = $this->create($orderData);
        
        foreach ($items as $item) {
            $this->query(
                "INSERT INTO order_items (order_id, product_id, product_type, product_name, quantity, price) 
                 VALUES (?, ?, ?, ?, ?, ?)",
                [
                    $orderId, 
                    $item['product_id'], 
                    $item['product_type'] ?? 'formation',
                    $item['product_name'] ?? '',
                    $item['quantity'] ?? 1, 
                    $item['price']
                ]
            );
        }
        
        return $orderId;
    }
    
    /**
     * Finaliser une commande après paiement Stripe
     */
    public function fulfillOrder($orderId, $stripeSessionId, $stripePaymentIntent = null) {
        $this->query(
            "UPDATE {$this->table} 
             SET status = 'paid', stripe_session_id = ?, stripe_payment_intent = ?, updated_at = NOW()
             WHERE id = ?",
            [$stripeSessionId, $stripePaymentIntent, $orderId]
        );
        
        // Récupérer les items pour inscrire l'utilisateur aux formations
        $order = $this->find($orderId);
        $items = $this->getOrderItems($orderId);
        
        foreach ($items as $item) {
            if ($item['product_type'] === 'formation' && !empty($order['user_id'])) {
                $this->enrollUserToFormation($order['user_id'], $item['product_id']);
            }
        }
        
        // Incrémenter l'utilisation du code promo
        if (!empty($order['promo_code_id'])) {
            $this->query(
                "UPDATE promo_codes SET used_count = used_count + 1 WHERE id = ?",
                [$order['promo_code_id']]
            );
        }
        
        return $order;
    }
    
    /**
     * Inscrire un utilisateur à une formation après achat
     */
    private function enrollUserToFormation($userId, $formationId) {
        // Vérifier si déjà inscrit
        $existing = $this->fetch(
            "SELECT id FROM formation_enrollments WHERE user_id = ? AND formation_id = ?",
            [$userId, $formationId]
        );
        
        if (!$existing) {
            $this->query(
                "INSERT INTO formation_enrollments (user_id, formation_id, enrolled_at) VALUES (?, ?, NOW())",
                [$userId, $formationId]
            );
            
            // Incrémenter le compteur d'inscrits
            $this->query(
                "UPDATE formations SET enrolled_count = enrolled_count + 1 WHERE id = ?",
                [$formationId]
            );
        }
    }
    
    /**
     * Mettre à jour le statut d'une commande
     */
    public function updateStatus($orderId, $status) {
        return $this->update($orderId, ['status' => $status]);
    }
    
    /**
     * Vérifier si un utilisateur a acheté une formation
     */
    public function hasUserPurchasedFormation($userId, $formationId) {
        $result = $this->fetch(
            "SELECT o.id FROM orders o
             JOIN order_items oi ON o.id = oi.order_id
             WHERE o.user_id = ? AND oi.product_id = ? AND oi.product_type = 'formation' AND o.status = 'paid'
             LIMIT 1",
            [$userId, $formationId]
        );
        return !empty($result);
    }
    
    // ==================== CODES PROMO ====================
    
    /**
     * Valider un code promo
     */
    public function validatePromoCode($code) {
        return $this->fetch(
            "SELECT * FROM promo_codes 
             WHERE code = ? AND is_active = 1 
             AND (max_uses IS NULL OR used_count < max_uses)
             AND (valid_from IS NULL OR valid_from <= NOW())
             AND (valid_until IS NULL OR valid_until >= NOW())",
            [$code]
        );
    }
    
    /**
     * Calculer la réduction d'un code promo
     */
    public function calculateDiscount($promoCode, $amount) {
        if ($promoCode['discount_type'] === 'percent') {
            return round($amount * $promoCode['discount_value'] / 100, 2);
        }
        return min($promoCode['discount_value'], $amount);
    }
    
    // ==================== FACTURES ====================
    
    /**
     * Générer un numéro de facture unique
     */
    public function generateInvoiceNumber() {
        $year = date('Y');
        $month = date('m');
        $result = $this->fetch(
            "SELECT COUNT(*) as count FROM {$this->table} 
             WHERE invoice_number LIKE ?",
            ["DM-{$year}{$month}-%"]
        );
        $num = ($result['count'] ?? 0) + 1;
        return sprintf("DM-%s%s-%04d", $year, $month, $num);
    }
    
    // ==================== STATISTIQUES ====================
    
    /**
     * Récupérer les statistiques de commandes
     */
    public function getStats($startDate = null, $endDate = null) {
        $sql = "SELECT 
                    COUNT(*) as total_orders,
                    COALESCE(SUM(amount), 0) as total_revenue,
                    COALESCE(AVG(amount), 0) as average_order,
                    COUNT(CASE WHEN status = 'paid' THEN 1 END) as paid_orders,
                    COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_orders,
                    COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled_orders,
                    COUNT(CASE WHEN status = 'refunded' THEN 1 END) as refunded_orders
                FROM {$this->table}";
        
        $params = [];
        if ($startDate && $endDate) {
            $sql .= " WHERE created_at BETWEEN ? AND ?";
            $params = [$startDate, $endDate];
        }
        
        return $this->fetch($sql, $params);
    }
    
    /**
     * Revenus par mois
     */
    public function getMonthlyRevenue($year = null) {
        $year = $year ?? date('Y');
        return $this->fetchAll(
            "SELECT MONTH(created_at) as month, 
                    SUM(amount) as revenue, 
                    COUNT(*) as orders
             FROM {$this->table}
             WHERE status = 'paid' AND YEAR(created_at) = ?
             GROUP BY MONTH(created_at)
             ORDER BY month",
            [$year]
        );
    }
    
    /**
     * Récupérer les commandes récentes
     */
    public function getRecent($limit = 10) {
        return $this->fetchAll(
            "SELECT o.*, u.username
             FROM {$this->table} o
             LEFT JOIN users u ON o.user_id = u.id
             ORDER BY o.created_at DESC
             LIMIT ?",
            [$limit]
        );
    }
}
