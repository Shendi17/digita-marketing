<?php

require_once __DIR__ . '/../Helpers/ViewHelper.php';

class OutilsController {
    
    /**
     * Page d'accueil des outils
     */
    public function index() {
        $data = [
            'title' => 'Outils - Marketing Digital | Digita',
            'extraCss' => ['/assets/css/outils.css']
        ];
        
        ViewHelper::render('outils/index-content', $data);
    }
}
