<?php

require_once __DIR__ . '/Model.php';

/**
 * Modèle Project
 * Gère les projets clients (brief, pipeline, suivi)
 */
class Project extends Model {
    protected $table = 'client_projects';
    
    /**
     * Statuts avec labels
     */
    public static $statuses = [
        'draft' => 'Brouillon',
        'pending' => 'En attente',
        'generating' => 'Génération IA',
        'review' => 'En révision',
        'revision' => 'Corrections',
        'approved' => 'Approuvé',
        'delivered' => 'Livré',
        'completed' => 'Terminé',
        'cancelled' => 'Annulé'
    ];
    
    /**
     * Types de projets avec labels
     */
    public static $types = [
        'website' => 'Site vitrine',
        'ecommerce' => 'E-commerce',
        'landing' => 'Landing page',
        'app' => 'Application web',
        'seo' => 'Audit SEO',
        'marketing' => 'Stratégie marketing'
    ];
    
    /**
     * Créer un projet depuis un brief client
     */
    public function createFromBrief($clientId, $data) {
        $briefData = json_encode($data['brief_data'] ?? [], JSON_UNESCAPED_UNICODE);
        
        $projectId = $this->create([
            'client_id' => $clientId,
            'project_type' => $data['project_type'],
            'title' => $data['title'],
            'brief' => $data['brief'],
            'brief_data' => $briefData,
            'status' => 'pending',
            'priority' => $data['priority'] ?? 'normal',
            'price' => $data['price'] ?? 0,
            'estimated_days' => $data['estimated_days'] ?? 7
        ]);
        
        // Historique
        $this->addStatusHistory($projectId, null, 'pending', $clientId, 'Projet créé depuis le formulaire de brief');
        
        return $projectId;
    }
    
    /**
     * Récupérer les projets d'un client
     */
    public function getClientProjects($clientId, $status = null) {
        $sql = "SELECT cp.*, 
                    (SELECT COUNT(*) FROM project_messages pm WHERE pm.project_id = cp.id AND pm.is_read = 0 AND pm.is_admin = 1) as unread_messages
                FROM client_projects cp
                WHERE cp.client_id = ?";
        $params = [$clientId];
        
        if ($status) {
            $sql .= " AND cp.status = ?";
            $params[] = $status;
        }
        
        $sql .= " ORDER BY cp.updated_at DESC";
        
        return $this->fetchAll($sql, $params);
    }
    
    /**
     * Récupérer un projet complet avec messages et fichiers
     */
    public function getFullProject($projectId) {
        $project = $this->fetch(
            "SELECT cp.*, u.email as client_email, u.username as client_name
             FROM client_projects cp
             JOIN users u ON cp.client_id = u.id
             WHERE cp.id = ?",
            [$projectId]
        );
        
        if (!$project) return null;
        
        $project['messages'] = $this->fetchAll(
            "SELECT pm.*, u.email as user_email, u.username as user_name
             FROM project_messages pm
             JOIN users u ON pm.user_id = u.id
             WHERE pm.project_id = ?
             ORDER BY pm.created_at ASC",
            [$projectId]
        );
        
        $project['files'] = $this->fetchAll(
            "SELECT pf.*, u.username as uploaded_by
             FROM project_files pf
             JOIN users u ON pf.user_id = u.id
             WHERE pf.project_id = ?
             ORDER BY pf.created_at DESC",
            [$projectId]
        );
        
        $project['tasks'] = $this->fetchAll(
            "SELECT * FROM project_tasks WHERE project_id = ? ORDER BY sort_order ASC",
            [$projectId]
        );
        
        $project['history'] = $this->fetchAll(
            "SELECT psh.*, u.username as changed_by_name
             FROM project_status_history psh
             JOIN users u ON psh.changed_by = u.id
             WHERE psh.project_id = ?
             ORDER BY psh.created_at DESC",
            [$projectId]
        );
        
        return $project;
    }
    
    /**
     * Vérifier que le projet appartient au client
     */
    public function belongsToClient($projectId, $clientId) {
        $project = $this->fetch(
            "SELECT id FROM client_projects WHERE id = ? AND client_id = ?",
            [$projectId, $clientId]
        );
        return !empty($project);
    }
    
