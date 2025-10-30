<?php

require_once __DIR__ . '/Model.php';

/**
 * Modèle User
 * Gère les utilisateurs du système
 */
class User extends Model {
    protected $table = 'users';
    
    /**
     * Trouver un utilisateur par email
     */
    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        return $this->db->fetch($sql, [$email]);
    }
    
    /**
     * Vérifier les identifiants de connexion
     */
    public function authenticate($email, $password) {
        $user = $this->findByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    /**
     * Créer un nouvel utilisateur
     */
    public function createUser($email, $password, $role = 'user') {
        $data = [
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role
        ];
        
        return $this->create($data);
    }
    
    /**
     * Mettre à jour le mot de passe
     */
    public function updatePassword($userId, $newPassword) {
        return $this->update($userId, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);
    }
    
    /**
     * Vérifier si un email existe déjà
     */
    public function emailExists($email) {
        return $this->findByEmail($email) !== false;
    }
    
    /**
     * Récupérer les statistiques des utilisateurs
     */
    public function getStats() {
        return [
            'total' => $this->count(),
            'admins' => $this->count('role = ?', ['admin']),
            'users' => $this->count('role = ?', ['user'])
        ];
    }
}
