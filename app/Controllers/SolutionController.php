<?php

require_once __DIR__ . '/../Helpers/ViewHelper.php';

class SolutionController {
    
    /**
     * Page d'accueil des solutions
     */
    public function index() {
        $data = [
            'title' => 'Solutions - Marketing Digital | Digita',
            'extraCss' => ['/assets/css/solutions.css']
        ];
        
        ViewHelper::render('solutions/index-content', $data);
    }
}
