<?php

require_once __DIR__ . '/Controller.php';

/**
 * Contrôleur Analytics Admin
 * Dashboard analytics avancé : trafic, conversions, revenus, formations, SEO
 */
class AnalyticsController extends Controller {
    
    private $db;
    
    public function __construct() {
        $this->requireAdmin();
        require_once __DIR__ . '/../../includes/Database.php';
        $this->db = Database::getInstance();
    }
    
    /**
     * Dashboard Analytics
     */
    public function index() {
        $period = $_GET['period'] ?? '30';
        $dateFrom = date('Y-m-d', strtotime("-{$period} days"));
        
        $data = [
            'pageTitle' => 'Analytics',
            'period' => $period,
            'traffic' => $this->getTrafficStats($dateFrom),
            'conversions' => $this->getConversionStats($dateFrom),
            'revenue' => $this->getRevenueStats($dateFrom),
            'formations' => $this->getFormationStats(),
            'tools' => $this->getToolStats($dateFrom),
            'chatbot' => $this->getChatbotStats($dateFrom),
            'leads' => $this->getLeadStats($dateFrom),
            'currentUser' => $this->getCurrentUser()
        ];
        
        $this->viewWithLayout('admin/analytics', $data);
    }
    
    /**
     * Statistiques de trafic
     */
    private function getTrafficStats($dateFrom) {
        $totalViews = $this->db->fetch(
            "SELECT COUNT(*) as total FROM page_views WHERE created_at >= ?",
            [$dateFrom]
        );
        
        $uniqueSessions = $this->db->fetch(
            "SELECT COUNT(DISTINCT session_id) as total FROM page_views WHERE created_at >= ?",
            [$dateFrom]
        );
        
        $topPages = $this->db->fetchAll(
            "SELECT page_url, COUNT(*) as views FROM page_views WHERE created_at >= ? GROUP BY page_url ORDER BY views DESC LIMIT 10",
            [$dateFrom]
        );
        
        $byDevice = $this->db->fetchAll(
            "SELECT device_type, COUNT(*) as total FROM page_views WHERE created_at >= ? GROUP BY device_type",
            [$dateFrom]
        );
        
        $bySource = $this->db->fetchAll(
            "SELECT COALESCE(utm_source, 'direct') as source, COUNT(*) as total FROM page_views WHERE created_at >= ? GROUP BY source ORDER BY total DESC LIMIT 10",
            [$dateFrom]
        );
        
        $daily = $this->db->fetchAll(
            "SELECT DATE(created_at) as day, COUNT(*) as views FROM page_views WHERE created_at >= ? GROUP BY day ORDER BY day ASC",
            [$dateFrom]
        );
        
        return [
            'total_views' => $totalViews['total'] ?? 0,
            'unique_sessions' => $uniqueSessions['total'] ?? 0,
            'top_pages' => $topPages,
            'by_device' => $byDevice,
            'by_source' => $bySource,
            'daily' => $daily
        ];
    }
    
    /**
     * Statistiques de conversions
     */
    private function getConversionStats($dateFrom) {
        $total = $this->db->fetch(
            "SELECT COUNT(*) as total FROM conversions WHERE created_at >= ?",
            [$dateFrom]
        );
        
        $byType = $this->db->fetchAll(
            "SELECT event_type, COUNT(*) as total, COALESCE(SUM(value), 0) as total_value FROM conversions WHERE created_at >= ? GROUP BY event_type ORDER BY total DESC",
            [$dateFrom]
        );
        
        $bySource = $this->db->fetchAll(
            "SELECT COALESCE(source, 'direct') as source, COUNT(*) as total FROM conversions WHERE created_at >= ? GROUP BY source ORDER BY total DESC LIMIT 10",
            [$dateFrom]
        );
        
        $daily = $this->db->fetchAll(
            "SELECT DATE(created_at) as day, COUNT(*) as total FROM conversions WHERE created_at >= ? GROUP BY day ORDER BY day ASC",
            [$dateFrom]
        );
        
        return [
            'total' => $total['total'] ?? 0,
            'by_type' => $byType,
            'by_source' => $bySource,
            'daily' => $daily
        ];
    }
    
