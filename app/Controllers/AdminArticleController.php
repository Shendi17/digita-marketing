<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/Article.php';

/**
 * Contrôleur Admin Articles
 * Gère le CRUD des articles de blog depuis l'admin
 */
class AdminArticleController extends Controller {
    
    private $articleModel;
    
    public function __construct() {
        $this->requireAdmin();
        $this->articleModel = new Article();
    }
    
    /**
     * Liste des articles (admin)
     */
    public function index() {
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 20;
        $offset = ($page - 1) * $perPage;
        
        $status = $_GET['status'] ?? null;
        $categoryId = $_GET['category'] ?? null;
        $search = $_GET['q'] ?? null;
        
        $articles = $this->articleModel->getAll($perPage, $offset, $status, $categoryId, $search);
        $totalArticles = $this->articleModel->countAll($status, $categoryId, $search);
        $totalPages = ceil($totalArticles / $perPage);
        
        $categories = $this->articleModel->getAllCategories();
        $stats = $this->articleModel->getStats();
        
        $data = [
            'pageTitle' => 'Gestion des articles',
            'articles' => $articles,
            'categories' => $categories,
            'stats' => $stats,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalArticles' => $totalArticles,
            'filterStatus' => $status,
            'filterCategory' => $categoryId,
            'filterSearch' => $search,
            'currentUser' => $this->getCurrentUser()
        ];
        
        $this->viewWithLayout('admin/articles/index', $data);
    }
    
    /**
     * Formulaire de création d'article
     */
    public function create() {
        $categories = $this->articleModel->getAllCategories();
        
        $data = [
            'pageTitle' => 'Nouvel article',
            'categories' => $categories,
            'article' => null,
            'currentUser' => $this->getCurrentUser()
        ];
        
        $this->viewWithLayout('admin/articles/form', $data);
    }
    
    /**
     * Sauvegarder un nouvel article
     */
    public function store() {
        $data = $this->getFormData();
        
        if (empty($data['title'])) {
            $_SESSION['error_message'] = 'Le titre est obligatoire.';
            $this->redirect('/admin/articles/new');
            return;
        }
        
        $data['slug'] = $this->articleModel->generateSlug($data['title']);
        
        try {
            $id = $this->articleModel->create($data);
            $_SESSION['success_message'] = 'Article créé avec succès.';
            $this->redirect('/admin/articles/edit/' . $id);
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erreur lors de la création : ' . $e->getMessage();
            $this->redirect('/admin/articles/new');
        }
    }
    
    /**
     * Formulaire d'édition d'article
     */
    public function edit($id) {
        $article = $this->articleModel->getById($id);
        
        if (!$article) {
            $_SESSION['error_message'] = 'Article introuvable.';
            $this->redirect('/admin/articles');
            return;
        }
        
        $categories = $this->articleModel->getAllCategories();
        
        $data = [
            'pageTitle' => 'Modifier l\'article',
            'categories' => $categories,
            'article' => $article,
            'currentUser' => $this->getCurrentUser()
        ];
        
        $this->viewWithLayout('admin/articles/form', $data);
    }
    
    /**
     * Mettre à jour un article existant
     */
    public function update($id) {
        $article = $this->articleModel->getById($id);
        
        if (!$article) {
            $_SESSION['error_message'] = 'Article introuvable.';
            $this->redirect('/admin/articles');
            return;
        }
        
        $data = $this->getFormData();
        
        if (empty($data['title'])) {
            $_SESSION['error_message'] = 'Le titre est obligatoire.';
            $this->redirect('/admin/articles/edit/' . $id);
            return;
        }
        
        // Régénérer le slug si le titre a changé
        if ($data['title'] !== $article['title']) {
            $data['slug'] = $this->articleModel->generateSlug($data['title'], $id);
        } else {
            $data['slug'] = $article['slug'];
        }
        
        // Gestion de l'upload d'image
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = $this->handleImageUpload($_FILES['featured_image']);
            if ($imagePath) {
                $data['featured_image'] = $imagePath;
            }
        } else {
            $data['featured_image'] = $article['featured_image'];
        }
        
        try {
            $this->articleModel->update($id, $data);
            $_SESSION['success_message'] = 'Article mis à jour avec succès.';
            $this->redirect('/admin/articles/edit/' . $id);
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erreur lors de la mise à jour : ' . $e->getMessage();
            $this->redirect('/admin/articles/edit/' . $id);
        }
    }
    
    /**
     * Supprimer un article
     */
    public function delete($id) {
        $article = $this->articleModel->getById($id);
        
        if (!$article) {
            $_SESSION['error_message'] = 'Article introuvable.';
            $this->redirect('/admin/articles');
            return;
        }
        
        try {
            $this->articleModel->delete($id);
            $_SESSION['success_message'] = 'Article supprimé avec succès.';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erreur lors de la suppression : ' . $e->getMessage();
        }
        
        $this->redirect('/admin/articles');
    }
    
    /**
     * Upload d'image via AJAX (pour TinyMCE)
     */
    public function uploadImage() {
        header('Content-Type: application/json');
        
        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['error' => 'Aucun fichier uploadé']);
            exit();
        }
        
        $imagePath = $this->handleImageUpload($_FILES['file']);
        
        if ($imagePath) {
            echo json_encode(['location' => $imagePath]);
        } else {
            echo json_encode(['error' => 'Erreur lors de l\'upload']);
        }
        exit();
    }
    
    /**
     * Extraire les données du formulaire
     */
    private function getFormData() {
        return [
            'title' => trim($_POST['title'] ?? ''),
            'content' => $_POST['content'] ?? '',
            'excerpt' => trim($_POST['excerpt'] ?? ''),
            'category_id' => $_POST['category_id'] ?? null,
            'service_name' => trim($_POST['service_name'] ?? ''),
            'meta_title' => trim($_POST['meta_title'] ?? ''),
            'meta_description' => trim($_POST['meta_description'] ?? ''),
            'meta_keywords' => trim($_POST['meta_keywords'] ?? ''),
            'featured_image' => trim($_POST['featured_image_url'] ?? ''),
            'status' => $_POST['status'] ?? 'draft'
        ];
    }
    
    /**
     * Gérer l'upload d'une image
     */
    private function handleImageUpload($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        
        if (!in_array($file['type'], $allowedTypes)) {
            return null;
        }
        
        if ($file['size'] > $maxSize) {
            return null;
        }
        
        $uploadDir = __DIR__ . '/../../public/uploads/articles/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('article_') . '.' . $extension;
        $filepath = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return '/uploads/articles/' . $filename;
        }
        
        return null;
    }
}
