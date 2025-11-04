<?php
require_once __DIR__ . '/../config/Database.php';

class Oferta {
    
    /**
     * Crear oferta
     */
    public static function create($data) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            INSERT INTO ofertas (empresa_id, titulo, descripcion, requisitos, ciclo_id, fecha_inicio, fecha_cierre, modalidad, salario) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['empresa_id'],
            $data['titulo'],
            $data['descripcion'],
            $data['requisitos'] ?? null,
            $data['ciclo_id'],
            $data['fecha_inicio'],
            $data['fecha_cierre'],
            $data['modalidad'] ?? 'presencial',
            $data['salario'] ?? null
        ]);
        return $db->lastInsertId();
    }
    
    


    /**
     * Listar todas las ofertas (pa el admin)
     */
    public static function getAll() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("
            SELECT o.*, e.nombre as empresa_nombre, c.nombre as ciclo_nombre
            FROM ofertas o
            JOIN empresas e ON o.empresa_id = e.id
            LEFT JOIN ciclos c ON o.ciclo_id = c.id
            ORDER BY o.fecha_creacion DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function getAllByCiclos($ciclosIds) {
        $db = Database::getInstance()->getConnection();
        
        // Convertir array a string separado por comas
        if (is_array($ciclosIds)) {
            $idsString = implode(',', $ciclosIds);
        } else {
            $idsString = $ciclosIds;
        }
        
        $stmt = $db->query("
            SELECT o.*, e.nombre as empresa_nombre, c.nombre as ciclo_nombre
            FROM ofertas o
            JOIN empresas e ON o.empresa_id = e.id
            LEFT JOIN ciclos c ON o.ciclo_id = c.id
            WHERE o.ciclo_id IN ($idsString)
            ORDER BY o.fecha_creacion DESC
        ");
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    /**
     * Buscar oferta en la empresa
     */
    public static function findByID($ofertaId) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT o.*, e.nombre as empresa_nombre, c.nombre as ciclo_nombre
            FROM ofertas o
            JOIN empresas e ON o.empresa_id = e.id
            WHERE o.id = ?
        ");
        $stmt->execute([$ofertaId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * Listar ofertas por empresa
     */
    public static function getByEmpresa($empresaId) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT o.*, c.nombre as ciclo_nombre
            FROM ofertas o
            LEFT JOIN ciclos c ON o.ciclo_id = c.id
            WHERE o.empresa_id = ?
            ORDER BY o.fecha_creacion DESC
        ");
        $stmt->execute([$empresaId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Actualizar oferta
     */
    public static function update($id, $data) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            UPDATE ofertas 
            SET titulo = ?, descripcion = ?, requisitos = ?, ciclo_id = ?, fecha_cierre = ?, modalidad = ?, salario = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['titulo'],
            $data['descripcion'],
            $data['requisitos'] ?? null,
            $data['ciclo_id'],
            $data['fecha_cierre'],
            $data['modalidad'] ?? 'presencial',
            $data['salario'] ?? null,
            $id
        ]);
    }
    
    /**
     * Eliminar oferta
     */
    public static function delete($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM ofertas WHERE id = ?");
        return $stmt->execute([$id]);
    }


    /**
     * Listar candidatos
     */
    // public static function listCandidatos($id)
    // {
    //     $db = Database::getInstance()->getConnection();
    //     $stmt = $db->prepare("
    //         SELECT
    //         FROM ofertas o
    //         LEFT JOIN alumnos a ON 
    //         // TENGO QUE METER POR MEDIO LA TABLA SOLICITUDES
               // POR HACER

    //     ") 
    // }
}
