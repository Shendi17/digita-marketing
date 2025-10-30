<?php

/**
 * Helper pour la manipulation de chaînes
 */
class StringHelper {
    
    /**
     * Tronquer un texte avec ellipse
     */
    public static function truncate($text, $length = 100, $suffix = '...') {
        if (mb_strlen($text) <= $length) {
            return $text;
        }
        
        return mb_substr($text, 0, $length) . $suffix;
    }
    
    /**
     * Générer un slug à partir d'un texte
     */
    public static function slugify($text) {
        // Remplacer les caractères accentués
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        
        // Convertir en minuscules
        $text = strtolower($text);
        
        // Remplacer les caractères non alphanumériques par des tirets
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        
        // Supprimer les tirets en début et fin
        $text = trim($text, '-');
        
        return $text;
    }
    
    /**
     * Extraire les initiales d'un nom
     */
    public static function getInitials($name) {
        $words = explode(' ', $name);
        $initials = '';
        
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= mb_substr($word, 0, 1);
            }
        }
        
        return mb_strtoupper($initials);
    }
    
    /**
     * Formater un nombre avec séparateurs
     */
    public static function formatNumber($number, $decimals = 0) {
        return number_format($number, $decimals, ',', ' ');
    }
    
    /**
     * Masquer partiellement un email
     */
    public static function maskEmail($email) {
        $parts = explode('@', $email);
        if (count($parts) !== 2) {
            return $email;
        }
        
        $name = $parts[0];
        $domain = $parts[1];
        
        $nameLength = strlen($name);
        $visibleChars = min(3, floor($nameLength / 2));
        
        $maskedName = substr($name, 0, $visibleChars) . str_repeat('*', $nameLength - $visibleChars);
        
        return $maskedName . '@' . $domain;
    }
    
    /**
     * Générer une couleur aléatoire pour un avatar
     */
    public static function getAvatarColor($string) {
        $colors = [
            '#6366f1', '#8b5cf6', '#ec4899', '#f43f5e',
            '#f59e0b', '#10b981', '#14b8a6', '#06b6d4',
            '#3b82f6', '#6366f1'
        ];
        
        $hash = 0;
        for ($i = 0; $i < strlen($string); $i++) {
            $hash = ord($string[$i]) + (($hash << 5) - $hash);
        }
        
        $index = abs($hash) % count($colors);
        return $colors[$index];
    }
}
