<?php
require_once __DIR__ . '/../config/Database.php';

class Postulacion {
    /**
     * Crea la postulacion
     */
    public static function create($alumnoId, $ofertaId) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO postulaciones (alumno_id, oferta_id) VALUES (?, ?)");
        return $stmt->execute([$alumnoId, $ofertaId]);
    }
    
    
    public static function getByAlumno($alumnoId) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT p.*, o.titulo, o.descripcion, e.nombre as empresa_nombre
            FROM postulaciones p
            JOIN ofertas o ON p.oferta_id = o.id
            JOIN empresas e ON o.empresa_id = e.id
            WHERE p.alumno_id = ?
            ORDER BY p.fecha_postulacion DESC
        ");
        $stmt->execute([$alumnoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