    /**
     * Mettre à jour le statut d'un projet
     */
    public function updateStatus($projectId, $newStatus, $changedBy, $note = null) {
        $project = $this->find($projectId);
        if (!$project) return false;
        
        $oldStatus = $project['status'];
        
        $updateData = ['status' => $newStatus];
        
        if ($newStatus === 'generating') {
            $updateData['started_at'] = date('Y-m-d H:i:s');
        } elseif ($newStatus === 'delivered') {
            $updateData['delivered_at'] = date('Y-m-d H:i:s');
        } elseif ($newStatus === 'completed') {
            $updateData['completed_at'] = date('Y-m-d H:i:s');
        }
        
        $this->update($projectId, $updateData);
        $this->addStatusHistory($projectId, $oldStatus, $newStatus, $changedBy, $note);
        
        return true;
    }
    
    /**
     * Ajouter un historique de changement de statut
     */
    private function addStatusHistory($projectId, $oldStatus, $newStatus, $changedBy, $note = null) {
        $this->db->query(
            "INSERT INTO project_status_history (project_id, old_status, new_status, changed_by, note) VALUES (?, ?, ?, ?, ?)",
            [$projectId, $oldStatus, $newStatus, $changedBy, $note]
        );
    }
    
    /**
     * Ajouter un message au projet
     */
    public function addMessage($projectId, $userId, $message, $isAdmin = false, $attachment = null) {
        $this->db->query(
            "INSERT INTO project_messages (project_id, user_id, message, is_admin, attachment) VALUES (?, ?, ?, ?, ?)",
            [$projectId, $userId, $message, $isAdmin ? 1 : 0, $attachment]
        );
        return $this->db->lastInsertId();
    }
    
    /**
     * Marquer les messages comme lus
     */
    public function markMessagesRead($projectId, $isAdmin) {
        // Si admin lit, on marque les messages clients comme lus
        // Si client lit, on marque les messages admin comme lus
        $targetAdmin = $isAdmin ? 0 : 1;
        $this->db->query(
            "UPDATE project_messages SET is_read = 1 WHERE project_id = ? AND is_admin = ? AND is_read = 0",
            [$projectId, $targetAdmin]
        );
    }
    
    /**
     * Ajouter un fichier au projet
     */
    public function addFile($projectId, $userId, $data) {
        $this->db->query(
            "INSERT INTO project_files (project_id, user_id, filename, filepath, filetype, filesize, description) VALUES (?, ?, ?, ?, ?, ?, ?)",
            [$projectId, $userId, $data['filename'], $data['filepath'], $data['filetype'] ?? null, $data['filesize'] ?? 0, $data['description'] ?? null]
        );
        return $this->db->lastInsertId();
    }
    
    /**
     * Ajouter une tâche au projet
     */
    public function addTask($projectId, $title, $description = null) {
        $maxOrder = $this->fetch(
            "SELECT COALESCE(MAX(sort_order), 0) + 1 as next_order FROM project_tasks WHERE project_id = ?",
            [$projectId]
        );
        
        $this->db->query(
            "INSERT INTO project_tasks (project_id, title, description, sort_order) VALUES (?, ?, ?, ?)",
            [$projectId, $title, $description, $maxOrder['next_order']]
        );
        return $this->db->lastInsertId();
    }
    
    /**
     * Mettre à jour le statut d'une tâche
     */
    public function updateTaskStatus($taskId, $status) {
        $completedAt = ($status === 'done') ? date('Y-m-d H:i:s') : null;
        $this->db->query(
            "UPDATE project_tasks SET status = ?, completed_at = ? WHERE id = ?",
            [$status, $completedAt, $taskId]
        );
    }
    
    // ==================== ADMIN ====================
    
