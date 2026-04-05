<?php

/**
 * Service WeboxBridge
 * Pont entre Digita Marketing et l'API Webox Multi-IA
 * Gère la création de sites, le suivi de génération et les webhooks
 */
class WeboxBridge {
    
    private $apiBaseUrl;
    private $apiKey;
    
    public function __construct() {
        $this->apiBaseUrl = rtrim($_ENV['WEBOX_API_URL'] ?? 'http://localhost:8000', '/');
        $this->apiKey = $_ENV['WEBOX_API_KEY'] ?? '';
    }
    
    /**
     * Créer un projet site web via Webox
     */
    public function createWebsite($briefData) {
        $payload = [
            'project_type' => $briefData['project_type'] ?? 'website',
            'business_name' => $briefData['business_name'] ?? '',
            'business_type' => $briefData['business_type'] ?? '',
            'description' => $briefData['description'] ?? '',
            'target_audience' => $briefData['target_audience'] ?? '',
            'style' => $briefData['style'] ?? 'modern',
            'colors' => $briefData['colors'] ?? [],
            'pages' => $briefData['pages'] ?? ['accueil', 'a-propos', 'services', 'contact'],
            'features' => $briefData['features'] ?? [],
            'content_tone' => $briefData['content_tone'] ?? 'professionnel',
            'language' => $briefData['language'] ?? 'fr',
            'callback_url' => $briefData['callback_url'] ?? $this->getCallbackUrl()
        ];
        
        return $this->post('/digita/website/create', $payload);
    }
    
    /**
     * Vérifier le statut d'un projet Webox
     */
    public function getProjectStatus($weboxProjectId) {
        return $this->get('/digita/website/status/' . $weboxProjectId);
    }
    
    /**
     * Récupérer la preview d'un projet
     */
    public function getProjectPreview($weboxProjectId) {
        return $this->get('/digita/website/preview/' . $weboxProjectId);
    }
    
    /**
     * Demander une régénération/modification
     */
    public function requestRevision($weboxProjectId, $instructions) {
        return $this->post('/digita/website/revise/' . $weboxProjectId, [
            'instructions' => $instructions
        ]);
    }
    
    /**
     * Déployer un projet en production
     */
    public function deployProject($weboxProjectId, $domain) {
        return $this->post('/digita/website/deploy/' . $weboxProjectId, [
            'domain' => $domain
        ]);
    }
    
    /**
     * Générer du contenu via l'IA Webox
     */
    public function generateContent($type, $params) {
        return $this->post('/digita/content/generate', [
            'type' => $type,
            'params' => $params
        ]);
    }
    
