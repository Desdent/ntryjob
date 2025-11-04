<?php
require_once __DIR__ . '/../config/Database.php';

class Ciclo {
    
    public static function getAll() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM ciclos ORDER BY nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function create($data) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO ciclos (nombre, codigo) VALUES (?, ?)");
        $stmt->execute([$data['nombre'], $data['codigo']]);
        return $db->lastInsertId();
    }
}
