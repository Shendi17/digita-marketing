<?php

require_once __DIR__ . '/Model.php';

/**
 * Modèle Contact
 * Gère les messages de contact
 */
class Contact extends Model {
    protected $table = 'contact_messages';
    
    /**
     * Récupérer les messages récents
     */
    public function getRecent($limit = 10) {
        return $this->all('created_at DESC', $limit);
    }
    
    /**
     * Récupérer les nouveaux messages
     */
    public function getNew() {
        return $this->where('status', 'new');
    }
    
    /**
     * Marquer un message comme lu
     */
    public function markAsRead($id) {
        return $this->update($id, ['status' => 'read']);
    }
    
    /**
     * Marquer un message comme répondu
     */
    public function markAsReplied($id) {
        return $this->update($id, ['status' => 'replied']);
    }
    
    /**
     * Créer un nouveau message de contact
     */
    public function createMessage($name, $email, $phone, $subject, $message) {
        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message,
            'status' => 'new'
        ];
        
        return $this->create($data);
    }
    
    /**
     * Récupérer les statistiques des messages
     */
    public function getStats() {
        return [
            'total' => $this->count(),
            'new' => $this->count('status = ?', ['new']),
            'read' => $this->count('status = ?', ['read']),
            'replied' => $this->count('status = ?', ['replied']),
            'today' => $this->count('DATE(created_at) = CURDATE()'),
            'this_week' => $this->count('YEARWEEK(created_at) = YEARWEEK(NOW())'),
            'this_month' => $this->count('MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())')
        ];
    }
    
    /**
     * Rechercher des messages
     */
    public function search($query) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE name LIKE ? OR email LIKE ? OR subject LIKE ? OR message LIKE ?
                ORDER BY created_at DESC";
        
        $searchTerm = "%{$query}%";
        return $this->fetchAll($sql, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    }
}
