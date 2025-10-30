<?php

require_once __DIR__ . '/../Helpers/ViewHelper.php';

class SupportController {
    
    /**
     * Page Support
     */
    public function index() {
        $data = [
            'title' => 'Support - Digita Marketing',
            'extraCss' => ['/assets/css/support.css']
        ];
        
        ViewHelper::render('support/index-content', $data);
    }
}
