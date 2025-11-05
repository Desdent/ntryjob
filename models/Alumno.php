<?php
require_once __DIR__ . '/../config/Database.php'; 
require_once __DIR__ . '/User.php';   

class Alumno {
    
    /**
     * Crear alumno
     */
    public static function create($data) {
    
        $db = Database::getInstance()->getConnection();
        $db->beginTransaction();
        
        try {

            if(!User::emailExists($data['email'])){

                if($data['password']){
                // Crear usuario temporal
                $usuarioId = User::create($data['email'], 'admin123');
                }
                else
                {
                    // Crear usuario
                    $usuarioId = User::create($data['email'], $data['password']);
                }
            }
            
            
            // Crear alumno
            $stmt = $db->prepare("
                INSERT INTO alumnos (
                    usuario_id, nombre, apellidos, fecha_nacimiento, telefono, 
                    pais, provincia, ciudad, direccion, codigo_postal, 
                    ciclo_id, fecha_inicio, fecha_fin, cv, foto
                ) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $usuarioId,
                $data['nombre'],
                $data['apellidos'],
                $data['fecha_nacimiento'] ?? null,
                $data['telefono'] ?? null,
                $data['pais'] ?? null,
                $data['provincia'] ?? null,
                $data['ciudad'] ?? null,
                $data['direccion'] ?? null,
                $data['codigo_postal'] ?? null,
                (int)$data['ciclo_id'],
                $data['fecha_inicio'] ?? null,
                $data['fecha_fin'] ?? null,
                $data['cv'] ?? null,
                $data['foto'] ?? null
            ]);
            
            $db->commit();
            return $db->lastInsertId();
            
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }
    
    /**
     * Listar todos los alumnos
     */
    public static function getAll() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("
            SELECT *
            FROM alumnos
            ORDER BY apellidos, nombre
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener los ciclos del alumno
     */
    public static function getCiclosAlumno($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("
            SELECT c.id
            FROM alumnos a
            JOIN ciclos c ON c.id = a.ciclo_id
            WHERE a.id = ?
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    /**
     * Buscar alumno por ID
     */
    public static function findById($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT a.id, a.usuario_id, a.nombre, a.apellidos, a.fecha_nacimiento, 
                   a.telefono, a.pais, a.provincia, a.ciudad, a.direccion, 
                   a.codigo_postal, a.ciclo_id, a.fecha_inicio, a.fecha_fin,
                   a.created_at,
                   u.email, c.nombre as ciclo_nombre,
                   CASE WHEN a.cv IS NOT NULL THEN 1 ELSE 0 END as tiene_cv,
                   CASE WHEN a.foto IS NOT NULL THEN 1 ELSE 0 END as tiene_foto
            FROM alumnos a
            JOIN usuarios u ON a.usuario_id = u.id
            LEFT JOIN ciclos c ON a.ciclo_id = c.id
            WHERE a.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    /**
     * Actualizar alumno
     */
    public static function update($id, $data) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            UPDATE alumnos 
            SET nombre = ?, apellidos = ?, fecha_nacimiento = ?, pais = ?, provincia = ?,
            ciudad = ?, codigo_postal = ?, direccion = ?, telefono = ?,
            ciclo_id = ?, fecha_inicio = ?, fecha_fin = ?
            WHERE id = ?
        ");

        $id = $data['id'];
        $email = $data['email'];
        if(!User::emailExists($email))
        {
            User::editEmail($id, $email);
        }

        return $stmt->execute([
            $data['nombre'],
            $data['apellidos'],
            $data['fecha_nacimiento'],
            $data['pais'],
            $data['provincia'],
            $data['ciudad'],
            $data['codigo_postal'],
            $data['direccion'],
            $data['telefono'],
            $data['ciclo_id'],
            $data['fecha_inicio'],
            $data['fecha_fin'],
            $data['id']
        ]);


    }
    
    /**
     * Eliminar alumno
     */
    public static function delete($id) {
        $db = Database::getInstance()->getConnection();
        
        $alumno = self::findById($id);
        
        $db->beginTransaction();
        try {
            $stmt = $db->prepare("DELETE FROM alumnos WHERE id = ?");
            $stmt->execute([$id]);
            
            $stmt = $db->prepare("DELETE FROM usuarios WHERE id = ?");
            $stmt->execute([$alumno['usuario_id']]);
            
            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }
    
    /**
     * Actualizar CV
     */
    public static function updateCV($alumnoId, $cvBlob) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE alumnos SET cv = ? WHERE id = ?");
        return $stmt->execute([$cvBlob, $alumnoId]);
    }
    
    /**
     * Obtener CV del alumno
     */
    public static function getCV($alumnoId) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT cv FROM alumnos WHERE id = ?");
        $stmt->execute([$alumnoId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['cv'] : null;
    }
    
    /**
     * Obtener foto del alumno
     */
    public static function getFoto($alumnoId) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT foto FROM alumnos WHERE id = ?");
        $stmt->execute([$alumnoId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['foto'] : null;
    }
    
    /**
     * Buscar alumno por usuario_id
     */
    public static function findByUsuarioId($usuarioId) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT a.id, a.usuario_id, a.nombre, a.apellidos, a.fecha_nacimiento, 
                   a.telefono, a.pais, a.provincia, a.ciudad, a.direccion, 
                   a.codigo_postal, a.ciclo_id, a.fecha_inicio, a.fecha_fin,
                   a.created_at,
                   u.email, c.nombre as ciclo_nombre,
                   CASE WHEN a.cv IS NOT NULL THEN 1 ELSE 0 END as tiene_cv,
                   CASE WHEN a.foto IS NOT NULL THEN 1 ELSE 0 END as tiene_foto
            FROM alumnos a
            JOIN usuarios u ON a.usuario_id = u.id
            LEFT JOIN ciclos c ON a.ciclo_id = c.id
            WHERE a.usuario_id = ?
        ");
        $stmt->execute([$usuarioId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
