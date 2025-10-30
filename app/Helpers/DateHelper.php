<?php

/**
 * Helper pour la gestion des dates
 */
class DateHelper {
    
    /**
     * Formater une date en français
     */
    public static function formatFrench($date, $format = 'd/m/Y à H:i') {
        if (is_string($date)) {
            $date = new DateTime($date);
        }
        return $date->format($format);
    }
    
    /**
     * Obtenir le temps écoulé (ex: "il y a 2 heures")
     */
    public static function timeAgo($datetime) {
        $timestamp = is_string($datetime) ? strtotime($datetime) : $datetime;
        $diff = time() - $timestamp;
        
        if ($diff < 60) {
            return "à l'instant";
        } elseif ($diff < 3600) {
            $minutes = floor($diff / 60);
            return "il y a " . $minutes . " minute" . ($minutes > 1 ? 's' : '');
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return "il y a " . $hours . " heure" . ($hours > 1 ? 's' : '');
        } elseif ($diff < 604800) {
            $days = floor($diff / 86400);
            return "il y a " . $days . " jour" . ($days > 1 ? 's' : '');
        } elseif ($diff < 2592000) {
            $weeks = floor($diff / 604800);
            return "il y a " . $weeks . " semaine" . ($weeks > 1 ? 's' : '');
        } else {
            return date('d/m/Y', $timestamp);
        }
    }
    
    /**
     * Obtenir le jour de la semaine en français
     */
    public static function getDayName($date = null) {
        $days = [
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche'
        ];
        
        $dayName = date('l', $date ? strtotime($date) : time());
        return $days[$dayName] ?? $dayName;
    }
    
    /**
     * Obtenir le mois en français
     */
    public static function getMonthName($date = null) {
        $months = [
            'January' => 'Janvier',
            'February' => 'Février',
            'March' => 'Mars',
            'April' => 'Avril',
            'May' => 'Mai',
            'June' => 'Juin',
            'July' => 'Juillet',
            'August' => 'Août',
            'September' => 'Septembre',
            'October' => 'Octobre',
            'November' => 'Novembre',
            'December' => 'Décembre'
        ];
        
        $monthName = date('F', $date ? strtotime($date) : time());
        return $months[$monthName] ?? $monthName;
    }
    
    /**
     * Formater une date complète en français
     */
    public static function formatFullFrench($date = null) {
        $timestamp = $date ? strtotime($date) : time();
        $day = self::getDayName($date);
        $dayNum = date('d', $timestamp);
        $month = self::getMonthName($date);
        $year = date('Y', $timestamp);
        
        return "$day $dayNum $month $year";
    }
}
