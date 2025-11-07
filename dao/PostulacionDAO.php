<?php
require_once __DIR__.'/DAOInterface.php';
require_once __DIR__.'/../models/entities/PostulacionEntity.php';
require_once __DIR__.'/../config/Database.php';

class PostulacionDAO implements DAOInterface {
    private $db;
    public function __construct() { $this->db = Database::getInstance()->getConnection(); }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT p.*, a.nombre as alumno_nombre, o.titulo as oferta_titulo FROM postulaciones p JOIN alumnos a ON p.alumno_id = a.id JOIN ofertas o ON p.oferta_id = o.id WHERE p.id = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'PostulacionEntity');
        return $stmt->fetch() ?: null;
    }


    
    public function getAll() {
        $stmt = $this->db->query("SELECT p.*, a.nombre as alumno_nombre, o.titulo as oferta_titulo FROM postulaciones p JOIN alumnos a ON p.alumno_id = a.id JOIN ofertas o ON p.oferta_id = o.id ORDER BY p.fecha_postulacion DESC");
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'PostulacionEntity');
    }


    
    public function create($postulacion) {
        $stmt = $this->db->prepare("INSERT INTO postulaciones (alumno_id, oferta_id) VALUES (?, ?)");
        $stmt->execute([$postulacion->alumno_id, $postulacion->oferta_id]);
        $postulacion->id = $this->db->lastInsertId();
        return $postulacion;
    }
    
    public function update($postulacion) { return true; }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM postulaciones WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function getByAlumno($alumnoId) {
        $stmt = $this->db->prepare("SELECT p.*, o.titulo as oferta_titulo, e.nombre as empresa_nombre FROM postulaciones p JOIN ofertas o ON p.oferta_id = o.id JOIN empresas e ON o.empresa_id = e.id WHERE p.alumno_id = ?");
        $stmt->execute([$alumnoId]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'PostulacionEntity');
    }


}
