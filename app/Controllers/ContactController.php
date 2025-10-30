<?php

require_once __DIR__ . '/../Helpers/ViewHelper.php';

class ContactController {
    
    /**
     * Page Contact
     */
    public function index() {
        $data = [
            'title' => 'Contact - Digita Marketing',
            'extraCss' => ['/assets/css/contact.css']
        ];
        
        ViewHelper::render('contact/index-content', $data);
    }
}
