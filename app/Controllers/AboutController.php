<?php

require_once __DIR__ . '/../Helpers/ViewHelper.php';

class AboutController {
    
    /**
     * Page À propos
     */
    public function index() {
        $data = [
            'title' => 'À propos - Digita Marketing',
            'extraCss' => ['/assets/css/about.css']
        ];
        
        ViewHelper::render('about/index-content', $data);
    }
}
