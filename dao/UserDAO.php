<?php
require_once __DIR__.'/../models/entities/UserEntity.php';
require_once __DIR__.'/../config/Database.php';

class UserDAO {
    private $db;
    public function __construct() { $this->db = Database::getInstance()->getConnection(); }
    
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'UserEntity');
        return $stmt->fetch() ?: null;
    }


    
    public function emailExists($email) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }
    
    public function createUser($email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO usuarios (email, password) VALUES (?, ?)");
        $stmt->execute([$email, $hashedPassword]);
        return $this->db->lastInsertId();
    }
    
    public function editEmail($userId, $email) {
        $stmt = $this->db->prepare("UPDATE usuarios SET email = ? WHERE id = ?");
        return $stmt->execute([$email, $userId]);
    }
    
    public function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }
}
