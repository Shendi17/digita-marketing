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
    
    // ==================== CHATBOT CONTEXTUEL ====================
    
    /**
     * System prompt du chatbot Digita Marketing
     */
    public function getDigitaSystemPrompt($pageContext = '') {
        $prompt = "Tu es l'assistant virtuel de Digita Marketing, une agence de marketing digital basée à La Réunion (974). ";
        $prompt .= "Tu es professionnel, chaleureux et expert en marketing digital.\n\n";
        $prompt .= "SERVICES PROPOSÉS :\n";
        $prompt .= "- Création de sites web (vitrine, e-commerce, landing pages)\n";
        $prompt .= "- Stratégie SEO et référencement naturel\n";
        $prompt .= "- Marketing digital et réseaux sociaux\n";
        $prompt .= "- Formations en marketing digital (certifiantes)\n";
        $prompt .= "- Audit SEO gratuit\n";
        $prompt .= "- Automatisation par IA\n\n";
        $prompt .= "OBJECTIFS :\n";
        $prompt .= "1. Répondre aux questions des visiteurs de manière utile et précise\n";
        $prompt .= "2. Qualifier les prospects (nom, email, besoin, budget, urgence)\n";
        $prompt .= "3. Orienter vers les services ou formations adaptés\n";
        $prompt .= "4. Proposer un rendez-vous si le prospect est qualifié\n";
        $prompt .= "5. Rediriger vers un conseiller humain si nécessaire\n\n";
        $prompt .= "RÈGLES :\n";
        $prompt .= "- Réponds toujours en français\n";
        $prompt .= "- Sois concis (max 3-4 phrases par réponse)\n";
        $prompt .= "- Ne donne jamais de prix exact, propose un devis personnalisé\n";
        $prompt .= "- Si le visiteur donne son email ou demande un RDV, confirme et remercie\n";
        $prompt .= "- Utilise des emojis avec parcimonie pour rester professionnel\n";
        
        if (!empty($pageContext)) {
            $prompt .= "\nCONTEXTE : Le visiteur est actuellement sur la page : {$pageContext}\n";
        }
        
        $prompt .= "\nLIENS UTILES à mentionner quand pertinent :\n";
        $prompt .= "- Formations : /formations\n";
        $prompt .= "- Créer un projet : /projets/brief\n";
        $prompt .= "- Outils gratuits : /outils\n";
        $prompt .= "- Contact : /contact\n";
        $prompt .= "- Audit SEO gratuit : /outils/audit-seo\n";
        
        return $prompt;
    }
    
    /**
     * Réponse chatbot contextuelle avec historique
     */
    public function chatbotReply($userMessage, $conversationHistory = [], $pageContext = '') {
        $systemPrompt = $this->getDigitaSystemPrompt($pageContext);
        
        $messages = [];
        foreach ($conversationHistory as $msg) {
            $messages[] = [
                'role' => $msg['role'],
                'content' => $msg['content']
            ];
        }
        $messages[] = ['role' => 'user', 'content' => $userMessage];
        
        return $this->chat($messages, $systemPrompt);
    }
    
    /**
     * Détecter l'intention du message utilisateur
     */
    public function detectIntent($message) {
        $prompt = "Analyse ce message et identifie l'intention principale. Réponds UNIQUEMENT par un mot-clé parmi : ";
        $prompt .= "info, devis, formation, rdv, support, contact, prix, seo, site_web, autre\n\n";
        $prompt .= "Message : {$message}";
        
        $response = $this->chat([['content' => $prompt]]);
        return strtolower(trim($response));
    }
    
    /**
     * Extraire les informations de contact du message
     */
    public function extractContactInfo($conversationText) {
        $prompt = "Extrais les informations de contact de cette conversation. ";
        $prompt .= "Réponds UNIQUEMENT en JSON avec les clés : name, email, phone, company, project_type, budget, urgency (low/medium/high). ";
        $prompt .= "Mets null pour les champs non trouvés.\n\n";
        $prompt .= "Conversation :\n{$conversationText}";
        
        $response = $this->chat([['content' => $prompt]]);
        $data = json_decode($response, true);
        
        return is_array($data) ? $data : [];
    }
    
    /**
     * Calculer un score de qualification lead
     */
    public function calculateLeadScore($leadData) {
        $score = 0;
        
        if (!empty($leadData['email'])) $score += 20;
        if (!empty($leadData['phone'])) $score += 15;
        if (!empty($leadData['name'])) $score += 10;
        if (!empty($leadData['company'])) $score += 10;
        if (!empty($leadData['project_type'])) $score += 15;
        if (!empty($leadData['budget'])) $score += 15;
        
        if (($leadData['urgency'] ?? '') === 'high') $score += 15;
        elseif (($leadData['urgency'] ?? '') === 'medium') $score += 10;
        else $score += 5;
        
        return min($score, 100);
    }
    
    // ==================== OUTILS GRATUITS IA ====================
    
    /**
     * Audit SEO d'une URL (analyse côté serveur)
     */
    public function auditSEO($url) {
        $result = [
            'url' => $url,
            'score' => 0,
            'checks' => [],
            'recommendations' => []
        ];
        
        // Récupérer la page
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Digita-SEO-Audit/1.0');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $html = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $loadTime = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
        $sslVerify = curl_getinfo($ch, CURLINFO_SSL_VERIFYRESULT);
        curl_close($ch);
        
        if (!$html || $httpCode >= 400) {
            $result['error'] = 'Impossible d\'accéder à l\'URL (HTTP ' . $httpCode . ')';
            return $result;
        }
        
        $points = 0;
        $maxPoints = 0;
        
        // 1. Title
        $maxPoints += 10;
        preg_match('/<title>(.*?)<\/title>/is', $html, $titleMatch);
        $title = $titleMatch[1] ?? '';
        if (!empty($title)) {
            $titleLen = mb_strlen($title);
            if ($titleLen >= 30 && $titleLen <= 60) {
                $points += 10;
                $result['checks'][] = ['name' => 'Balise Title', 'status' => 'good', 'detail' => $title . ' (' . $titleLen . ' car.)'];
            } else {
                $points += 5;
                $result['checks'][] = ['name' => 'Balise Title', 'status' => 'warning', 'detail' => 'Longueur non optimale (' . $titleLen . ' car., idéal 30-60)'];
                $result['recommendations'][] = 'Ajustez la longueur du title entre 30 et 60 caractères.';
            }
        } else {
            $result['checks'][] = ['name' => 'Balise Title', 'status' => 'error', 'detail' => 'Absente'];
            $result['recommendations'][] = 'Ajoutez une balise <title> unique et descriptive.';
        }
        
        // 2. Meta Description
        $maxPoints += 10;
        preg_match('/<meta\s+name=["\']description["\']\s+content=["\'](.*?)["\']/is', $html, $descMatch);
        $metaDesc = $descMatch[1] ?? '';
        if (!empty($metaDesc)) {
            $descLen = mb_strlen($metaDesc);
            if ($descLen >= 120 && $descLen <= 160) {
                $points += 10;
                $result['checks'][] = ['name' => 'Meta Description', 'status' => 'good', 'detail' => mb_strimwidth($metaDesc, 0, 80, '...') . ' (' . $descLen . ' car.)'];
            } else {
                $points += 5;
                $result['checks'][] = ['name' => 'Meta Description', 'status' => 'warning', 'detail' => 'Longueur non optimale (' . $descLen . ' car., idéal 120-160)'];
                $result['recommendations'][] = 'Ajustez la meta description entre 120 et 160 caractères.';
            }
        } else {
            $result['checks'][] = ['name' => 'Meta Description', 'status' => 'error', 'detail' => 'Absente'];
            $result['recommendations'][] = 'Ajoutez une meta description unique et attractive.';
        }
        
        // 3. H1
        $maxPoints += 10;
        preg_match_all('/<h1[^>]*>(.*?)<\/h1>/is', $html, $h1Matches);
        $h1Count = count($h1Matches[1]);
        if ($h1Count === 1) {
            $points += 10;
            $result['checks'][] = ['name' => 'Balise H1', 'status' => 'good', 'detail' => strip_tags($h1Matches[1][0])];
        } elseif ($h1Count > 1) {
            $points += 5;
            $result['checks'][] = ['name' => 'Balise H1', 'status' => 'warning', 'detail' => $h1Count . ' balises H1 trouvées (1 seule recommandée)'];
            $result['recommendations'][] = 'Utilisez une seule balise H1 par page.';
        } else {
            $result['checks'][] = ['name' => 'Balise H1', 'status' => 'error', 'detail' => 'Aucune balise H1'];
            $result['recommendations'][] = 'Ajoutez une balise H1 unique contenant le mot-clé principal.';
        }
        
        // 4. Images alt
        $maxPoints += 10;
        preg_match_all('/<img[^>]*>/is', $html, $imgMatches);
        $totalImages = count($imgMatches[0]);
        $imagesWithAlt = 0;
        foreach ($imgMatches[0] as $img) {
            if (preg_match('/alt=["\'][^"\']+["\']/i', $img)) $imagesWithAlt++;
        }
        if ($totalImages === 0) {
            $points += 10;
            $result['checks'][] = ['name' => 'Images Alt', 'status' => 'good', 'detail' => 'Aucune image trouvée'];
        } elseif ($imagesWithAlt === $totalImages) {
            $points += 10;
            $result['checks'][] = ['name' => 'Images Alt', 'status' => 'good', 'detail' => $totalImages . '/' . $totalImages . ' images avec alt'];
        } else {
            $ratio = round(($imagesWithAlt / $totalImages) * 100);
            $points += round(($imagesWithAlt / $totalImages) * 10);
            $result['checks'][] = ['name' => 'Images Alt', 'status' => $ratio > 50 ? 'warning' : 'error', 'detail' => $imagesWithAlt . '/' . $totalImages . ' images avec alt (' . $ratio . '%)'];
            $result['recommendations'][] = 'Ajoutez des attributs alt descriptifs à toutes les images.';
        }
        
        // 5. HTTPS
        $maxPoints += 10;
        if (strpos($url, 'https://') === 0) {
            $points += 10;
            $result['checks'][] = ['name' => 'HTTPS', 'status' => 'good', 'detail' => 'Connexion sécurisée'];
        } else {
            $result['checks'][] = ['name' => 'HTTPS', 'status' => 'error', 'detail' => 'Site non sécurisé'];
            $result['recommendations'][] = 'Migrez votre site vers HTTPS pour la sécurité et le SEO.';
        }
        
        // 6. Temps de chargement
        $maxPoints += 10;
        if ($loadTime < 2) {
            $points += 10;
            $result['checks'][] = ['name' => 'Temps de chargement', 'status' => 'good', 'detail' => round($loadTime, 2) . 's'];
        } elseif ($loadTime < 4) {
            $points += 5;
            $result['checks'][] = ['name' => 'Temps de chargement', 'status' => 'warning', 'detail' => round($loadTime, 2) . 's (idéal < 2s)'];
            $result['recommendations'][] = 'Optimisez le temps de chargement (compression, cache, images).';
        } else {
            $result['checks'][] = ['name' => 'Temps de chargement', 'status' => 'error', 'detail' => round($loadTime, 2) . 's (trop lent)'];
            $result['recommendations'][] = 'Votre site est trop lent. Optimisez les performances.';
        }
        
        // 7. Viewport (mobile)
        $maxPoints += 10;
        if (preg_match('/<meta\s+name=["\']viewport["\']/i', $html)) {
            $points += 10;
            $result['checks'][] = ['name' => 'Mobile (viewport)', 'status' => 'good', 'detail' => 'Balise viewport présente'];
        } else {
            $result['checks'][] = ['name' => 'Mobile (viewport)', 'status' => 'error', 'detail' => 'Balise viewport absente'];
            $result['recommendations'][] = 'Ajoutez une balise meta viewport pour le responsive.';
        }
        
        // 8. Open Graph
        $maxPoints += 10;
        if (preg_match('/<meta\s+property=["\']og:/i', $html)) {
            $points += 10;
            $result['checks'][] = ['name' => 'Open Graph', 'status' => 'good', 'detail' => 'Balises OG présentes'];
        } else {
            $result['checks'][] = ['name' => 'Open Graph', 'status' => 'warning', 'detail' => 'Balises OG absentes'];
            $result['recommendations'][] = 'Ajoutez des balises Open Graph pour un meilleur partage social.';
        }
        
        // 9. Liens internes
        $maxPoints += 10;
        preg_match_all('/<a\s+[^>]*href=["\']([^"\']*)["\'][^>]*>/i', $html, $linkMatches);
        $internalLinks = 0;
        $externalLinks = 0;
        $parsedUrl = parse_url($url);
        $domain = $parsedUrl['host'] ?? '';
        foreach ($linkMatches[1] as $link) {
            if (strpos($link, '/') === 0 || strpos($link, $domain) !== false) {
                $internalLinks++;
            } elseif (strpos($link, 'http') === 0) {
                $externalLinks++;
            }
        }
        if ($internalLinks >= 3) {
            $points += 10;
            $result['checks'][] = ['name' => 'Liens internes', 'status' => 'good', 'detail' => $internalLinks . ' liens internes, ' . $externalLinks . ' externes'];
        } elseif ($internalLinks > 0) {
            $points += 5;
            $result['checks'][] = ['name' => 'Liens internes', 'status' => 'warning', 'detail' => $internalLinks . ' liens internes (ajoutez-en plus)'];
            $result['recommendations'][] = 'Ajoutez plus de liens internes pour améliorer le maillage.';
        } else {
            $result['checks'][] = ['name' => 'Liens internes', 'status' => 'error', 'detail' => 'Aucun lien interne'];
            $result['recommendations'][] = 'Ajoutez des liens internes vers vos pages importantes.';
        }
        
        // 10. Schema.org
        $maxPoints += 10;
        if (preg_match('/application\/ld\+json/i', $html) || preg_match('/itemtype=["\']https?:\/\/schema\.org/i', $html)) {
            $points += 10;
            $result['checks'][] = ['name' => 'Schema.org', 'status' => 'good', 'detail' => 'Données structurées détectées'];
        } else {
            $result['checks'][] = ['name' => 'Schema.org', 'status' => 'warning', 'detail' => 'Aucune donnée structurée'];
            $result['recommendations'][] = 'Ajoutez des données structurées Schema.org (JSON-LD).';
        }
        
        $result['score'] = $maxPoints > 0 ? round(($points / $maxPoints) * 100) : 0;
        $result['title'] = $title;
        $result['meta_description'] = $metaDesc;
        $result['load_time'] = round($loadTime, 2);
        $result['images_count'] = $totalImages;
        $result['links_internal'] = $internalLinks;
        $result['links_external'] = $externalLinks;
        
        return $result;
    }
    
    /**
     * Générer un calendrier éditorial
     */
    public function generateEditorialCalendar($niche, $duration = '1 mois', $frequency = '3 par semaine') {
        $prompt = "Génère un calendrier éditorial pour un blog dans la niche \"{$niche}\".\n";
        $prompt .= "Durée : {$duration}\n";
        $prompt .= "Fréquence : {$frequency}\n\n";
        $prompt .= "Pour chaque article, donne :\n";
        $prompt .= "- Date de publication\n";
        $prompt .= "- Titre de l'article (optimisé SEO)\n";
        $prompt .= "- Mot-clé principal\n";
        $prompt .= "- Type de contenu (guide, liste, étude de cas, tutoriel, actualité)\n";
        $prompt .= "- Résumé en 1 phrase\n\n";
        $prompt .= "Réponds en format structuré, clair et actionnable.";
        
        return $this->chat([['content' => $prompt]], null);
    }
    
    /**
     * Analyser la concurrence d'un mot-clé
     */
    public function analyzeCompetition($keyword, $niche = '') {
        $prompt = "Analyse la concurrence SEO pour le mot-clé \"{$keyword}\"";
        if (!empty($niche)) $prompt .= " dans la niche \"{$niche}\"";
        $prompt .= ".\n\nDonne :\n";
        $prompt .= "1. Difficulté estimée (facile/moyen/difficile)\n";
        $prompt .= "2. Volume de recherche estimé (faible/moyen/élevé)\n";
        $prompt .= "3. Intention de recherche (informationnelle/transactionnelle/navigationnelle)\n";
        $prompt .= "4. 5 mots-clés longue traîne associés\n";
        $prompt .= "5. Stratégie de contenu recommandée\n";
        $prompt .= "6. Type de contenu à créer\n";
        
        return $this->chat([['content' => $prompt]]);
    }
    
    /**
     * Calculer le ROI marketing estimé
     */
    public static function calculateROI($params) {
        $budget = (float)($params['budget'] ?? 0);
        $cpc = (float)($params['cpc'] ?? 1.5);
        $conversionRate = (float)($params['conversion_rate'] ?? 2) / 100;
        $avgOrderValue = (float)($params['avg_order_value'] ?? 100);
        $margin = (float)($params['margin'] ?? 30) / 100;
        
        if ($budget <= 0 || $cpc <= 0) {
            return ['error' => 'Budget et CPC doivent être supérieurs à 0'];
        }
        
        $clicks = floor($budget / $cpc);
        $conversions = floor($clicks * $conversionRate);
        $revenue = $conversions * $avgOrderValue;
        $profit = $revenue * $margin;
        $roi = $budget > 0 ? round((($profit - $budget) / $budget) * 100, 1) : 0;
        $cpa = $conversions > 0 ? round($budget / $conversions, 2) : 0;
        
        return [
            'budget' => $budget,
            'clicks' => $clicks,
            'conversions' => $conversions,
            'revenue' => round($revenue, 2),
            'profit' => round($profit, 2),
            'roi' => $roi,
            'cpa' => $cpa,
            'roas' => $budget > 0 ? round($revenue / $budget, 2) : 0
        ];
    }
}
