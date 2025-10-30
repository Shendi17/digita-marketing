<?php

/**
 * Helper pour le rendu des vues avec layout
 */
class ViewHelper
{
    /**
     * Rend une vue avec le layout principal
     * 
     * @param string $view Chemin de la vue (ex: 'blog/index')
     * @param array $data Données à passer à la vue
     * @param string $layout Layout à utiliser (par défaut 'main')
     */
    public static function render($view, $data = [], $layout = 'main')
    {
        // Extraire les données pour les rendre disponibles dans la vue
        extract($data);
        
        // Définir le chemin de base
        $basePath = dirname(dirname(__DIR__));
        
        // Capturer le contenu de la vue
        ob_start();
        $viewPath = $basePath . '/app/Views/' . $view . '.php';
        if (!file_exists($viewPath)) {
            throw new Exception("Vue non trouvée : " . $viewPath);
        }
        require $viewPath;
        $content = ob_get_clean();
        
        // Inclure le layout avec le contenu
        $layoutPath = $basePath . '/app/Views/layouts/' . $layout . '.php';
        if (!file_exists($layoutPath)) {
            throw new Exception("Layout non trouvé : " . $layoutPath);
        }
        require $layoutPath;
    }
    
    /**
     * Rend une vue sans layout
     * 
     * @param string $view Chemin de la vue
     * @param array $data Données à passer à la vue
     */
    public static function renderPartial($view, $data = [])
    {
        extract($data);
        require __DIR__ . '/../Views/' . $view . '.php';
    }
}
