<?php

require_once __DIR__.'/../models/entities/CicloEntity.php';
require_once __DIR__.'/../config/Database.php';

class CicloAlumnosDAO {
    private $db;
    public function __construct() { $this->db = Database::getInstance()->getConnection(); }

    public function create($cicloAlumnos) {
        try {
            var_dump($cicloAlumnos);
            
            $stmt = $this->db->prepare("INSERT INTO alumno_ciclos (alumno_id, ciclo_id, nombre_ciclo, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?, ?)");
            
            $result = $stmt->execute([
                $cicloAlumnos->alumno_id,
                $cicloAlumnos->ciclo_id,
                $cicloAlumnos->nombre_ciclo,
                $cicloAlumnos->fecha_inicio,
                $cicloAlumnos->fecha_fin
            ]);
            
            if (!$result) {
                // Mostrar error específico
                var_dump($stmt->errorInfo());
                throw new Exception("Error en la ejecución: " . implode(", ", $stmt->errorInfo()));
            }
            
            $cicloAlumnos->id = $this->db->lastInsertId();
            return $cicloAlumnos;
            
        } catch (PDOException $e) {
            echo "PDOException: " . $e->getMessage();
            echo "\nCódigo de error: " . $e->getCode();
            throw $e;
        }
    }

    public function getAllByAlumnoId($alumno_id)
    {
        $stmt = $this->db->prepare("
            SELECT ac.*
            FROM alumno_ciclos ac
            JOIN alumnos a ON ac.alumno_id = a.id
            WHERE a.id = ? 
        ");
        $stmt->execute([$alumno_id]);
        
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $ciclosExtra = [];
        foreach ($rows as $row) {
            $ciclosExtra[] = new CiclosAlumnosEntity($row);
        }
        
        return $ciclosExtra; 
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM alumno_ciclos WHERE ciclo_id = ?");
        return $stmt->execute([$id]);
    }
    
}