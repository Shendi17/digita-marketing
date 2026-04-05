<?php

require_once __DIR__ . '/Model.php';

/**
 * Modèle ProjectMessage
 * Gère les messages de la messagerie projet
 */
class ProjectMessage extends Model {
    protected $table = 'project_messages';
    
    /**
     * Récupérer les messages d'un projet
     */
    public function getByProject($projectId) {
        return $this->fetchAll(
            "SELECT pm.*, u.email as user_email, u.username as user_name
             FROM project_messages pm
             JOIN users u ON pm.user_id = u.id
             WHERE pm.project_id = ?
             ORDER BY pm.created_at ASC",
            [$projectId]
        );
    }
    
    /**
     * Compter les messages non lus pour un client
     */
    public function countUnreadForClient($clientId) {
        $result = $this->fetch(
            "SELECT COUNT(*) as total
             FROM project_messages pm
             JOIN client_projects cp ON pm.project_id = cp.id
             WHERE cp.client_id = ? AND pm.is_admin = 1 AND pm.is_read = 0",
            [$clientId]
        );
        return $result['total'] ?? 0;
    }
    
    /**
     * Compter les messages non lus pour l'admin (tous projets)
     */
    public function countUnreadForAdmin() {
        $result = $this->fetch(
            "SELECT COUNT(*) as total FROM project_messages WHERE is_admin = 0 AND is_read = 0"
        );
        return $result['total'] ?? 0;
    }
}
