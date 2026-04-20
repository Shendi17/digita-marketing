<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Services/AIService.php';
require_once __DIR__ . '/../Services/AgentOrchestrator.php';
require_once __DIR__ . '/../Services/ContextManager.php';

/**
 * Contrôleur Chatbot (v2.0)
 * Gère les conversations chatbot IA via un Orchestrateur d'Agents et une Mémoire Contextuelle.
 */
class ChatbotController extends Controller {
    
    private $aiService;
    private $orchestrator;
    private $contextManager;
    
    public function __construct() {
        $this->aiService = new AIService();
        $this->orchestrator = new AgentOrchestrator();
        $this->contextManager = new ContextManager();
    }
    
    /**
     * Envoyer un message au chatbot (AJAX)
     */
    public function sendMessage() {
        header('Content-Type: application/json');
        
        $userMessage = trim($_POST['message'] ?? '');
        $sessionId = $_POST['session_id'] ?? session_id();
        $pageContext = trim($_POST['page'] ?? '');
        
        if (empty($userMessage)) {
            echo json_encode(['success' => false, 'error' => 'Message vide']);
            exit();
        }
        
        try {
            require_once __DIR__ . '/../Models/Model.php';
            $db = Database::getInstance();
            
            // Trouver ou créer la conversation
            $conversation = $db->fetch(
                "SELECT * FROM chatbot_conversations WHERE session_id = ? ORDER BY created_at DESC LIMIT 1",
                [$sessionId]
            );
            
            if (!$conversation) {
                $userId = $_SESSION['user_id'] ?? null;
                $db->query(
                    "INSERT INTO chatbot_conversations (session_id, user_id, visitor_ip, visitor_page) VALUES (?, ?, ?, ?)",
                    [$sessionId, $userId, $_SERVER['REMOTE_ADDR'] ?? '', $pageContext]
                );
                $conversationId = $db->lastInsertId();
            } else {
                $conversationId = $conversation['id'];
            }
            
            // Sauvegarder le message utilisateur
            $db->query(
                "INSERT INTO chatbot_messages (conversation_id, role, content) VALUES (?, 'user', ?)",
                [$conversationId, $userMessage]
            );
            
            // Récupérer l'historique (derniers 10 messages)
            $history = $db->fetchAll(
                "SELECT role, content FROM chatbot_messages WHERE conversation_id = ? ORDER BY created_at DESC LIMIT 10",
                [$conversationId]
            );
            $history = array_reverse($history);
            
            // Récupérer le contexte business actuel (Brief)
            $clientBrief = $this->contextManager->getContext($sessionId, $_SESSION['user_id'] ?? null);
            
            // Générer la réponse via l'Orchestrateur d'Agents
            $orchestrationResult = $this->orchestrator->processRequest($userMessage, $history, $clientBrief);
            $reply = $orchestrationResult['response'];
            $activeAgent = $orchestrationResult['agent'];
            
            // Sauvegarder la réponse
            $db->query(
                "INSERT INTO chatbot_messages (conversation_id, role, content) VALUES (?, 'assistant', ?)",
                [$conversationId, $reply]
            );
            
            // Mettre à jour la conversation et extraire le nouveau contexte
            $db->query(
                "UPDATE chatbot_conversations SET updated_at = NOW() WHERE id = ?",
                [$conversationId]
            );
            
            // Tenter l'extraction de contexte business après 2 messages (pour enrichir le brief)
            if (($msgCount['cnt'] ?? 0) >= 2) {
                $this->updateInteractionContext($conversationId, $sessionId, $db);
            }
            
            echo json_encode([
                'success' => true,
                'reply' => $reply,
                'agent' => $activeAgent,
                'intent' => $orchestrationResult['intent'] ?? 'info',
                'conversation_id' => $conversationId
            ]);
            
        } catch (Exception $e) {
            // Fallback si l'IA n'est pas disponible
            $fallbackReply = $this->getFallbackReply($userMessage);
            echo json_encode([
                'success' => true,
                'reply' => $fallbackReply,
                'fallback' => true
            ]);
        }
        exit();
    }
    
