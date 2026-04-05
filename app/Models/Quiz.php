<?php

require_once __DIR__ . '/../../includes/Database.php';

/**
 * Modèle Quiz
 * Gère les quiz, questions, réponses et tentatives
 */
class Quiz {
    
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // ==================== QUIZ ====================
    
    /**
     * Récupérer un quiz par son ID
     */
    public function getById($id) {
        return $this->db->fetch(
            'SELECT q.*, fm.title as module_title, fm.formation_id
             FROM quizzes q
             LEFT JOIN formation_modules fm ON q.module_id = fm.id
             WHERE q.id = ?',
            [$id]
        );
    }
    
    /**
     * Récupérer le quiz d'un module
     */
    public function getByModuleId($moduleId) {
        return $this->db->fetch(
            'SELECT * FROM quizzes WHERE module_id = ? AND is_active = 1',
            [$moduleId]
        );
    }
    
    /**
     * Récupérer tous les quiz d'une formation
     */
    public function getByFormationId($formationId) {
        return $this->db->query(
            'SELECT q.*, fm.title as module_title, fm.order_num
             FROM quizzes q
             JOIN formation_modules fm ON q.module_id = fm.id
             WHERE fm.formation_id = ? AND q.is_active = 1
             ORDER BY fm.order_num',
            [$formationId]
        )->fetchAll();
    }
    
    /**
     * Créer un quiz
     */
    public function create($data) {
        $this->db->query(
            'INSERT INTO quizzes (module_id, title, description, passing_score, time_limit_minutes, max_attempts)
             VALUES (?, ?, ?, ?, ?, ?)',
            [
                $data['module_id'],
                $data['title'],
                $data['description'] ?? null,
                $data['passing_score'] ?? 70,
                $data['time_limit_minutes'] ?? 0,
                $data['max_attempts'] ?? 3
            ]
        );
        return $this->db->lastInsertId();
    }
    
    /**
     * Mettre à jour un quiz
     */
    public function update($id, $data) {
        $this->db->query(
            'UPDATE quizzes SET title = ?, description = ?, passing_score = ?, 
             time_limit_minutes = ?, max_attempts = ?, is_active = ?
             WHERE id = ?',
            [
                $data['title'],
                $data['description'] ?? null,
                $data['passing_score'] ?? 70,
                $data['time_limit_minutes'] ?? 0,
                $data['max_attempts'] ?? 3,
                $data['is_active'] ?? 1,
                $id
            ]
        );
    }
    
    /**
     * Supprimer un quiz
     */
    public function delete($id) {
        $this->db->query('DELETE FROM quizzes WHERE id = ?', [$id]);
    }
    
    // ==================== QUESTIONS ====================
    
    /**
     * Récupérer les questions d'un quiz avec leurs réponses
     */
    public function getQuestions($quizId) {
        $questions = $this->db->query(
            'SELECT * FROM quiz_questions WHERE quiz_id = ? ORDER BY order_num',
            [$quizId]
        )->fetchAll();
        
        foreach ($questions as &$question) {
            $question['answers'] = $this->db->query(
                'SELECT * FROM quiz_answers WHERE question_id = ? ORDER BY order_num',
                [$question['id']]
            )->fetchAll();
        }
        
        return $questions;
    }
    
    /**
     * Ajouter une question
     */
    public function addQuestion($data) {
        $this->db->query(
            'INSERT INTO quiz_questions (quiz_id, question, question_type, explanation, points, order_num)
             VALUES (?, ?, ?, ?, ?, ?)',
            [
                $data['quiz_id'],
                $data['question'],
                $data['question_type'] ?? 'single',
                $data['explanation'] ?? null,
                $data['points'] ?? 1,
                $data['order_num'] ?? 0
            ]
        );
        return $this->db->lastInsertId();
    }
    
    /**
     * Ajouter une réponse à une question
     */
    public function addAnswer($data) {
        $this->db->query(
            'INSERT INTO quiz_answers (question_id, answer_text, is_correct, order_num)
             VALUES (?, ?, ?, ?)',
            [
                $data['question_id'],
                $data['answer_text'],
                $data['is_correct'] ?? 0,
                $data['order_num'] ?? 0
            ]
        );
        return $this->db->lastInsertId();
    }
    
    /**
     * Supprimer une question et ses réponses
     */
    public function deleteQuestion($questionId) {
        $this->db->query('DELETE FROM quiz_questions WHERE id = ?', [$questionId]);
    }
    
