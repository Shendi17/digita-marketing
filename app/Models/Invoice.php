<?php

require_once __DIR__ . '/Model.php';

/**
 * Modèle Invoice
 * Gère les factures
 */
class Invoice extends Model {
    
    protected $table = 'invoices';
    
    /**
     * Créer une facture à partir d'une commande
     */
    public function createFromOrder($order) {
        $taxRate = 0; // TVA non applicable (auto-entrepreneur ou DOM)
        $amountHt = (float) $order['amount'];
        $taxAmount = round($amountHt * $taxRate / 100, 2);
        $amountTtc = $amountHt + $taxAmount;
        
        return $this->create([
            'order_id' => $order['id'],
            'user_id' => $order['user_id'],
            'invoice_number' => $order['invoice_number'] ?? $this->generateNumber(),
            'amount_ht' => $amountHt,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'amount_ttc' => $amountTtc,
            'billing_name' => $order['billing_name'] ?? $order['customer_email'],
            'billing_email' => $order['customer_email'],
            'billing_address' => $order['billing_address'] ?? null,
            'status' => 'paid',
            'paid_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Récupérer les factures d'un utilisateur
     */
    public function getUserInvoices($userId) {
        return $this->fetchAll(
            "SELECT i.*, o.stripe_session_id
             FROM {$this->table} i
             JOIN orders o ON i.order_id = o.id
             WHERE i.user_id = ?
             ORDER BY i.created_at DESC",
            [$userId]
        );
    }
    
    /**
     * Récupérer une facture complète avec détails commande
     */
    public function getFullInvoice($invoiceId) {
        $invoice = $this->fetch(
            "SELECT i.*, o.currency, o.discount_amount, o.promo_code_id
             FROM {$this->table} i
             JOIN orders o ON i.order_id = o.id
             WHERE i.id = ?",
            [$invoiceId]
        );
        
        if (!$invoice) return null;
        
        // Récupérer les items de la commande
        $invoice['items'] = $this->fetchAll(
            "SELECT * FROM order_items WHERE order_id = ?",
            [$invoice['order_id']]
        );
        
        return $invoice;
    }
    
    /**
     * Récupérer une facture par son numéro
     */
    public function getByNumber($number) {
        return $this->fetch(
            "SELECT * FROM {$this->table} WHERE invoice_number = ?",
            [$number]
        );
    }
    
    /**
     * Récupérer une facture par commande
     */
    public function getByOrderId($orderId) {
        return $this->fetch(
            "SELECT * FROM {$this->table} WHERE order_id = ?",
            [$orderId]
        );
    }
    
    /**
     * Générer un numéro de facture unique
     */
    public function generateNumber() {
        $year = date('Y');
        $month = date('m');
        $result = $this->fetch(
            "SELECT COUNT(*) as count FROM {$this->table} 
             WHERE invoice_number LIKE ?",
            ["FA-{$year}{$month}-%"]
        );
        $num = ($result['count'] ?? 0) + 1;
        return sprintf("FA-%s%s-%04d", $year, $month, $num);
    }
    
    /**
     * Statistiques factures
     */
    public function getStats() {
        return $this->fetch(
            "SELECT 
                COUNT(*) as total,
                COALESCE(SUM(amount_ttc), 0) as total_revenue,
                COALESCE(SUM(tax_amount), 0) as total_tax,
                COUNT(CASE WHEN status = 'paid' THEN 1 END) as paid,
                COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled
             FROM {$this->table}"
        );
    }
}
