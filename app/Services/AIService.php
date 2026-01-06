<?php

/**
 * Service IA
 * Intégration avec OpenAI pour chatbot, génération de contenu, etc.
 */
class AIService {
    
    private $apiKey;
    private $model;
    
    public function __construct() {
        $this->apiKey = Environment::get('OPENAI_API_KEY', '');
        $this->model = Environment::get('OPENAI_MODEL', 'gpt-4');
    }
    
    /**
     * Envoyer une requête à l'API OpenAI
     */
    private function sendRequest($endpoint, $data) {
        if (empty($this->apiKey)) {
            throw new Exception('Clé API OpenAI non configurée');
        }
        
        $ch = curl_init("https://api.openai.com/v1/{$endpoint}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            throw new Exception('Erreur API OpenAI: ' . $response);
        }
        
        return json_decode($response, true);
    }
    
    /**
     * Générer une réponse de chatbot
     */
    public function chat($messages, $systemPrompt = null) {
        $chatMessages = [];
        
        if ($systemPrompt) {
            $chatMessages[] = [
                'role' => 'system',
                'content' => $systemPrompt
            ];
        }
        
        foreach ($messages as $message) {
            $chatMessages[] = [
                'role' => $message['role'] ?? 'user',
                'content' => $message['content']
            ];
        }
        
        $response = $this->sendRequest('chat/completions', [
            'model' => $this->model,
            'messages' => $chatMessages,
            'temperature' => 0.7,
            'max_tokens' => 500
        ]);
        
        return $response['choices'][0]['message']['content'] ?? '';
    }
    
    /**
     * Générer une description de produit
     */
    public function generateProductDescription($productName, $features = []) {
        $featuresText = implode(', ', $features);
        
        $prompt = "Génère une description marketing attractive et professionnelle pour le produit suivant:\n\n";
        $prompt .= "Nom: {$productName}\n";
        if (!empty($features)) {
            $prompt .= "Caractéristiques: {$featuresText}\n";
        }
        $prompt .= "\nLa description doit être en français, convaincante et optimisée pour le SEO.";
        
        return $this->chat([['content' => $prompt]]);
    }
    
    /**
     * Générer des meta descriptions SEO
     */
    public function generateMetaDescription($pageTitle, $pageContent) {
        $prompt = "Génère une meta description SEO optimisée (max 160 caractères) pour cette page:\n\n";
        $prompt .= "Titre: {$pageTitle}\n";
        $prompt .= "Contenu: " . substr($pageContent, 0, 500) . "...\n";
        $prompt .= "\nLa meta description doit être en français, attractive et contenir des mots-clés pertinents.";
        
        return $this->chat([['content' => $prompt]]);
    }
    
    /**
     * Analyser le sentiment d'un message
     */
    public function analyzeSentiment($text) {
        $prompt = "Analyse le sentiment de ce message et réponds uniquement par: positif, négatif ou neutre.\n\nMessage: {$text}";
        
        $response = $this->chat([['content' => $prompt]]);
        return strtolower(trim($response));
    }
    
    /**
     * Générer des suggestions de mots-clés
     */
    public function generateKeywords($topic, $count = 10) {
        $prompt = "Génère {$count} mots-clés SEO pertinents en français pour le sujet: {$topic}\n";
        $prompt .= "Réponds uniquement avec les mots-clés séparés par des virgules.";
        
        $response = $this->chat([['content' => $prompt]]);
        return array_map('trim', explode(',', $response));
    }
    
    /**
     * Répondre automatiquement à un message de contact
     */
    public function generateContactResponse($customerMessage) {
        $systemPrompt = "Tu es un assistant virtuel de Digita Marketing, une agence de marketing digital. ";
        $systemPrompt .= "Réponds de manière professionnelle, courtoise et utile aux messages des clients. ";
        $systemPrompt .= "Si tu ne peux pas répondre, propose de transférer à un conseiller humain.";
        
        return $this->chat([['content' => $customerMessage]], $systemPrompt);
    }
    
    /**
     * Générer un résumé de texte
     */
    public function summarize($text, $maxLength = 100) {
        $prompt = "Résume ce texte en maximum {$maxLength} mots, en français:\n\n{$text}";
        
        return $this->chat([['content' => $prompt]]);
    }
    
    /**
     * Traduire du texte
     */
    public function translate($text, $targetLanguage = 'en') {
        $prompt = "Traduis ce texte en {$targetLanguage}:\n\n{$text}";
        
        return $this->chat([['content' => $prompt]]);
    }
}
