<?php

require_once __DIR__ . '/Model.php';

/**
 * Modèle Newsletter
 * Gère les abonnés à la newsletter
 */
class Newsletter extends Model {
    protected $table = 'newsletters';
    
    /**
     * Récupérer les abonnés actifs
     */
    public function getActive() {
        return $this->where('status', 'active');
    }
    
    /**
     * Récupérer les abonnés inactifs
     */
    public function getInactive() {
        return $this->where('status', 'inactive');
    }
    
    /**
     * Récupérer les abonnés récents
     */
    public function getRecent($limit = 10) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE status = 'active' 
                ORDER BY created_at DESC 
                LIMIT ?";
        return $this->fetchAll($sql, [$limit]);
    }
    
    /**
     * Ajouter un nouvel abonné
     */
    public function subscribe($email) {
        // Vérifier si l'email existe déjà
        $existing = $this->findByEmail($email);
        
        if ($existing) {
            // Si inactif, réactiver
            if ($existing['status'] === 'inactive') {
                return $this->update($existing['id'], ['status' => 'active']);
            }
            return false; // Déjà abonné
        }
        
        return $this->create([
            'email' => $email,
            'status' => 'active'
        ]);
    }
    
    /**
     * Désabonner un utilisateur
     */
    public function unsubscribe($email) {
        $subscriber = $this->findByEmail($email);
        
        if ($subscriber) {
            return $this->update($subscriber['id'], ['status' => 'inactive']);
        }
        
        return false;
    }
    
    /**
     * Trouver un abonné par email
     */
    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        return $this->fetch($sql, [$email]);
    }
    
    /**
     * Vérifier si un email est abonné
     */
    public function isSubscribed($email) {
        $subscriber = $this->findByEmail($email);
        return $subscriber && $subscriber['status'] === 'active';
    }
    
    /**
     * Récupérer les statistiques des abonnés
     */
    public function getStats() {
        return [
            'total' => $this->count(),
            'active' => $this->count('status = ?', ['active']),
            'inactive' => $this->count('status = ?', ['inactive']),
            'today' => $this->count('DATE(created_at) = CURDATE()'),
            'this_week' => $this->count('YEARWEEK(created_at) = YEARWEEK(NOW())'),
            'this_month' => $this->count('MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())')
        ];
    }
    
    /**
     * Exporter les emails actifs
     */
    public function exportEmails() {
        $sql = "SELECT email FROM {$this->table} WHERE status = 'active' ORDER BY created_at DESC";
        $subscribers = $this->fetchAll($sql);
        
        return array_column($subscribers, 'email');
    }
}
