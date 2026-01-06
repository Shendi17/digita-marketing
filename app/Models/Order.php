<?php

require_once __DIR__ . '/Model.php';

/**
 * Modèle Order
 * Gère les commandes
 */
class Order extends Model {
    
    protected $table = 'orders';
    
    /**
     * Récupérer les commandes d'un utilisateur
     */
    public function getUserOrders($userId) {
        return $this->where('user_id', $userId);
    }
    
    /**
     * Récupérer les articles d'une commande
     */
    public function getOrderItems($orderId) {
        $sql = "SELECT oi.*, p.name as product_name 
                FROM order_items oi
                LEFT JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = ?
                ORDER BY oi.id";
        
        return $this->fetchAll($sql, [$orderId]);
    }
    
    /**
     * Créer une commande avec ses articles
     */
    public function createWithItems($orderData, $items) {
        // Créer la commande
        $orderId = $this->create($orderData);
        
        // Ajouter les articles
        foreach ($items as $item) {
            $this->query(
                "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)",
                [$orderId, $item['product_id'], $item['quantity'], $item['price']]
            );
        }
        
        return $orderId;
    }
    
    /**
     * Mettre à jour le statut d'une commande
     */
    public function updateStatus($orderId, $status) {
        return $this->update($orderId, ['status' => $status]);
    }
    
    /**
     * Récupérer les statistiques de commandes
     */
    public function getStats($startDate = null, $endDate = null) {
        $sql = "SELECT 
                    COUNT(*) as total_orders,
                    SUM(amount) as total_revenue,
                    AVG(amount) as average_order,
                    COUNT(CASE WHEN status = 'paid' THEN 1 END) as paid_orders,
                    COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_orders,
                    COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled_orders
                FROM {$this->table}";
        
        $params = [];
        if ($startDate && $endDate) {
            $sql .= " WHERE created_at BETWEEN ? AND ?";
            $params = [$startDate, $endDate];
        }
        
        return $this->fetch($sql, $params);
    }
    
    /**
     * Récupérer les commandes récentes
     */
    public function getRecent($limit = 10) {
        return $this->all('created_at DESC', $limit);
    }
}
