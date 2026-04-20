<?php

require_once __DIR__ . '/AIService.php';

/**
 * AgentOrchestrator - Le "Cerveau" de DIGITA
 * Gère la délégation aux agents spécialisés et la construction du brief client.
 */
class AgentOrchestrator {
    
    private $aiService;
    private $systemContext;
    
    // Définition des profils d'agents spécialisés
    private $agents = [
        'strategic' => [
            'name' => 'Consultant Stratégique Senior',
            'role' => 'Expert en business model, ROI et scaling digital.',
            'prompt' => "Tu es le Consultant Stratégique Senior de DIGITA. Ton focus est le ROI et la croissance business. Analyse les enjeux financiers, les cibles de marché et propose des solutions de haute volée (Automatisation, Tunnels de vente complexes). Ton ton est direct, expert et tourné vers les résultats."
        ],
        'seo' => [
            'name' => 'Architecte SEO & Performance',
            'role' => 'Expert en visibilité organique et structure technique.',
            'prompt' => "Tu es l'Architecte SEO de DIGITA. Tu vois le web comme une structure de données. Ton rôle est de maximiser l'autorité et la visibilité. Tu parles de sémantique, de maillage, de Core Web Vitals et de domination de SERP. Ton ton est technique mais pédagogue pour un décideur."
        ],
        'creative' => [
            'name' => 'Directeur de Création & Brand Content',
            'role' => 'Expert en storytelling et identité de prestige.',
            'prompt' => "Tu es le Directeur de Création de DIGITA. Ton focus est l'émotion et l'image de marque. Tu transformes des services en expériences. Tu parles de 'Tone of Voice', de psychologie du design et de rétention par le contenu. Ton ton est inspirant, élégant et premium."
        ]
    ];

    public function __construct() {
        $this->aiService = new AIService();
    }

    /**
     * Traiter une requête utilisateur via l'orchestrateur
     */
    public function processRequest($userMessage, $history = [], $clientBrief = []) {
        // 1. Identification de l'intention et de l'agent pertinent
        $intent = $this->routeIntention($userMessage, $history);
        $agentKey = $this->selectAgent($intent);
        
        // 2. Préparation du contexte pour l'agent choisi
        $agent = $this->agents[$agentKey] ?? $this->agents['strategic'];
        $fullPrompt = $this->buildFullPrompt($agent, $clientBrief);
        
        // 3. Appel à l'IA spécialisée
        return [
            'agent' => $agent['name'],
            'agent_key' => $agentKey,
            'response' => $this->aiService->chat($history, $fullPrompt),
            'intent' => $intent
        ];
    }

    /**
     * Déterminer l'agent le plus adapté
     */
    private function selectAgent($intent) {
        $map = [
            'seo' => 'seo',
            'site_web' => 'seo',
            'audit' => 'seo',
            'strategie' => 'strategic',
            'devis' => 'strategic',
            'prix' => 'strategic',
            'business' => 'strategic',
            'contenu' => 'creative',
            'image' => 'creative',
            'branding' => 'creative',
            'video' => 'creative'
        ];
        
        return $map[$intent] ?? 'strategic';
    }

    /**
     * Analyser l'intention avec l'aide de l'IA (routage intelligent)
     */
    private function routeIntention($message, $history = []) {
        $historyText = "";
        foreach(array_slice($history, -3) as $msg) {
            $historyText .= ($msg['role'] ?? 'user') . ": " . ($msg['content'] ?? '') . "\n";
        }
        
        $prompt = "Analyse le message de l'utilisateur et détermine l'expertise DIGITA requise.\n";
        $prompt .= "Contexte historique :\n{$historyText}\n";
        $prompt .= "Message : {$message}\n\n";
        $prompt .= "Réponds UNIQUEMENT par un mot-clé : seo, strategie, contenu, site_web, devis, branding, autre.";
        
        $response = $this->aiService->chat([], $prompt);
        return strtolower(trim($response));
    }

    /**
     * Assembler le prompt complet avec le brief client actuel
     */
    private function buildFullPrompt($agent, $clientBrief) {
        $prompt = "IDENTITÉ : {$agent['prompt']}\n\n";
        $prompt .= "CONTEXTE CLIENT ACTUEL :\n";
        if (empty($clientBrief)) {
            $prompt .= "- Aucun brief établi. Ton objectif est de poser 1 question stratégique pour mieux comprendre leur business.\n";
        } else {
            foreach ($clientBrief as $key => $value) {
                if ($value) $prompt .= "- {$key} : {$value}\n";
            }
        }
        
        $prompt .= "\nDIRECTIVES :\n";
        $prompt .= "1. Reste dans ton rôle d'expert.\n";
        $prompt .= "2. Sois proactif : si une info manque pour faire un devis, demande-la avec élégance.\n";
        $prompt .= "3. Ton de voix : Premium, Cabinet de Conseil, Professionnel, Rassurant.\n";
        $prompt .= "4. Si l'utilisateur semble prêt, propose un rendez-vous (/contact).\n";
        
        return $prompt;
    }
}
