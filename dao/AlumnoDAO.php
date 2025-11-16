<?php
require_once __DIR__.'/DAOInterface.php';
require_once __DIR__.'/UserDAO.php';
require_once __DIR__.'/CicloDAO.php';
require_once __DIR__.'/../models/entities/AlumnoEntity.php';
require_once __DIR__.'/../models/entities/CiclosAlumnosEntity.php';
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


    public function searchAlumnos($searchValue) {
        $searchParam = "%" . $searchValue . "%";
        
        $stmt = $this->db->prepare("
            SELECT 
                a.id, a.usuario_id, a.nombre, a.apellidos, a.telefono, 
                a.fecha_nacimiento, a.pais, a.provincia, a.ciudad, 
                a.direccion, a.codigo_postal, a.ciclo_id, a.fecha_inicio, 
                a.fecha_fin, a.verificado, a.created_at,
                u.email,
                CASE WHEN a.cv IS NOT NULL THEN 1 ELSE 0 END as tiene_cv,
                CASE WHEN a.foto IS NOT NULL THEN 1 ELSE 0 END as tiene_foto
            FROM alumnos a
            JOIN usuarios u ON a.usuario_id = u.id
            WHERE LOWER(a.nombre) LIKE LOWER(?)
                OR LOWER(a.apellidos) LIKE LOWER(?)
                OR LOWER(a.telefono) LIKE LOWER(?)
                OR LOWER(a.ciudad) LIKE LOWER(?)
                OR LOWER(u.email) LIKE LOWER(?)
            ORDER BY a.apellidos, a.nombre
        ");

        $stmt->execute([$searchParam, $searchParam, $searchParam, $searchParam, $searchParam]);
        //No hace falta hacerle (int) a ningun parametro, parece que la base de datos lo pasa automatico
        
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new AlumnoEntity($row);
        }
        
        return $result;
    }
    

    public function getAll() {
        $stmt = $this->db->query("
            SELECT 
                a.id, a.usuario_id, a.nombre, a.apellidos, a.telefono, 
                a.fecha_nacimiento, a.pais, a.provincia, a.ciudad, 
                a.direccion, a.codigo_postal, a.ciclo_id, a.fecha_inicio, 
                a.fecha_fin, a.verificado, a.created_at,
                u.email,
                CASE WHEN a.cv IS NOT NULL THEN 1 ELSE 0 END as tiene_cv,
                CASE WHEN a.foto IS NOT NULL THEN 1 ELSE 0 END as tiene_foto
            FROM alumnos a
            JOIN usuarios u ON a.usuario_id = u.id
        ");
        
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new AlumnoEntity($row);
        }
        
        return $result;
    }
    
    public function create($alumno) {
        $this->db->beginTransaction();
        try {
            $userDAO = new UserDAO();
            if ($userDAO->emailExists($alumno->email)) {
                throw new Exception('El email ya está registrado');
            }

            // Determinar si es un registro verificado o no
            $verificado = 0; // Por defecto, no verificado (creado por admin)
            $password = $alumno->password;
            
            // Si no hay contraseña usar una temporal
            if (empty($password)) {
                $password = 'admin123'; // contraseña temporal
            } else {
                // Si el alumno proporciona contraseña, entonces es verificado
                $verificado = 1;
            }
            
            $usuarioId = $userDAO->createUser($alumno->email, $password);
            
            $stmt = $this->db->prepare("
                INSERT INTO alumnos (
                    usuario_id, nombre, apellidos, fecha_nacimiento, telefono, 
                    pais, provincia, ciudad, direccion, codigo_postal, 
                    ciclo_id, fecha_inicio, fecha_fin, cv, foto, verificado
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $usuarioId, $alumno->nombre, $alumno->apellidos, $alumno->fecha_nacimiento ?? null,
                $alumno->telefono ?? null, $alumno->pais ?? null, $alumno->provincia ?? null,
                $alumno->ciudad ?? null, $alumno->direccion ?? null, $alumno->codigo_postal ?? null,
                (isset($alumno->ciclo_id) && $alumno->ciclo_id !== '') ? (int)$alumno->ciclo_id : null,
                $alumno->fecha_inicio ?? null, $alumno->fecha_fin ?? null,
                $alumno->cv ?? null, $alumno->foto ?? null,
                $verificado  // 1 si es registro público, 0 si es creado por admin
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
            SELECT a.*, u.email
            FROM alumnos a
            JOIN usuarios u ON a.usuario_id = u.id
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

        $daoCiclo = new CicloDAO();

        // Obtener ciclo principal
        $stmt = $this->db->prepare("SELECT ciclo_id FROM alumnos WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        $alumno = $this->findByUsuarioId($id);
        if($alumno->ciclo_id)
        {
            $datosKV = [
                "nombre_ciclo" => $daoCiclo->getById($alumno->ciclo_id)->nombre,
                "alumno_id" => $alumno->id,
                "ciclo_id" => $alumno->ciclo_id,
                "fecha_inicio" => $alumno->fecha_inicio,
                "fecha_fin" => $alumno->fecha_fin
            ];

            $ciclos[] = new CiclosAlumnosEntity($datosKV);
        }

        
        $stmt = $this->db->prepare("SELECT * FROM alumno_ciclos WHERE alumno_id = ?");
        $stmt->execute([$id]);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ciclos[] = new CiclosAlumnosEntity($row);
        }
        
        return $ciclos;
    }
}