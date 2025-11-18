<?php
require_once __DIR__.'/DAOInterface.php';
require_once __DIR__.'/../models/entities/PostulacionEntity.php';
require_once __DIR__.'/../config/Database.php';
require_once __DIR__.'/AlumnoDAO.php';

class PostulacionDAO implements DAOInterface {
    private $db;
    public function __construct() { $this->db = Database::getInstance()->getConnection(); }
    
    public function getById($id) {

        $stmt = $this->db->prepare("
            SELECT p.*, a.nombre as alumno_nombre, o.titulo as oferta_titulo 
            FROM postulaciones p 
            JOIN alumnos a ON p.alumno_id = a.id 
            JOIN ofertas o ON p.oferta_id = o.id 
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new PostulacionEntity($row) : null;
    }


    public function getPostulacionByOfertaIdAlumnoId($id_oferta, $id_alumno) {
        
        $stmt = $this->db->prepare("
            SELECT p.*, a.nombre AS alumno_nombre, a.apellidos AS alumno_apellidos, a.ciudad AS alumno_ciudad
            FROM postulaciones p 
            JOIN alumnos a ON p.alumno_id = a.id
            WHERE p.oferta_id = ? AND p.alumno_id = ? AND p.estado NOT IN ('aprobada', 'rechazada')
        ");
        $stmt->execute([$id_oferta, $id_alumno]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? new PostulacionEntity($row) : null;
    }

    public function getPostulantesByOfertaId($id) {

        $alumnoDAO = new AlumnoDAO();
        
        $stmt = $this->db->prepare("
            SELECT alumno_id
            FROM postulaciones
            WHERE oferta_id = ?
        ");
        $stmt->execute([$id]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $alumnoId = $row['alumno_id'];
            $result[] = $alumnoDAO->getByIdChiquito($alumnoId);
        }
        return $result;
    }


    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT p.*, a.nombre as alumno_nombre, o.titulo as oferta_titulo 
            FROM postulaciones p 
            JOIN alumnos a ON p.alumno_id = a.id 
            JOIN ofertas o ON p.oferta_id = o.id 
            ORDER BY p.fecha_postulacion DESC
        ");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new PostulacionEntity($row);
        }
        return $result;
    }

    public function comprobarOferta($oferta_id, $alumno_id)
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM postulaciones
            WHERE alumno_id = ? AND oferta_id = ?
        ");
        $stmt->execute([$alumno_id, $oferta_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new PostulacionEntity($row) : null;
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
        $stmt = $this->db->prepare("
            SELECT p.*, o.titulo as oferta_titulo, e.nombre as empresa_nombre 
            FROM postulaciones p 
            JOIN ofertas o ON p.oferta_id = o.id 
            JOIN empresas e ON o.empresa_id = e.id 
            WHERE p.alumno_id = ?
        ");
        $stmt->execute([$alumnoId]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new PostulacionEntity($row);
        }
        return $result;
    }


}
