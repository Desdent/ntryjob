<?php
require_once __DIR__.'/DAOInterface.php';
require_once __DIR__.'/../models/entities/OfertaEntity.php';
require_once __DIR__.'/../config/Database.php';

class OfertaDAO implements DAOInterface {
    private $db;
    public function __construct() { $this->db = Database::getInstance()->getConnection(); }
    
    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT o.*, e.nombre as empresa_nombre, c.nombre as ciclo_nombre
            FROM ofertas o
            JOIN empresas e ON o.empresa_id = e.id
            LEFT JOIN ciclos c ON o.ciclo_id = c.id
            WHERE o.id = ?
        ");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new OfertaEntity($row) : null;
    }

    public function getAll() {
        $stmt = $this->db->query("
            SELECT o.*, e.nombre as empresa_nombre, c.nombre as ciclo_nombre
            FROM ofertas o
            JOIN empresas e ON o.empresa_id = e.id
            LEFT JOIN ciclos c ON o.ciclo_id = c.id
            ORDER BY o.fecha_creacion DESC
        ");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new OfertaEntity($row);
        }
        return $result;
    }

    public function sortBy($parameter, $metodo, $userid)
    {
        if($metodo == "asc")
        {
            $metodoSQL = "ASC";
        }
        else
        {
            $metodoSQL = "DESC";
        }

        $stmt = $this->db->prepare("
            SELECT *
            FROM ofertas
            WHERE empresa_id = ?
            ORDER BY " . $parameter . " " . $metodoSQL);
        $result = [];
        $stmt->execute([$userid]);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new OfertaEntity($row);
        }
        return $result;
    }


    
    public function create($oferta) {
        $stmt = $this->db->prepare("
            INSERT INTO ofertas (empresa_id, titulo, descripcion, requisitos, ciclo_id, fecha_inicio, fecha_cierre, modalidad, salario) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $oferta->empresa_id, $oferta->titulo, $oferta->descripcion, $oferta->requisitos ?? null,
            $oferta->ciclo_id, $oferta->fecha_inicio, $oferta->fecha_cierre,
            $oferta->modalidad ?? 'presencial', $oferta->salario ?? null
        ]);
        $oferta->id = $this->db->lastInsertId();
        return $oferta;
    }
    
    public function update($oferta) {
        $stmt = $this->db->prepare("
            UPDATE ofertas SET titulo=?, descripcion=?, requisitos=?, ciclo_id=?, 
            fecha_cierre=?, modalidad=?, salario=? WHERE id=?
        ");
        return $stmt->execute([
            $oferta->titulo, $oferta->descripcion, $oferta->requisitos ?? null, $oferta->ciclo_id,
            $oferta->fecha_cierre, $oferta->modalidad ?? 'presencial', $oferta->salario ?? null, $oferta->id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM ofertas WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function getByEmpresa($empresaId) {
        $stmt = $this->db->prepare("
            SELECT o.*, e.nombre as empresa_nombre 
            FROM ofertas o 
            JOIN empresas e ON o.empresa_id = e.id 
            WHERE o.empresa_id = ?
        ");
        $stmt->execute([$empresaId]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new OfertaEntity($row);   
        }
        return $result;
    }


    
    public function getAllByCiclos($ciclosIds) {
        if (empty($ciclosIds)) {
            return [];
        }
        
        if (!is_array($ciclosIds)) {
            $ciclosIds = explode(',', $ciclosIds);
        }
        
        $ciclosIds = array_map('intval', $ciclosIds);
        $placeholders = implode(',', array_fill(0, count($ciclosIds), '?'));
        
        $stmt = $this->db->prepare("
            SELECT o.*, e.nombre as empresa_nombre, c.nombre as ciclo_nombre
            FROM ofertas o
            JOIN empresas e ON o.empresa_id = e.id
            LEFT JOIN ciclos c ON o.ciclo_id = c.id
            WHERE o.ciclo_id IN ($placeholders)
            ORDER BY o.fecha_creacion DESC
        ");
        $stmt->execute($ciclosIds);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new OfertaEntity($row);
        }
        return $result;
    }



    public function searchWord($searchValue, $empresaId)
    {

        
        $searchParam = "%" . $searchValue . "%";
        
        $sql = "";
        $params = [];
        
        if (empty($searchValue))
        {
            $sql = "
                SELECT 
                    *
                FROM ofertas
                WHERE empresa_id = ?
            ";
            $params = [$empresaId];
        }
        else
        {
            $sql = "
                SELECT 
                    *
                FROM ofertas
                WHERE empresa_id = ?
                AND (
                    LOWER(titulo) LIKE LOWER(?)
                    OR LOWER(descripcion) LIKE LOWER(?)
                    OR LOWER(fecha_inicio) LIKE LOWER(?)
                    OR LOWER(fecha_cierre) LIKE LOWER(?)
                    OR LOWER(salario) LIKE LOWER(?)
                )
            ";
            $params = [$empresaId, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam];
        }
        

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        $result = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new OfertaEntity($row);
        }
        
        return $result;
    }
}
