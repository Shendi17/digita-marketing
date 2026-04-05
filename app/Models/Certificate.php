<?php

require_once __DIR__ . '/../../includes/Database.php';

/**
 * Modèle Certificate
 * Gère la génération et récupération des certificats de formation
 */
class Certificate {
    
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Récupérer un certificat par son numéro
     */
    public function getByNumber($number) {
        return $this->db->fetch(
            'SELECT c.*, u.username, u.email, f.title as formation_title, f.slug as formation_slug
             FROM certificates c
             JOIN users u ON c.user_id = u.id
             JOIN formations f ON c.formation_id = f.id
             WHERE c.certificate_number = ?',
            [$number]
        );
    }
    
    /**
     * Récupérer un certificat par utilisateur et formation
     */
    public function getByUserAndFormation($userId, $formationId) {
        return $this->db->fetch(
            'SELECT c.*, f.title as formation_title, f.slug as formation_slug
             FROM certificates c
             JOIN formations f ON c.formation_id = f.id
             WHERE c.user_id = ? AND c.formation_id = ?',
            [$userId, $formationId]
        );
    }
    
    /**
     * Récupérer tous les certificats d'un utilisateur
     */
    public function getUserCertificates($userId) {
        return $this->db->query(
            'SELECT c.*, f.title as formation_title, f.slug as formation_slug, f.image_url as formation_image
             FROM certificates c
             JOIN formations f ON c.formation_id = f.id
             WHERE c.user_id = ?
             ORDER BY c.issued_at DESC',
            [$userId]
        )->fetchAll();
    }
    
    /**
     * Générer un certificat
     */
    public function generate($userId, $formationId) {
        // Vérifier qu'il n'existe pas déjà
        $existing = $this->getByUserAndFormation($userId, $formationId);
        if ($existing) {
            return $existing;
        }
        
        $certificateNumber = $this->generateNumber();
        
        $this->db->query(
            'INSERT INTO certificates (user_id, formation_id, certificate_number) VALUES (?, ?, ?)',
            [$userId, $formationId, $certificateNumber]
        );
        
        $id = $this->db->lastInsertId();
        
        // Marquer la formation comme complétée
        $this->db->query(
            'UPDATE formation_enrollments SET completed = 1, completed_at = NOW() 
             WHERE user_id = ? AND formation_id = ?',
            [$userId, $formationId]
        );
        
        return $this->db->fetch('SELECT * FROM certificates WHERE id = ?', [$id]);
    }
    
    /**
     * Générer un numéro de certificat unique
     */
    private function generateNumber() {
        $prefix = 'DM';
        $year = date('Y');
        $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
        return $prefix . '-' . $year . '-' . $random;
    }
    
    /**
     * Vérifier la validité d'un certificat (page publique)
     */
    public function verify($number) {
        $cert = $this->getByNumber($number);
        return $cert ? $cert : null;
    }
}
