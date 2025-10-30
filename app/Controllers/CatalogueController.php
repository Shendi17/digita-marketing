<?php

require_once __DIR__ . '/../Helpers/ViewHelper.php';

class CatalogueController {
    
    /**
     * Page Catalogue complet des services
     */
    public function index() {
        $data = [
            'title' => 'Catalogue Complet - Digita Marketing',
            'extraCss' => ['/assets/css/catalogue.css']
        ];
        
        ViewHelper::render('catalogue/index-content', $data);
    }
}
