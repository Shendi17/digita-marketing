<?php

require_once __DIR__ . '/../Helpers/ViewHelper.php';

class BoutiqueController {
    
    /**
     * Page d'accueil de la boutique
     */
    public function index() {
        $data = [
            'title' => 'Boutique - Produits & Services | Digita',
            'extraCss' => ['/assets/css/boutique.css']
        ];
        
        ViewHelper::render('boutique/index-content', $data);
    }
}
