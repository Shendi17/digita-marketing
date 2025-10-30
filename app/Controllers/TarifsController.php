<?php

require_once __DIR__ . '/../Helpers/ViewHelper.php';

class TarifsController {
    
    /**
     * Page Tarifs
     */
    public function index() {
        $data = [
            'title' => 'Tarifs - Digita Marketing',
            'extraCss' => ['/assets/css/tarifs.css']
        ];
        
        ViewHelper::render('tarifs/index-content', $data);
    }
}