    // ==================== TENTATIVES ====================
    
    /**
     * Démarrer une tentative de quiz
     */
    public function startAttempt($userId, $quizId) {
        $quiz = $this->getById($quizId);
        if (!$quiz) return null;
        
        // Vérifier le nombre de tentatives
        $attemptCount = $this->getAttemptCount($userId, $quizId);
        if ($quiz['max_attempts'] > 0 && $attemptCount >= $quiz['max_attempts']) {
            return null;
        }
        
        $this->db->query(
            'INSERT INTO quiz_attempts (user_id, quiz_id) VALUES (?, ?)',
            [$userId, $quizId]
        );
        return $this->db->lastInsertId();
    }
    
    /**
     * Soumettre les réponses d'un quiz
     */
    public function submitAttempt($attemptId, $answers) {
        $attempt = $this->db->fetch(
            'SELECT * FROM quiz_attempts WHERE id = ?',
            [$attemptId]
        );
        if (!$attempt) return null;
        
        $quiz = $this->getById($attempt['quiz_id']);
        $questions = $this->getQuestions($attempt['quiz_id']);
        
        $score = 0;
        $maxScore = 0;
        $results = [];
        
        foreach ($questions as $question) {
            $maxScore += $question['points'];
            $userAnswer = $answers[$question['id']] ?? null;
            $isCorrect = false;
            
            if ($question['question_type'] === 'single' || $question['question_type'] === 'true_false') {
                foreach ($question['answers'] as $answer) {
                    if ($answer['is_correct'] && $answer['id'] == $userAnswer) {
                        $isCorrect = true;
                        break;
                    }
                }
            } elseif ($question['question_type'] === 'multiple') {
                $correctIds = array_column(array_filter($question['answers'], function($a) { return $a['is_correct']; }), 'id');
                $userIds = is_array($userAnswer) ? $userAnswer : [];
                sort($correctIds);
                sort($userIds);
                $isCorrect = ($correctIds == $userIds);
            }
            
            if ($isCorrect) {
                $score += $question['points'];
            }
            
            $results[] = [
                'question_id' => $question['id'],
                'user_answer' => $userAnswer,
                'is_correct' => $isCorrect,
                'explanation' => $question['explanation']
            ];
        }
        
        $percentage = $maxScore > 0 ? round(($score / $maxScore) * 100, 2) : 0;
        $passed = $percentage >= $quiz['passing_score'];
        
        $this->db->query(
            'UPDATE quiz_attempts SET score = ?, max_score = ?, percentage = ?, passed = ?, 
             answers_json = ?, completed_at = NOW() WHERE id = ?',
            [$score, $maxScore, $percentage, $passed ? 1 : 0, json_encode($results), $attemptId]
        );
        
        return [
            'score' => $score,
            'max_score' => $maxScore,
            'percentage' => $percentage,
            'passed' => $passed,
            'results' => $results
        ];
    }
    
    /**
     * Nombre de tentatives d'un utilisateur pour un quiz
     */
    public function getAttemptCount($userId, $quizId) {
        $result = $this->db->fetch(
            'SELECT COUNT(*) as count FROM quiz_attempts WHERE user_id = ? AND quiz_id = ?',
            [$userId, $quizId]
        );
        return $result['count'];
    }
    
    /**
     * Meilleure tentative d'un utilisateur pour un quiz
     */
    public function getBestAttempt($userId, $quizId) {
        return $this->db->fetch(
            'SELECT * FROM quiz_attempts WHERE user_id = ? AND quiz_id = ? AND completed_at IS NOT NULL
             ORDER BY percentage DESC LIMIT 1',
            [$userId, $quizId]
        );
    }
    
    /**
     * Toutes les tentatives d'un utilisateur pour un quiz
     */
    public function getUserAttempts($userId, $quizId) {
        return $this->db->query(
            'SELECT * FROM quiz_attempts WHERE user_id = ? AND quiz_id = ?
             ORDER BY started_at DESC',
            [$userId, $quizId]
        )->fetchAll();
    }
    
    /**
     * L'utilisateur a-t-il réussi le quiz ?
     */
    public function hasPassed($userId, $quizId) {
        $result = $this->db->fetch(
            'SELECT id FROM quiz_attempts WHERE user_id = ? AND quiz_id = ? AND passed = 1 LIMIT 1',
            [$userId, $quizId]
        );
        return !empty($result);
    }
}