    /**
     * Statistiques de revenus
     */
    private function getRevenueStats($dateFrom) {
        $totalRevenue = $this->db->fetch(
            "SELECT COALESCE(SUM(total_amount), 0) as total FROM orders WHERE status = 'completed' AND created_at >= ?",
            [$dateFrom]
        );
        
        $orderCount = $this->db->fetch(
            "SELECT COUNT(*) as total FROM orders WHERE status = 'completed' AND created_at >= ?",
            [$dateFrom]
        );
        
        $avgOrder = $this->db->fetch(
            "SELECT COALESCE(AVG(total_amount), 0) as avg_amount FROM orders WHERE status = 'completed' AND created_at >= ?",
            [$dateFrom]
        );
        
        $monthly = $this->db->fetchAll(
            "SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COALESCE(SUM(total_amount), 0) as revenue, COUNT(*) as orders FROM orders WHERE status = 'completed' GROUP BY month ORDER BY month DESC LIMIT 12"
        );
        
        $projectRevenue = $this->db->fetch(
            "SELECT COALESCE(SUM(price), 0) as total FROM client_projects WHERE status = 'completed' AND paid = 1 AND completed_at >= ?",
            [$dateFrom]
        );
        
        return [
            'total' => $totalRevenue['total'] ?? 0,
            'orders' => $orderCount['total'] ?? 0,
            'avg_order' => round($avgOrder['avg_amount'] ?? 0, 2),
            'monthly' => $monthly,
            'project_revenue' => $projectRevenue['total'] ?? 0
        ];
    }
    
    /**
     * Statistiques formations
     */
    private function getFormationStats() {
        $totalEnrollments = $this->db->fetch(
            "SELECT COUNT(*) as total FROM user_formations"
        );
        
        $completionRate = $this->db->fetch(
            "SELECT 
                COUNT(CASE WHEN progress = 100 THEN 1 END) as completed,
                COUNT(*) as total
             FROM user_formations"
        );
        
        $topFormations = $this->db->fetchAll(
            "SELECT f.title, COUNT(uf.id) as enrollments, AVG(uf.progress) as avg_progress
             FROM formations f
             LEFT JOIN user_formations uf ON f.id = uf.formation_id
             GROUP BY f.id, f.title
             HAVING enrollments > 0
             ORDER BY enrollments DESC
             LIMIT 10"
        );
        
        $totalCertificates = $this->db->fetch(
            "SELECT COUNT(*) as total FROM certificates"
        );
        
        $rate = ($completionRate['total'] ?? 0) > 0 
            ? round(($completionRate['completed'] / $completionRate['total']) * 100, 1) 
            : 0;
        
        return [
            'total_enrollments' => $totalEnrollments['total'] ?? 0,
            'completion_rate' => $rate,
            'top_formations' => $topFormations,
            'total_certificates' => $totalCertificates['total'] ?? 0
        ];
    }
    
    /**
     * Statistiques outils gratuits
     */
    private function getToolStats($dateFrom) {
        $byTool = $this->db->fetchAll(
            "SELECT tool_name, COUNT(*) as uses FROM tool_usage WHERE created_at >= ? GROUP BY tool_name ORDER BY uses DESC",
            [$dateFrom]
        );
        
        $total = $this->db->fetch(
            "SELECT COUNT(*) as total FROM tool_usage WHERE created_at >= ?",
            [$dateFrom]
        );
        
        return [
            'total' => $total['total'] ?? 0,
            'by_tool' => $byTool
        ];
    }
    
    /**
     * Statistiques chatbot
     */
    private function getChatbotStats($dateFrom) {
        $conversations = $this->db->fetch(
            "SELECT COUNT(*) as total FROM chatbot_conversations WHERE created_at >= ?",
            [$dateFrom]
        );
        
        $messages = $this->db->fetch(
            "SELECT COUNT(*) as total FROM chatbot_messages cm JOIN chatbot_conversations cc ON cm.conversation_id = cc.id WHERE cc.created_at >= ?",
            [$dateFrom]
        );
        
        $qualified = $this->db->fetch(
            "SELECT COUNT(*) as total FROM chatbot_conversations WHERE is_qualified = 1 AND created_at >= ?",
            [$dateFrom]
        );
        
        return [
            'conversations' => $conversations['total'] ?? 0,
            'messages' => $messages['total'] ?? 0,
            'qualified' => $qualified['total'] ?? 0
        ];
    }
    
