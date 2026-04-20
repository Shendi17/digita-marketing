<?php

/**
 * ContextManager - Gestionnaire de Mémoire Contextuelle (Brief Client)
 * Permet de sauvegarder et de récupérer les informations business extraites par l'IA au fil de la discussion.
 */
class ContextManager {
    
    private $db;
    
    public function __construct() {
        require_once __DIR__ . '/../Models/Model.php';
        $this->db = Database::getInstance();
    }
    
    /**
     * Récupérer le contexte actuel d'un client (via session ou user_id)
     */
    public function getContext($sessionId, $userId = null) {
        $params = [$sessionId];
        $query = "SELECT * FROM client_context WHERE session_id = ?";
        
        if ($userId) {
            $query .= " OR user_id = ?";
            $params[] = $userId;
        }
        
        $query .= " ORDER BY updated_at DESC LIMIT 1";
        
        return $this->db->fetch($query, $params) ?: [];
    }
    
    /**
     * Mettre à jour les informations du brief
     */
    public function updateContext($sessionId, $data, $userId = null) {
        $existing = $this->getContext($sessionId, $userId);
        
        if ($existing) {
            $fields = [];
            $values = [];
            
            // On ne met à jour que ce qui est fourni
            $updatable = ['business_sector', 'business_goals', 'target_audience', 'estimated_budget', 'current_pain_points', 'competitors', 'preferred_expertise', 'lead_score'];
            
            foreach ($updatable as $field) {
                if (isset($data[$field]) && !empty($data[$field])) {
                    $fields[] = "{$field} = ?";
                    $values[] = $data[$field];
                }
            }
            
            if (empty($fields)) return true;
            
            $values[] = $existing['id'];
            $this->db->query(
                "UPDATE client_context SET " . implode(', ', $fields) . ", updated_at = NOW() WHERE id = ?",
                $values
            );
        } else {
            // Création d'un nouveau contexte
            $this->db->query(
                "INSERT INTO client_context (session_id, user_id, business_sector, business_goals, target_audience, estimated_budget, current_pain_points, competitors, preferred_expertise) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                [
                    $sessionId, 
                    $userId,
                    $data['business_sector'] ?? null,
                    $data['business_goals'] ?? null,
                    $data['target_audience'] ?? null,
                    $data['estimated_budget'] ?? null,
                    $data['current_pain_points'] ?? null,
                    $data['competitors'] ?? null,
                    $data['preferred_expertise'] ?? 'strategic'
                ]
            );
        }
        
        return true;
    }
    
    /**
     * Calculer un score de maturité digitale (0-100)
     */
    public function calculateMaturityScore($context, $projects = []) {
        $score = 0;
        
        // 1. Complétude du profil (50 points max)
        $fields = ['business_sector', 'business_goals', 'target_audience', 'estimated_budget', 'current_pain_points', 'competitors'];
        $pointsPerField = 50 / count($fields);
        
        foreach ($fields as $field) {
            if (!empty($context[$field])) {
                $score += $pointsPerField;
            }
        }
        
        // 2. Engagement Projets (30 points max)
        if (!empty($projects)) {
            $score += 10; // Au moins un projet
            $completedCount = array_filter($projects, function($p) { return $p['status'] === 'completed'; });
            if (count($completedCount) > 0) {
                $score += 20;
            }
        }
        
        // 3. Lead Score IA (20 points max - normalisé)
        if (isset($context['lead_score'])) {
            $score += ($context['lead_score'] / 100) * 20;
        }
        
        return min(round($score), 100);
    }
}
