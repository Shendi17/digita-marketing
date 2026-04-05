<?php

require_once __DIR__ . '/Controller.php';

/**
 * Contrôleur Admin Médias
 * Gère la bibliothèque de médias (upload, liste, suppression)
 */
class AdminMediaController extends Controller {
    
    private $uploadDir;
    private $webPath;
    
    public function __construct() {
        $this->requireAdmin();
        $this->uploadDir = __DIR__ . '/../../public/uploads/media/';
        $this->webPath = '/uploads/media/';
        
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }
    
    /**
     * Bibliothèque de médias
     */
    public function index() {
        $files = $this->scanMediaFiles();
        
        // Trier par date de modification (plus récent en premier)
        usort($files, function($a, $b) {
            return $b['modified'] - $a['modified'];
        });
        
        $stats = [
            'total' => count($files),
            'total_size' => array_sum(array_column($files, 'size')),
            'images' => count(array_filter($files, fn($f) => $f['type'] === 'image')),
        ];
        
        $data = [
            'pageTitle' => 'Bibliothèque de médias',
            'files' => $files,
            'stats' => $stats,
            'currentUser' => $this->getCurrentUser()
        ];
        
        $this->viewWithLayout('admin/media/index', $data);
    }
    
    /**
     * Upload de média(s)
     */
    public function upload() {
        header('Content-Type: application/json');
        
        if (!isset($_FILES['files'])) {
            echo json_encode(['success' => false, 'error' => 'Aucun fichier envoyé']);
            exit();
        }
        
        $allowedTypes = [
            'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml',
            'application/pdf',
            'video/mp4', 'video/webm'
        ];
        $maxSize = 10 * 1024 * 1024; // 10MB
        
        $uploaded = [];
        $errors = [];
        
        $files = $this->normalizeFiles($_FILES['files']);
        
        foreach ($files as $file) {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $errors[] = $file['name'] . ' : erreur d\'upload';
                continue;
            }
            
            if (!in_array($file['type'], $allowedTypes)) {
                $errors[] = $file['name'] . ' : type non autorisé (' . $file['type'] . ')';
                continue;
            }
            
            if ($file['size'] > $maxSize) {
                $errors[] = $file['name'] . ' : fichier trop volumineux (max 10 Mo)';
                continue;
            }
            
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $filename = date('Y-m-d_') . uniqid() . '.' . $extension;
            $filepath = $this->uploadDir . $filename;
            
            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                $uploaded[] = [
                    'name' => $filename,
                    'url' => $this->webPath . $filename,
                    'size' => $file['size'],
                    'type' => $file['type']
                ];
            } else {
                $errors[] = $file['name'] . ' : erreur lors de la copie';
            }
        }
        
        echo json_encode([
            'success' => count($uploaded) > 0,
            'uploaded' => $uploaded,
            'errors' => $errors
        ]);
        exit();
    }
    
    /**
     * Supprimer un média
     */
    public function delete() {
        header('Content-Type: application/json');
        
        $filename = $_POST['filename'] ?? '';
        
        if (empty($filename)) {
            echo json_encode(['success' => false, 'error' => 'Nom de fichier manquant']);
            exit();
        }
        
        // Sécurité : empêcher la traversée de répertoire
        $filename = basename($filename);
        $filepath = $this->uploadDir . $filename;
        
        if (!file_exists($filepath)) {
            echo json_encode(['success' => false, 'error' => 'Fichier introuvable']);
            exit();
        }
        
        if (unlink($filepath)) {
            echo json_encode(['success' => true, 'message' => 'Fichier supprimé']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Impossible de supprimer le fichier']);
        }
        exit();
    }
    
    /**
     * Scanner les fichiers médias du dossier uploads
     */
    private function scanMediaFiles() {
        $files = [];
        $dirs = [
            $this->uploadDir,
            __DIR__ . '/../../public/uploads/articles/',
            __DIR__ . '/../../public/uploads/formations/'
        ];
        
        $webPaths = [
            $this->uploadDir => '/uploads/media/',
            __DIR__ . '/../../public/uploads/articles/' => '/uploads/articles/',
            __DIR__ . '/../../public/uploads/formations/' => '/uploads/formations/'
        ];
        
        foreach ($dirs as $dir) {
            if (!is_dir($dir)) continue;
            
            $scan = scandir($dir);
            foreach ($scan as $file) {
                if ($file === '.' || $file === '..') continue;
                
                $fullPath = $dir . $file;
                if (!is_file($fullPath)) continue;
                
                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                $mimeType = mime_content_type($fullPath);
                
                $type = 'other';
                if (strpos($mimeType, 'image/') === 0) $type = 'image';
                elseif (strpos($mimeType, 'video/') === 0) $type = 'video';
                elseif ($mimeType === 'application/pdf') $type = 'pdf';
                
                $files[] = [
                    'name' => $file,
                    'url' => $webPaths[$dir] . $file,
                    'path' => $fullPath,
                    'size' => filesize($fullPath),
                    'type' => $type,
                    'mime' => $mimeType,
                    'extension' => $extension,
                    'modified' => filemtime($fullPath),
                    'folder' => basename(dirname($fullPath))
                ];
            }
        }
        
        return $files;
    }
    
    /**
     * Normaliser le tableau $_FILES pour les uploads multiples
     */
    private function normalizeFiles($files) {
        $normalized = [];
        
        if (is_array($files['name'])) {
            $count = count($files['name']);
            for ($i = 0; $i < $count; $i++) {
                $normalized[] = [
                    'name' => $files['name'][$i],
                    'type' => $files['type'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error' => $files['error'][$i],
                    'size' => $files['size'][$i]
                ];
            }
        } else {
            $normalized[] = $files;
        }
        
        return $normalized;
    }
}
