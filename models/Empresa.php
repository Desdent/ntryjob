<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/User.php';

class Empresa {
    
    /**
     * Crear empresa
     */
    public static function create($data) {
        $db = Database::getInstance()->getConnection();
        $db->beginTransaction();
        
        try {
            // Crear usuario
            $usuarioId = User::create($data['email'], $data['password']);
            
            // Crear empresa
            $stmt = $db->prepare("
                INSERT INTO empresas (
                    usuario_id, nombre, cif, telefono, sector, descripcion, 
                    pais, provincia, ciudad, direccion, logo, aprobada
                ) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)
            ");
            $stmt->execute([
                $usuarioId,
                $data['nombre'],
                $data['cif'] ?? null,
                $data['telefono'] ?? null,
                $data['sector'] ?? null,
                $data['descripcion'] ?? null,
                $data['pais'] ?? null,
                $data['provincia'] ?? null,
                $data['ciudad'] ?? null,
                $data['direccion'] ?? null,
                $data['logo'] ?? null
            ]);
            
            $db->commit();
            return $db->lastInsertId();
            
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }
    
    /**
     * Listar empresas pendientes de aprobar
     */
    public static function getPendientes() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("
            SELECT e.id, e.usuario_id, e.nombre, e.cif, e.telefono, e.sector, 
                   e.descripcion, e.pais, e.provincia, e.ciudad, e.direccion,
                   e.aprobada, e.created_at, u.email,
                   CASE WHEN e.logo IS NOT NULL THEN 1 ELSE 0 END as tiene_logo
            FROM empresas e
            JOIN usuarios u ON e.usuario_id = u.id
            WHERE e.aprobada = 0
            ORDER BY e.id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Aprobar empresa
     */
    public static function aprobar($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE empresas SET aprobada = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    /**
     * Rechazar empresa
     */
    public static function rechazar($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE empresas SET aprobada = 0 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Borrar empresa
     */
    public static function borrar($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM empresas WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Obtener logo de la empresa
     */
    public static function getLogo($empresaId) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT logo FROM empresas WHERE id = ?");
        $stmt->execute([$empresaId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['logo'] : null;
    }

    /**
     * Buscar empresa por usuario_id
     */
    public static function findByUsuarioId($usuarioId) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT e.id, e.usuario_id, e.nombre, e.cif, e.telefono, e.sector, 
                   e.descripcion, e.pais, e.provincia, e.ciudad, e.direccion,
                   e.aprobada, e.created_at, u.email,
                   CASE WHEN e.logo IS NOT NULL THEN 1 ELSE 0 END as tiene_logo
            FROM empresas e
            JOIN usuarios u ON e.usuario_id = u.id
            WHERE e.usuario_id = ?
        ");
        $stmt->execute([$usuarioId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Buscar empresa por ID
     */
    public static function findEmpresaById($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT nombre FROM empresas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}