<?php
require_once __DIR__ . '/../config/Database.php'; 

class User {
    
    /**
     * Buscar usuario por email
     */
    public static function findByEmail($email) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT u.*, 
                   CASE 
                       WHEN a.id IS NOT NULL THEN 'alumno'
                       WHEN e.id IS NOT NULL THEN 'empresario'
                       WHEN ad.id IS NOT NULL THEN 'admin'
                   END as role,
                   COALESCE(e.aprobada, 1) as aprobada
            FROM usuarios u
            LEFT JOIN alumnos a ON u.id = a.usuario_id
            LEFT JOIN empresas e ON u.id = e.usuario_id
            LEFT JOIN admin ad ON u.id = ad.usuario_id
            WHERE u.email = ?
        ");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    /**
     * Verificar si email existe
     */
    public static function emailExists($email) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }
    
    /**
     * Crear usuario base
     */
    public static function create($email, $password) {
        $db = Database::getInstance()->getConnection();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $db->prepare("INSERT INTO usuarios (email, password) VALUES (?, ?)");
        $stmt->execute([$email, $hashedPassword]);
        
        return $db->lastInsertId();
    }


    /**
     * Editar email
     */
    public static function editEmail($id, $email){
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            UPDATE usuarios 
            SET email = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $email,
            $id
        ]);
    }


    
    /**
     * Verificar contraseña
     */
    public static function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }
}