<?php

require_once __DIR__ . '/../Helpers/ViewHelper.php';

class ServicesController {
    
    /**
     * Page Services
     */
    public function index() {
        $data = [
            'title' => 'Services - Digita Marketing',
            'extraCss' => ['/assets/css/services.css']
        ];
        
        ViewHelper::render('services/index-content', $data);
    }
}
