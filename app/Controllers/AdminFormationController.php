<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/Formation.php';

/**
 * Contrôleur Admin Formations
 * Gère le CRUD des formations depuis l'admin
 */
class AdminFormationController extends Controller {
    
    private $formationModel;
    
    public function __construct() {
        $this->requireAdmin();
        $this->formationModel = new Formation();
    }
    
    /**
     * Liste des formations (admin)
     */
    public function index() {
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 20;
        $offset = ($page - 1) * $perPage;
        
        $status = $_GET['status'] ?? null;
        $categoryId = $_GET['category'] ?? null;
        $search = $_GET['q'] ?? null;
        
        $formations = $this->formationModel->getAll($perPage, $offset, $status, $categoryId, $search);
        $totalFormations = $this->formationModel->countAll($status, $categoryId, $search);
        $totalPages = ceil($totalFormations / $perPage);
        
        $categories = $this->formationModel->getAllCategories();
        $stats = $this->formationModel->getFormationStats();
        
        $data = [
            'pageTitle' => 'Gestion des formations',
            'formations' => $formations,
            'categories' => $categories,
            'stats' => $stats,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalFormations' => $totalFormations,
            'filterStatus' => $status,
            'filterCategory' => $categoryId,
            'filterSearch' => $search,
            'currentUser' => $this->getCurrentUser()
        ];
        
        $this->viewWithLayout('admin/formations/index', $data);
    }
    
    /**
     * Formulaire de création de formation
     */
    public function create() {
        $categories = $this->formationModel->getAllCategories();
        
        $data = [
            'pageTitle' => 'Nouvelle formation',
            'categories' => $categories,
            'formation' => null,
            'currentUser' => $this->getCurrentUser()
        ];
        
        $this->viewWithLayout('admin/formations/form', $data);
    }
    
    /**
     * Sauvegarder une nouvelle formation
     */
    public function store() {
        $data = $this->getFormData();
        
        if (empty($data['title'])) {
            $_SESSION['error_message'] = 'Le titre est obligatoire.';
            $this->redirect('/admin/formations/new');
            return;
        }
        
        $data['slug'] = $this->formationModel->generateSlug($data['title']);
        
        // Gestion de l'upload d'image
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $imagePath = $this->handleImageUpload($_FILES['image_file']);
            if ($imagePath) {
                $data['image'] = $imagePath;
            }
        }
        
        try {
            $id = $this->formationModel->create($data);
            $_SESSION['success_message'] = 'Formation créée avec succès.';
            $this->redirect('/admin/formations/edit/' . $id);
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erreur lors de la création : ' . $e->getMessage();
            $this->redirect('/admin/formations/new');
        }
    }
    
    /**
     * Formulaire d'édition de formation
     */
    public function edit($id) {
        $formation = $this->formationModel->getFullFormationById($id);
        
        if (!$formation) {
            $_SESSION['error_message'] = 'Formation introuvable.';
            $this->redirect('/admin/formations');
            return;
        }
        
        $categories = $this->formationModel->getAllCategories();
        
        $data = [
            'pageTitle' => 'Modifier la formation',
            'categories' => $categories,
            'formation' => $formation,
            'currentUser' => $this->getCurrentUser()
        ];
        
        $this->viewWithLayout('admin/formations/form', $data);
    }
    
    /**
     * Mettre à jour une formation existante
     */
    public function update($id) {
        $formation = $this->formationModel->getById($id);
        
        if (!$formation) {
            $_SESSION['error_message'] = 'Formation introuvable.';
            $this->redirect('/admin/formations');
            return;
        }
        
        $data = $this->getFormData();
        
        if (empty($data['title'])) {
            $_SESSION['error_message'] = 'Le titre est obligatoire.';
            $this->redirect('/admin/formations/edit/' . $id);
            return;
        }
        
        if ($data['title'] !== $formation['title']) {
            $data['slug'] = $this->formationModel->generateSlug($data['title'], $id);
        } else {
            $data['slug'] = $formation['slug'];
        }
        
        // Gestion de l'upload d'image
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $imagePath = $this->handleImageUpload($_FILES['image_file']);
            if ($imagePath) {
                $data['image'] = $imagePath;
            }
        } else {
            $data['image'] = $formation['image'] ?? '';
        }
        
        try {
            $this->formationModel->update($id, $data);
            $_SESSION['success_message'] = 'Formation mise à jour avec succès.';
            $this->redirect('/admin/formations/edit/' . $id);
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erreur lors de la mise à jour : ' . $e->getMessage();
            $this->redirect('/admin/formations/edit/' . $id);
        }
    }
    
    /**
     * Supprimer une formation
     */
    public function delete($id) {
        $formation = $this->formationModel->getById($id);
        
        if (!$formation) {
            $_SESSION['error_message'] = 'Formation introuvable.';
            $this->redirect('/admin/formations');
            return;
        }
        
        try {
            $this->formationModel->delete($id);
            $_SESSION['success_message'] = 'Formation supprimée avec succès.';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erreur lors de la suppression : ' . $e->getMessage();
        }
        
        $this->redirect('/admin/formations');
    }
    
    /**
     * Extraire les données du formulaire
     */
    private function getFormData() {
        return [
            'title' => trim($_POST['title'] ?? ''),
            'description' => $_POST['description'] ?? '',
            'category_id' => $_POST['category_id'] ?? null,
            'service_name' => trim($_POST['service_name'] ?? ''),
            'level' => $_POST['level'] ?? 'debutant',
            'duration' => trim($_POST['duration'] ?? ''),
            'price' => floatval($_POST['price'] ?? 0),
            'image' => trim($_POST['image_url'] ?? ''),
            'meta_title' => trim($_POST['meta_title'] ?? ''),
            'meta_description' => trim($_POST['meta_description'] ?? ''),
            'meta_keywords' => trim($_POST['meta_keywords'] ?? ''),
            'status' => $_POST['status'] ?? 'draft'
        ];
    }
    
    /**
     * Gérer l'upload d'une image
     */
    private function handleImageUpload($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024;
        
        if (!in_array($file['type'], $allowedTypes)) {
            return null;
        }
        
        if ($file['size'] > $maxSize) {
            return null;
        }
        
        $uploadDir = __DIR__ . '/../../public/uploads/formations/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('formation_') . '.' . $extension;
        $filepath = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return '/uploads/formations/' . $filename;
        }
        
        return null;
    }
}
