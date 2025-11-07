<?php
require_once __DIR__.'/DAOInterface.php';
require_once __DIR__.'/../models/entities/CicloEntity.php';
require_once __DIR__.'/../config/Database.php';

class CicloDAO implements DAOInterface {
    private $db;
    public function __construct() { $this->db = Database::getInstance()->getConnection(); }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM ciclos WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new CicloEntity($row) : null;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM ciclos ORDER BY nombre");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new CicloEntity($row);
        }
        return $result;
    }

    
    public function create($ciclo) {
        $stmt = $this->db->prepare("INSERT INTO ciclos (nombre, codigo) VALUES (?, ?)");
        $stmt->execute([$ciclo->nombre, $ciclo->codigo]);
        $ciclo->id = $this->db->lastInsertId();
        return $ciclo;
    }
    
    public function update($ciclo) {
        $stmt = $this->db->prepare("UPDATE ciclos SET nombre=?, codigo=? WHERE id=?");
        return $stmt->execute([$ciclo->nombre, $ciclo->codigo, $ciclo->id]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM ciclos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
