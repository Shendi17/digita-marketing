<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Services/AIService.php';
require_once __DIR__ . '/../Helpers/ViewHelper.php';

/**
 * Contrôleur Outils Gratuits (Lead Magnets)
 * Audit SEO, générateur meta, calculateur ROI, calendrier éditorial
 */
class ToolsController extends Controller {
    
    private $aiService;
    
    public function __construct() {
        $this->aiService = new AIService();
    }
    
    /**
     * Page index des outils gratuits
     */
    public function index() {
        $data = [
            'title' => 'Outils Gratuits Marketing Digital — Digita Marketing',
            'metaDescription' => 'Outils gratuits pour booster votre marketing digital : audit SEO, générateur de meta descriptions, calculateur ROI, calendrier éditorial.'
        ];
        
        ViewHelper::render('outils/index-content', $data);
    }
    
    /**
     * Audit SEO gratuit
     */
    public function seoAudit() {
        $result = null;
        $url = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $url = trim($_POST['url'] ?? '');
            
            if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
                $_SESSION['error_message'] = 'Veuillez entrer une URL valide (ex: https://example.com)';
            } else {
                $result = $this->aiService->auditSEO($url);
                $this->trackToolUsage('seo_audit', ['url' => $url], 'Score: ' . ($result['score'] ?? 0) . '/100');
            }
        }
        
        $data = [
            'title' => 'Audit SEO Gratuit — Digita Marketing',
            'metaDescription' => 'Analysez gratuitement le SEO de votre site web. Score, recommandations et plan d\'action personnalisé.',
            'result' => $result,
            'url' => $url
        ];
        
        ViewHelper::render('outils/seo-audit-content', $data);
    }
    
    /**
     * Générateur de meta descriptions
     */
    public function metaGenerator() {
        $result = null;
        $pageTitle = '';
        $pageContent = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pageTitle = trim($_POST['page_title'] ?? '');
            $pageContent = trim($_POST['page_content'] ?? '');
            
            if (empty($pageTitle)) {
                $_SESSION['error_message'] = 'Le titre de la page est requis.';
            } else {
                try {
                    $result = $this->aiService->generateMetaDescription($pageTitle, $pageContent);
                    $this->trackToolUsage('meta_generator', ['title' => $pageTitle], mb_strimwidth($result, 0, 100, '...'));
                } catch (Exception $e) {
                    $_SESSION['error_message'] = 'Erreur lors de la génération. Vérifiez votre clé API OpenAI.';
                }
            }
        }
        
        $data = [
            'title' => 'Générateur de Meta Descriptions IA — Digita Marketing',
            'metaDescription' => 'Générez des meta descriptions SEO optimisées grâce à l\'IA. Gratuit et instantané.',
            'result' => $result,
            'pageTitle' => $pageTitle,
            'pageContent' => $pageContent
        ];
        
        ViewHelper::render('outils/meta-generator-content', $data);
    }
    
    /**
     * Calculateur de ROI marketing
     */
    public function roiCalculator() {
        $result = null;
        $params = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $params = [
                'budget' => $_POST['budget'] ?? 1000,
                'cpc' => $_POST['cpc'] ?? 1.5,
                'conversion_rate' => $_POST['conversion_rate'] ?? 2,
                'avg_order_value' => $_POST['avg_order_value'] ?? 100,
                'margin' => $_POST['margin'] ?? 30
            ];
            
            $result = AIService::calculateROI($params);
            $this->trackToolUsage('roi_calculator', $params, 'ROI: ' . ($result['roi'] ?? 0) . '%');
        }
        
        $data = [
            'title' => 'Calculateur de ROI Marketing — Digita Marketing',
            'metaDescription' => 'Calculez le retour sur investissement de vos campagnes marketing. Outil gratuit et interactif.',
            'result' => $result,
            'params' => $params
        ];
        
        ViewHelper::render('outils/roi-calculator-content', $data);
    }
    
    /**
     * Générateur de calendrier éditorial
     */
    public function editorialCalendar() {
        $result = null;
        $niche = '';
        $duration = '1 mois';
        $frequency = '3 par semaine';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $niche = trim($_POST['niche'] ?? '');
            $duration = $_POST['duration'] ?? '1 mois';
            $frequency = $_POST['frequency'] ?? '3 par semaine';
            
            if (empty($niche)) {
                $_SESSION['error_message'] = 'Veuillez indiquer votre niche / secteur d\'activité.';
            } else {
                try {
                    $result = $this->aiService->generateEditorialCalendar($niche, $duration, $frequency);
                    $this->trackToolUsage('editorial_calendar', ['niche' => $niche, 'duration' => $duration], 'Calendrier généré');
                } catch (Exception $e) {
                    $_SESSION['error_message'] = 'Erreur lors de la génération. Vérifiez votre clé API OpenAI.';
                }
            }
        }
        
        $data = [
            'title' => 'Générateur de Calendrier Éditorial IA — Digita Marketing',
            'metaDescription' => 'Générez un calendrier éditorial personnalisé pour votre blog grâce à l\'IA. Gratuit.',
            'result' => $result,
            'niche' => $niche,
            'duration' => $duration,
            'frequency' => $frequency
        ];
        
        ViewHelper::render('outils/editorial-calendar-content', $data);
    }
    
    /**
     * Calculateur ROI en AJAX
     */
    public function ajaxRoi() {
        header('Content-Type: application/json');
        
        $params = [
            'budget' => $_POST['budget'] ?? 1000,
            'cpc' => $_POST['cpc'] ?? 1.5,
            'conversion_rate' => $_POST['conversion_rate'] ?? 2,
            'avg_order_value' => $_POST['avg_order_value'] ?? 100,
            'margin' => $_POST['margin'] ?? 30
        ];
        
        $result = AIService::calculateROI($params);
        echo json_encode(['success' => true, 'result' => $result]);
        exit();
    }
    
    /**
     * Tracker l'utilisation des outils
     */
    private function trackToolUsage($toolName, $inputData, $resultSummary = null) {
        try {
            require_once __DIR__ . '/../Models/Model.php';
            $db = Database::getInstance();
            $db->query(
                "INSERT INTO tool_usage (tool_name, user_id, visitor_ip, input_data, result_summary) VALUES (?, ?, ?, ?, ?)",
                [
                    $toolName,
                    $_SESSION['user_id'] ?? null,
                    $_SERVER['REMOTE_ADDR'] ?? '',
                    json_encode($inputData, JSON_UNESCAPED_UNICODE),
                    $resultSummary
                ]
            );
        } catch (Exception $e) {
            // Silencieux — le tracking ne doit pas bloquer l'outil
        }
    }
}