    /**
     * Récupérer tous les projets (admin) avec filtres
     */
    public function getAllProjects($status = null, $type = null, $limit = 50) {
        $sql = "SELECT cp.*, u.email as client_email, u.username as client_name,
                    (SELECT COUNT(*) FROM project_messages pm WHERE pm.project_id = cp.id AND pm.is_read = 0 AND pm.is_admin = 0) as unread_client_messages
                FROM client_projects cp
                JOIN users u ON cp.client_id = u.id
                WHERE 1=1";
        $params = [];
        
        if ($status) {
            $sql .= " AND cp.status = ?";
            $params[] = $status;
        }
        if ($type) {
            $sql .= " AND cp.project_type = ?";
            $params[] = $type;
        }
        
        $sql .= " ORDER BY 
                    CASE cp.priority 
                        WHEN 'urgent' THEN 1 
                        WHEN 'high' THEN 2 
                        WHEN 'normal' THEN 3 
                        WHEN 'low' THEN 4 
                    END,
                    cp.updated_at DESC
                   LIMIT ?";
        $params[] = $limit;
        
        return $this->fetchAll($sql, $params);
    }
    
    /**
     * Récupérer les projets par statut (pour le Kanban)
     */
    public function getProjectsByStatus() {
        $projects = $this->fetchAll(
            "SELECT cp.*, u.email as client_email, u.username as client_name,
                    (SELECT COUNT(*) FROM project_messages pm WHERE pm.project_id = cp.id AND pm.is_read = 0 AND pm.is_admin = 0) as unread_client_messages
             FROM client_projects cp
             JOIN users u ON cp.client_id = u.id
             WHERE cp.status NOT IN ('completed', 'cancelled')
             ORDER BY 
                CASE cp.priority WHEN 'urgent' THEN 1 WHEN 'high' THEN 2 WHEN 'normal' THEN 3 WHEN 'low' THEN 4 END,
                cp.updated_at DESC"
        );
        
        $kanban = [
            'pending' => [],
            'generating' => [],
            'review' => [],
            'revision' => [],
            'approved' => [],
            'delivered' => []
        ];
        
        foreach ($projects as $project) {
            $status = $project['status'];
            if (isset($kanban[$status])) {
                $kanban[$status][] = $project;
            }
        }
        
        return $kanban;
    }
    
    /**
     * Lier un projet Webox
     */
    public function linkWebox($projectId, $weboxProjectId, $previewUrl = null) {
        $this->update($projectId, [
            'webox_project_id' => $weboxProjectId,
            'preview_url' => $previewUrl
        ]);
    }
    
    /**
     * Calculer le devis automatique
     */
    public static function calculateQuote($projectType, $briefData = []) {
        $basePrices = [
            'website' => 500,
            'ecommerce' => 1200,
            'landing' => 200,
            'app' => 2000,
            'seo' => 300,
            'marketing' => 400
        ];
        
        $price = $basePrices[$projectType] ?? 500;
        
        // Ajustements selon le brief
        $pages = (int)($briefData['pages'] ?? 5);
        if ($pages > 5) {
            $price += ($pages - 5) * 50;
        }
        
        if (!empty($briefData['multilingual'])) {
            $price *= 1.3;
        }
        
        if (!empty($briefData['urgent'])) {
            $price *= 1.5;
        }
        
        return round($price, 2);
    }
    
    /**
     * Statistiques projets (admin)
     */
    public function getStats() {
        $total = $this->count();
        $active = $this->count("status NOT IN ('completed', 'cancelled', 'draft')");
        $completed = $this->count("status = 'completed'");
        $pending = $this->count("status = 'pending'");
        
        $revenue = $this->fetch(
            "SELECT COALESCE(SUM(price), 0) as total_revenue FROM client_projects WHERE status = 'completed' AND paid = 1"
        );
        
        $monthlyRevenue = $this->fetch(
            "SELECT COALESCE(SUM(price), 0) as monthly FROM client_projects WHERE status = 'completed' AND paid = 1 AND MONTH(completed_at) = MONTH(NOW()) AND YEAR(completed_at) = YEAR(NOW())"
        );
        
        $avgDelivery = $this->fetch(
            "SELECT AVG(DATEDIFF(delivered_at, created_at)) as avg_days FROM client_projects WHERE delivered_at IS NOT NULL"
        );
        
        return [
            'total' => $total,
            'active' => $active,
            'completed' => $completed,
            'pending' => $pending,
            'total_revenue' => $revenue['total_revenue'] ?? 0,
            'monthly_revenue' => $monthlyRevenue['monthly'] ?? 0,
            'avg_delivery_days' => round($avgDelivery['avg_days'] ?? 0, 1)
        ];
    }
}