    /**
     * Récupérer l'historique d'une conversation (AJAX)
     */
    public function getHistory() {
        header('Content-Type: application/json');
        
        $sessionId = $_GET['session_id'] ?? session_id();
        
        require_once __DIR__ . '/../Models/Model.php';
        $db = Database::getInstance();
        
        $conversation = $db->fetch(
            "SELECT * FROM chatbot_conversations WHERE session_id = ? ORDER BY created_at DESC LIMIT 1",
            [$sessionId]
        );
        
        if (!$conversation) {
            echo json_encode(['success' => true, 'messages' => []]);
            exit();
        }
        
        $messages = $db->fetchAll(
            "SELECT role, content, created_at FROM chatbot_messages WHERE conversation_id = ? ORDER BY created_at ASC",
            [$conversation['id']]
        );
        
        echo json_encode(['success' => true, 'messages' => $messages]);
        exit();
    }
    
    /**
     * Qualifier un lead manuellement (AJAX)
     */
    public function qualifyLead() {
        header('Content-Type: application/json');
        
        $conversationId = (int)($_POST['conversation_id'] ?? 0);
        if (!$conversationId) {
            echo json_encode(['success' => false, 'error' => 'ID conversation manquant']);
            exit();
        }
        
        require_once __DIR__ . '/../Models/Model.php';
        $db = Database::getInstance();
        
        $this->tryQualifyLead($conversationId, $db);
        
        echo json_encode(['success' => true]);
        exit();
    }
    
