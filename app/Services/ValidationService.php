<?php

/**
 * Service de validation des données
 */
class ValidationService {
    
    private $errors = [];
    
    /**
     * Valider un email
     */
    public function email($value, $fieldName = 'Email') {
        if (empty($value)) {
            $this->errors[$fieldName] = "$fieldName est requis";
            return false;
        }
        
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$fieldName] = "$fieldName n'est pas valide";
            return false;
        }
        
        return true;
    }
    
    /**
     * Valider un champ requis
     */
    public function required($value, $fieldName = 'Ce champ') {
        if (empty($value) && $value !== '0') {
            $this->errors[$fieldName] = "$fieldName est requis";
            return false;
        }
        
        return true;
    }
    
    /**
     * Valider la longueur minimale
     */
    public function minLength($value, $min, $fieldName = 'Ce champ') {
        if (mb_strlen($value) < $min) {
            $this->errors[$fieldName] = "$fieldName doit contenir au moins $min caractères";
            return false;
        }
        
        return true;
    }
    
    /**
     * Valider la longueur maximale
     */
    public function maxLength($value, $max, $fieldName = 'Ce champ') {
        if (mb_strlen($value) > $max) {
            $this->errors[$fieldName] = "$fieldName ne peut pas dépasser $max caractères";
            return false;
        }
        
        return true;
    }
    
    /**
     * Valider un numéro de téléphone
     */
    public function phone($value, $fieldName = 'Téléphone') {
        if (empty($value)) {
            return true; // Optionnel
        }
        
        // Format français : 0X XX XX XX XX ou +33 X XX XX XX XX
        $pattern = '/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/';
        
        if (!preg_match($pattern, $value)) {
            $this->errors[$fieldName] = "$fieldName n'est pas valide";
            return false;
        }
        
        return true;
    }
    
    /**
     * Valider un mot de passe
     */
    public function password($value, $fieldName = 'Mot de passe') {
        if (empty($value)) {
            $this->errors[$fieldName] = "$fieldName est requis";
            return false;
        }
        
        if (strlen($value) < 8) {
            $this->errors[$fieldName] = "$fieldName doit contenir au moins 8 caractères";
            return false;
        }
        
        // Vérifier la complexité (au moins une majuscule, une minuscule, un chiffre)
        if (!preg_match('/[A-Z]/', $value)) {
            $this->errors[$fieldName] = "$fieldName doit contenir au moins une majuscule";
            return false;
        }
        
        if (!preg_match('/[a-z]/', $value)) {
            $this->errors[$fieldName] = "$fieldName doit contenir au moins une minuscule";
            return false;
        }
        
        if (!preg_match('/[0-9]/', $value)) {
            $this->errors[$fieldName] = "$fieldName doit contenir au moins un chiffre";
            return false;
        }
        
        return true;
    }
    
    /**
     * Valider une URL
     */
    public function url($value, $fieldName = 'URL') {
        if (empty($value)) {
            return true; // Optionnel
        }
        
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            $this->errors[$fieldName] = "$fieldName n'est pas valide";
            return false;
        }
        
        return true;
    }
    
    /**
     * Valider un nombre
     */
    public function numeric($value, $fieldName = 'Ce champ') {
        if (!is_numeric($value)) {
            $this->errors[$fieldName] = "$fieldName doit être un nombre";
            return false;
        }
        
        return true;
    }
    
    /**
     * Valider une date
     */
    public function date($value, $format = 'Y-m-d', $fieldName = 'Date') {
        $d = DateTime::createFromFormat($format, $value);
        
        if (!$d || $d->format($format) !== $value) {
            $this->errors[$fieldName] = "$fieldName n'est pas valide";
            return false;
        }
        
        return true;
    }
    
    /**
     * Valider que deux valeurs correspondent
     */
    public function match($value1, $value2, $fieldName = 'Les champs') {
        if ($value1 !== $value2) {
            $this->errors[$fieldName] = "$fieldName ne correspondent pas";
            return false;
        }
        
        return true;
    }
    
    /**
     * Valider un fichier uploadé
     */
    public function file($file, $allowedTypes = [], $maxSize = 5242880, $fieldName = 'Fichier') {
        if (!isset($file['error']) || is_array($file['error'])) {
            $this->errors[$fieldName] = "$fieldName est invalide";
            return false;
        }
        
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->errors[$fieldName] = "Erreur lors de l'upload du fichier";
            return false;
        }
        
        if ($file['size'] > $maxSize) {
            $sizeMB = $maxSize / 1048576;
            $this->errors[$fieldName] = "$fieldName ne peut pas dépasser {$sizeMB}MB";
            return false;
        }
        
        if (!empty($allowedTypes)) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($file['tmp_name']);
            
            if (!in_array($mimeType, $allowedTypes)) {
                $this->errors[$fieldName] = "Type de fichier non autorisé";
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Obtenir toutes les erreurs
     */
    public function getErrors() {
        return $this->errors;
    }
    
    /**
     * Vérifier s'il y a des erreurs
     */
    public function hasErrors() {
        return !empty($this->errors);
    }
    
    /**
     * Réinitialiser les erreurs
     */
    public function reset() {
        $this->errors = [];
    }
    
    /**
     * Obtenir la première erreur
     */
    public function getFirstError() {
        return !empty($this->errors) ? reset($this->errors) : null;
    }
}