    /**
     * Statistiques leads
     */
    private function getLeadStats($dateFrom) {
        $total = $this->db->fetch(
            "SELECT COUNT(*) as total FROM lead_qualifications WHERE created_at >= ?",
            [$dateFrom]
        );
        
        $byStatus = $this->db->fetchAll(
            "SELECT status, COUNT(*) as total FROM lead_qualifications WHERE created_at >= ? GROUP BY status",
            [$dateFrom]
        );
        
        $avgScore = $this->db->fetch(
            "SELECT AVG(score) as avg_score FROM lead_qualifications WHERE created_at >= ?",
            [$dateFrom]
        );
        
        $appointments = $this->db->fetch(
            "SELECT COUNT(*) as total FROM appointments WHERE created_at >= ?",
            [$dateFrom]
        );
        
        return [
            'total' => $total['total'] ?? 0,
            'by_status' => $byStatus,
            'avg_score' => round($avgScore['avg_score'] ?? 0, 1),
            'appointments' => $appointments['total'] ?? 0
        ];
    }
    
    /**
     * Enregistrer un page view (AJAX, appelé depuis le frontend)
     */
    public function trackPageView() {
        header('Content-Type: application/json');
        
        $pageUrl = $_POST['page_url'] ?? $_SERVER['HTTP_REFERER'] ?? '';
        $referrer = $_POST['referrer'] ?? '';
        $sessionId = $_POST['session_id'] ?? session_id();
        
        // Détecter le device
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $deviceType = 'desktop';
        if (preg_match('/Mobile|Android|iPhone/i', $userAgent)) $deviceType = 'mobile';
        elseif (preg_match('/Tablet|iPad/i', $userAgent)) $deviceType = 'tablet';
        
        // Détecter le navigateur
        $browser = 'autre';
        if (strpos($userAgent, 'Chrome') !== false) $browser = 'Chrome';
        elseif (strpos($userAgent, 'Firefox') !== false) $browser = 'Firefox';
        elseif (strpos($userAgent, 'Safari') !== false) $browser = 'Safari';
        elseif (strpos($userAgent, 'Edge') !== false) $browser = 'Edge';
        
        try {
            $this->db->query(
                "INSERT INTO page_views (session_id, user_id, page_url, referrer, utm_source, utm_medium, utm_campaign, device_type, browser) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                [
                    $sessionId,
                    $_SESSION['user_id'] ?? null,
                    $pageUrl,
                    $referrer,
                    $_GET['utm_source'] ?? null,
                    $_GET['utm_medium'] ?? null,
                    $_GET['utm_campaign'] ?? null,
                    $deviceType,
                    $browser
                ]
            );
        } catch (Exception $e) {
            // Silencieux
        }
        
        echo json_encode(['success' => true]);
        exit();
    }
    
    /**
     * Enregistrer une conversion (AJAX)
     */
    public function trackConversion() {
        header('Content-Type: application/json');
        
        $eventType = $_POST['event_type'] ?? '';
        $eventData = $_POST['event_data'] ?? '{}';
        $value = (float)($_POST['value'] ?? 0);
        $source = $_POST['source'] ?? '';
        $pageUrl = $_POST['page_url'] ?? '';
        
        if (empty($eventType)) {
            echo json_encode(['success' => false]);
            exit();
        }
        
        try {
            $this->db->query(
                "INSERT INTO conversions (session_id, user_id, event_type, event_data, source, page_url, value) VALUES (?, ?, ?, ?, ?, ?, ?)",
                [
                    session_id(),
                    $_SESSION['user_id'] ?? null,
                    $eventType,
                    $eventData,
                    $source,
                    $pageUrl,
                    $value
                ]
            );
        } catch (Exception $e) {
            // Silencieux
        }
        
        echo json_encode(['success' => true]);
        exit();
    }
}
