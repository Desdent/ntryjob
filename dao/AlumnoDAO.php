<?php
require_once __DIR__.'/DAOInterface.php';
require_once __DIR__.'/UserDAO.php';
require_once __DIR__.'/../models/entities/AlumnoEntity.php';
require_once __DIR__.'/../config/Database.php';

class AlumnoDAO implements DAOInterface {
    private $db;
    public function __construct() { $this->db = Database::getInstance()->getConnection(); }
    
    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT a.*, u.email, c.nombre as ciclo_nombre,
                CASE WHEN a.cv IS NOT NULL THEN 1 ELSE 0 END as tiene_cv,
                CASE WHEN a.foto IS NOT NULL THEN 1 ELSE 0 END as tiene_foto
            FROM alumnos a
            JOIN usuarios u ON a.usuario_id = u.id
            LEFT JOIN ciclos c ON a.ciclo_id = c.id
            WHERE a.id = ?
        ");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new AlumnoEntity($row) : null;
    }
    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT a.*, u.email, c.nombre as ciclo_nombre,
                CASE WHEN a.cv IS NOT NULL THEN 1 ELSE 0 END as tiene_cv,
                CASE WHEN a.foto IS NOT NULL THEN 1 ELSE 0 END as tiene_foto
            FROM alumnos a
            JOIN usuarios u ON a.usuario_id = u.id
            LEFT JOIN ciclos c ON a.ciclo_id = c.id
            ORDER BY a.apellidos, a.nombre
        ");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) $result[] = new AlumnoEntity($row);
        return $result;
    }
    
    public function create($alumno) {
        $this->db->beginTransaction();
        try {
            $userDAO = new UserDAO();
            if ($userDAO->emailExists($alumno->email)) {
                throw new Exception('El email ya está registrado');
            }
            
            // Asegurar que la contraseña esté hasheada
            $password = $alumno->password ?: 'admin123';
            $usuarioId = $userDAO->createUser($alumno->email, $password);
            
            $stmt = $this->db->prepare("
                INSERT INTO alumnos (
                    usuario_id, nombre, apellidos, fecha_nacimiento, telefono, 
                    pais, provincia, ciudad, direccion, codigo_postal, 
                    ciclo_id, fecha_inicio, fecha_fin, cv, foto
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $usuarioId, $alumno->nombre, $alumno->apellidos, $alumno->fecha_nacimiento ?? null,
                $alumno->telefono ?? null, $alumno->pais ?? null, $alumno->provincia ?? null,
                $alumno->ciudad ?? null, $alumno->direccion ?? null, $alumno->codigo_postal ?? null,
                (isset($alumno->ciclo_id) && $alumno->ciclo_id !== '') ? (int)$alumno->ciclo_id : null,
                $alumno->fecha_inicio ?? null, $alumno->fecha_fin ?? null,
                $alumno->cv ?? null, $alumno->foto ?? null
            ]);
            
            $alumno->id = $this->db->lastInsertId();
            $this->db->commit();
            return $alumno;
        } catch (Exception $e) { 
            $this->db->rollBack(); 
            throw $e; 
        }
    }
    
    public function update($alumno) {
        $alumnoActual = $this->getById($alumno->id);
        if (!$alumnoActual) {
            throw new Exception('Alumno no encontrado');
        }
        
        $userDAO = new UserDAO();
        if (isset($alumno->email)) {
            if ($alumnoActual->email !== $alumno->email) {
                if ($userDAO->emailExists($alumno->email)) {
                    throw new Exception('El email ya está registrado por otro usuario');
                }
                $userDAO->editEmail($alumnoActual->usuario_id, $alumno->email);
            }
        }
        
        $stmt = $this->db->prepare("
            UPDATE alumnos SET nombre=?, apellidos=?, fecha_nacimiento=?, pais=?, provincia=?,
            ciudad=?, codigo_postal=?, direccion=?, telefono=?, ciclo_id=?, fecha_inicio=?, fecha_fin=?
            WHERE id=?
        ");
        return $stmt->execute([
            $alumno->nombre, $alumno->apellidos, $alumno->fecha_nacimiento, $alumno->pais, $alumno->provincia, 
            $alumno->ciudad, $alumno->codigo_postal, $alumno->direccion, $alumno->telefono, $alumno->ciclo_id, 
            $alumno->fecha_inicio, $alumno->fecha_fin, $alumno->id
        ]);
    }
    
    public function delete($id) {
        $alumno = $this->getById($id);
        if (!$alumno) return false;
        
        $this->db->beginTransaction();
        try {
            $this->db->prepare("DELETE FROM alumnos WHERE id=?")->execute([$id]);
            $this->db->prepare("DELETE FROM usuarios WHERE id=?")->execute([$alumno->usuario_id]);
            $this->db->commit();
            return true;
        } catch (Exception $e) { 
            $this->db->rollBack(); 
            throw $e; 
        }
    }
    
    public function findByUsuarioId($usuarioId) {
        $stmt = $this->db->prepare("
            SELECT a.*, u.email, c.nombre as ciclo_nombre,
                CASE WHEN a.cv IS NOT NULL THEN 1 ELSE 0 END as tiene_cv,
                CASE WHEN a.foto IS NOT NULL THEN 1 ELSE 0 END as tiene_foto
            FROM alumnos a
            JOIN usuarios u ON a.usuario_id = u.id
            LEFT JOIN ciclos c ON a.ciclo_id = c.id
            WHERE a.usuario_id = ?
        ");
        $stmt->execute([$usuarioId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new AlumnoEntity($row) : null;
    }
    
    public function updateCV($alumnoId, $cvBlob) {
        $stmt = $this->db->prepare("UPDATE alumnos SET cv = ? WHERE id = ?");
        return $stmt->execute([$cvBlob, $alumnoId]);
    }
    
    public function getCV($alumnoId) {
        $stmt = $this->db->prepare("SELECT cv FROM alumnos WHERE id = ?");
        $stmt->execute([$alumnoId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['cv'] : null;
    }
    
    public function getFoto($alumnoId) {
        $stmt = $this->db->prepare("SELECT foto FROM alumnos WHERE id = ?");
        $stmt->execute([$alumnoId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['foto'] : null;
    }
    
    public function getCiclosAlumno($id) {
        $ciclos = [];
        
        // Obtener ciclo principal
        $stmt = $this->db->prepare("SELECT ciclo_id FROM alumnos WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result && $result['ciclo_id']) {
            $ciclos[] = (int)$result['ciclo_id'];
        }
        
        // Obtener ciclos adicionales de alumno_ciclos
        $stmt = $this->db->prepare("SELECT ciclo_id FROM alumno_ciclos WHERE alumno_id = ?");
        $stmt->execute([$id]);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ciclos[] = (int)$row['ciclo_id'];
        }
        
        return array_unique($ciclos);
    }
}