    /**
     * Vérifier la connectivité avec Webox
     */
    public function healthCheck() {
        try {
            $response = $this->get('/health');
            return !empty($response) && ($response['status'] ?? '') === 'ok';
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Traiter un webhook entrant de Webox
     */
    public function handleWebhook($payload) {
        $event = $payload['event'] ?? '';
        $data = $payload['data'] ?? [];
        
        switch ($event) {
            case 'website.generated':
                return $this->handleWebsiteGenerated($data);
            case 'website.deployed':
                return $this->handleWebsiteDeployed($data);
            case 'website.error':
                return $this->handleWebsiteError($data);
            default:
                error_log('WeboxBridge: événement webhook inconnu: ' . $event);
                return false;
        }
    }
    
    /**
     * Gérer l'événement : site généré
     */
    private function handleWebsiteGenerated($data) {
        $weboxProjectId = $data['project_id'] ?? '';
        $previewUrl = $data['preview_url'] ?? '';
        
        if (empty($weboxProjectId)) return false;
        
        require_once __DIR__ . '/../Models/Project.php';
        $projectModel = new Project();
        
        // Trouver le projet Digita lié
        $project = $projectModel->fetch(
            "SELECT * FROM client_projects WHERE webox_project_id = ?",
            [$weboxProjectId]
        );
        
        if (!$project) {
            error_log('WeboxBridge: projet non trouvé pour webox_id: ' . $weboxProjectId);
            return false;
        }
        
        // Mettre à jour le projet
        $projectModel->update($project['id'], ['preview_url' => $previewUrl]);
        $projectModel->updateStatus($project['id'], 'review', $project['client_id'], 'Site généré par Webox IA — en attente de révision');
        
        // Notifier le client
        $projectModel->addMessage(
            $project['id'],
            $project['client_id'],
            "Votre site a été généré ! Vous pouvez le prévisualiser ici : " . $previewUrl,
            true
        );
        
        return true;
    }
    
    /**
     * Gérer l'événement : site déployé
     */
    private function handleWebsiteDeployed($data) {
        $weboxProjectId = $data['project_id'] ?? '';
        $productionUrl = $data['production_url'] ?? '';
        
        if (empty($weboxProjectId)) return false;
        
        require_once __DIR__ . '/../Models/Project.php';
        $projectModel = new Project();
        
        $project = $projectModel->fetch(
            "SELECT * FROM client_projects WHERE webox_project_id = ?",
            [$weboxProjectId]
        );
        
        if (!$project) return false;
        
        $projectModel->update($project['id'], ['production_url' => $productionUrl]);
        $projectModel->updateStatus($project['id'], 'delivered', $project['client_id'], 'Site déployé en production');
        
        // Notifier le client
        $projectModel->addMessage(
            $project['id'],
            $project['client_id'],
            "Votre site est en ligne ! URL : " . $productionUrl,
            true
        );
        
        return true;
    }
    
    /**
     * Gérer l'événement : erreur
     */
    private function handleWebsiteError($data) {
        $weboxProjectId = $data['project_id'] ?? '';
        $error = $data['error'] ?? 'Erreur inconnue';
        
        if (empty($weboxProjectId)) return false;
        
        require_once __DIR__ . '/../Models/Project.php';
        $projectModel = new Project();
        
        $project = $projectModel->fetch(
            "SELECT * FROM client_projects WHERE webox_project_id = ?",
            [$weboxProjectId]
        );
        
        if (!$project) return false;
        
        $projectModel->updateStatus($project['id'], 'pending', $project['client_id'], 'Erreur Webox: ' . $error);
        
        error_log('WeboxBridge erreur projet #' . $project['id'] . ': ' . $error);
        
        return true;
    }
    
    // ==================== HTTP ====================
    
    /**
     * Requête GET vers l'API Webox
     */
    private function get($endpoint) {
        return $this->request('GET', $endpoint);
    }
    
    /**
     * Requête POST vers l'API Webox
     */
    private function post($endpoint, $data = []) {
        return $this->request('POST', $endpoint, $data);
    }
    
    /**
     * Exécuter une requête HTTP
     */
    private function request($method, $endpoint, $data = null) {
        $url = $this->apiBaseUrl . $endpoint;
        
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json'
        ];
        
        if (!empty($this->apiKey)) {
            $headers[] = 'Authorization: Bearer ' . $this->apiKey;
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            error_log('WeboxBridge cURL error: ' . $error);
            throw new Exception('Erreur de connexion à Webox: ' . $error);
        }
        
        $decoded = json_decode($response, true);
        
        if ($httpCode >= 400) {
            $errorMsg = $decoded['detail'] ?? $decoded['error'] ?? 'Erreur HTTP ' . $httpCode;
            error_log('WeboxBridge API error (' . $httpCode . '): ' . $errorMsg);
            throw new Exception('Erreur API Webox: ' . $errorMsg);
        }
        
        return $decoded;
    }
    
    /**
     * URL de callback pour les webhooks Webox → Digita
     */
    private function getCallbackUrl() {
        $baseUrl = $_ENV['APP_URL'] ?? 'https://digita.tonyalpha80.com';
        return rtrim($baseUrl, '/') . '/webhook/webox';
    }
}
