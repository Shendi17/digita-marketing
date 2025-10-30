<?php

require_once __DIR__ . '/../Helpers/ViewHelper.php';

class LegalController {
    
    /**
     * Page Mentions légales
     */
    public function mentionsLegales() {
        $data = [
            'title' => 'Mentions Légales - Digita Marketing',
            'extraCss' => ['/assets/css/legal.css']
        ];
        
        ViewHelper::render('legal/mentions-legales', $data);
    }
    
    /**
     * Page Politique de confidentialité
     */
    public function politiqueConfidentialite() {
        $data = [
            'title' => 'Politique de Confidentialité - Digita Marketing',
            'extraCss' => ['/assets/css/legal.css']
        ];
        
        ViewHelper::render('legal/politique-confidentialite', $data);
    }
    
    /**
     * Page Conditions générales (CGU/CGV)
     */
    public function conditionsGenerales() {
        $data = [
            'title' => 'Conditions Générales - Digita Marketing',
            'extraCss' => ['/assets/css/legal.css']
        ];
        
        ViewHelper::render('legal/conditions-generales', $data);
    }
    
    /**
     * Page Politique des cookies
     */
    public function cookies() {
        $data = [
            'title' => 'Politique des Cookies - Digita Marketing',
            'extraCss' => ['/assets/css/legal.css']
        ];
        
        ViewHelper::render('legal/cookies', $data);
    }
}