    /**
     * Prendre un rendez-vous (AJAX)
     */
    public function bookAppointment() {
        header('Content-Type: application/json');
        
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $date = $_POST['date'] ?? '';
        $timeSlot = $_POST['time_slot'] ?? '';
        $subject = trim($_POST['subject'] ?? '');
        
        if (empty($name) || empty($email) || empty($date) || empty($timeSlot)) {
            echo json_encode(['success' => false, 'error' => 'Champs obligatoires manquants (nom, email, date, créneau)']);
            exit();
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'error' => 'Email invalide']);
            exit();
        }
        
        require_once __DIR__ . '/../Models/Model.php';
        $db = Database::getInstance();
        
        // Vérifier la disponibilité du créneau
        $existing = $db->fetch(
            "SELECT id FROM appointments WHERE date = ? AND time_slot = ? AND status != 'cancelled'",
            [$date, $timeSlot]
        );
        
        if ($existing) {
            echo json_encode(['success' => false, 'error' => 'Ce créneau est déjà pris. Veuillez en choisir un autre.']);
            exit();
        }
        
        $db->query(
            "INSERT INTO appointments (name, email, phone, date, time_slot, subject, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)",
            [$name, $email, $phone, $date, $timeSlot, $subject, $_SESSION['user_id'] ?? null]
        );
        
        echo json_encode([
            'success' => true,
            'message' => 'Rendez-vous confirmé le ' . date('d/m/Y', strtotime($date)) . ' à ' . $timeSlot
        ]);
        exit();
    }
    
    /**
     * Créneaux disponibles (AJAX)
     */
    public function availableSlots() {
        header('Content-Type: application/json');
        
        $date = $_GET['date'] ?? date('Y-m-d', strtotime('+1 day'));
        
        $allSlots = ['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00'];
        
        require_once __DIR__ . '/../Models/Model.php';
        $db = Database::getInstance();
        
        $booked = $db->fetchAll(
            "SELECT time_slot FROM appointments WHERE date = ? AND status != 'cancelled'",
            [$date]
        );
        $bookedSlots = array_column($booked, 'time_slot');
        
        $available = array_values(array_diff($allSlots, $bookedSlots));
        
        echo json_encode(['success' => true, 'date' => $date, 'slots' => $available]);
        exit();
    }
    
    // ==================== PRIVÉ ====================
    
    /**
     * Tenter la qualification automatique d'un lead
     */
    private function tryQualifyLead($conversationId, $db) {
        // Récupérer tous les messages de la conversation
        $messages = $db->fetchAll(
            "SELECT role, content FROM chatbot_messages WHERE conversation_id = ? ORDER BY created_at ASC",
            [$conversationId]
        );
        
        $conversationText = '';
        foreach ($messages as $msg) {
            $conversationText .= ($msg['role'] === 'user' ? 'Visiteur' : 'Assistant') . ': ' . $msg['content'] . "\n";
        }
        
        try {
            $contactInfo = $this->aiService->extractContactInfo($conversationText);
            
            if (empty($contactInfo['email']) && empty($contactInfo['phone']) && empty($contactInfo['name'])) {
                return;
            }
            
            $score = $this->aiService->calculateLeadScore($contactInfo);
            
            // Vérifier si un lead existe déjà pour cette conversation
            $existingLead = $db->fetch(
                "SELECT id FROM lead_qualifications WHERE conversation_id = ?",
                [$conversationId]
            );
            
            if ($existingLead) {
                $db->query(
                    "UPDATE lead_qualifications SET name = ?, email = ?, phone = ?, company = ?, project_type = ?, budget = ?, urgency = ?, score = ? WHERE id = ?",
                    [
                        $contactInfo['name'] ?? null,
                        $contactInfo['email'] ?? null,
                        $contactInfo['phone'] ?? null,
                        $contactInfo['company'] ?? null,
                        $contactInfo['project_type'] ?? null,
                        $contactInfo['budget'] ?? null,
                        $contactInfo['urgency'] ?? 'medium',
                        $score,
                        $existingLead['id']
                    ]
                );
            } else {
                $db->query(
                    "INSERT INTO lead_qualifications (conversation_id, name, email, phone, company, project_type, budget, urgency, score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                    [
                        $conversationId,
                        $contactInfo['name'] ?? null,
                        $contactInfo['email'] ?? null,
                        $contactInfo['phone'] ?? null,
                        $contactInfo['company'] ?? null,
                        $contactInfo['project_type'] ?? null,
                        $contactInfo['budget'] ?? null,
                        $contactInfo['urgency'] ?? 'medium',
                        $score
                    ]
                );
            }
            
            // Marquer la conversation comme qualifiée
            $db->query(
                "UPDATE chatbot_conversations SET is_qualified = 1 WHERE id = ?",
                [$conversationId]
            );
            
        } catch (Exception $e) {
            error_log('Qualification lead échouée: ' . $e->getMessage());
        }
    }
    
    /**
     * Extraire et mettre à jour le contexte business au fil de la discussion
     */
    private function updateInteractionContext($conversationId, $sessionId, $db) {
        $messages = $db->fetchAll(
            "SELECT role, content FROM chatbot_messages WHERE conversation_id = ? ORDER BY created_at ASC",
            [$conversationId]
        );
        
        $conversationText = '';
        foreach ($messages as $msg) {
            $conversationText .= ($msg['role'] === 'user' ? 'Client' : 'Expert') . ': ' . $msg['content'] . "\n";
        }
        
        try {
            $newData = $this->aiService->extractBusinessContext($conversationText);
            if (!empty($newData)) {
                $this->contextManager->updateContext($sessionId, $newData, $_SESSION['user_id'] ?? null);
            }
        } catch (Exception $e) {
            error_log('Échec de la mise à jour du contexte business : ' . $e->getMessage());
        }
    }
    
    /**
     * Réponse de fallback si l'IA n'est pas disponible
     */
    private function getFallbackReply($message) {
        $message = mb_strtolower($message);
        
        if (strpos($message, 'prix') !== false || strpos($message, 'tarif') !== false || strpos($message, 'coût') !== false) {
            return "Nos tarifs dépendent de votre projet. Pour un devis personnalisé gratuit, rendez-vous sur notre page /projets/brief ou contactez-nous via /contact.";
        }
        if (strpos($message, 'formation') !== false || strpos($message, 'cours') !== false) {
            return "Nous proposons des formations certifiantes en marketing digital ! Découvrez notre catalogue sur /formations.";
        }
        if (strpos($message, 'seo') !== false || strpos($message, 'référencement') !== false) {
            return "Le SEO est notre spécialité ! Testez notre audit SEO gratuit sur /outils/audit-seo pour analyser votre site.";
        }
        if (strpos($message, 'site') !== false || strpos($message, 'web') !== false) {
            return "Nous créons des sites web professionnels adaptés à vos besoins. Décrivez votre projet sur /projets/brief pour recevoir un devis.";
        }
        if (strpos($message, 'rdv') !== false || strpos($message, 'rendez-vous') !== false || strpos($message, 'rencontrer') !== false) {
            return "Avec plaisir ! Contactez-nous via /contact pour planifier un rendez-vous avec notre équipe.";
        }
        if (strpos($message, 'bonjour') !== false || strpos($message, 'salut') !== false || strpos($message, 'hello') !== false) {
            return "Bonjour ! Bienvenue chez Digita Marketing. Comment puis-je vous aider aujourd'hui ? 😊";
        }
        
        return "Merci pour votre message ! Pour une réponse personnalisée, n'hésitez pas à nous contacter via /contact ou à décrire votre projet sur /projets/brief. Un conseiller vous répondra rapidement.";
    }
}
