<?php
require_once __DIR__.'/DAOInterface.php';
require_once __DIR__.'/UserDAO.php';
require_once __DIR__.'/../models/entities/EmpresaEntity.php';
require_once __DIR__.'/../config/Database.php';

class EmpresaDAO implements DAOInterface {
    private $db;
    public function __construct() { $this->db = Database::getInstance()->getConnection(); }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM empresas WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new EmpresaEntity($row) : null;
    }

    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM empresas ORDER BY nombre");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new EmpresaEntity($row);
        }
        return $result;
    }

    
    public function create($empresa) {
        $this->db->beginTransaction();
        try {
            $userDAO = new UserDAO();
            
            // Asegurar que la contraseña esté hasheada
            $password = $empresa->password ?: 'admin123';
            $usuarioId = $userDAO->createUser($empresa->email, $password);
            
            $stmt = $this->db->prepare("
                INSERT INTO empresas (usuario_id, nombre, cif, telefono, sector, descripcion, 
                    pais, provincia, ciudad, direccion, logo, aprobada) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)
            ");
            $stmt->execute([
                $usuarioId, $empresa->nombre, $empresa->cif ?? null, $empresa->telefono ?? null,
                $empresa->sector ?? null, $empresa->descripcion ?? null, $empresa->pais ?? null,
                $empresa->provincia ?? null, $empresa->ciudad ?? null, $empresa->direccion ?? null,
                $empresa->logo ?? null
            ]);
            $empresa->id = $this->db->lastInsertId();
            $this->db->commit();
            return $empresa;
        } catch (Exception $e) { 
            $this->db->rollBack(); 
            throw $e; 
        }
    }
    
    public function update($empresa) {
        $stmt = $this->db->prepare("
            UPDATE empresas SET nombre=?, cif=?, telefono=?, sector=?, descripcion=?,
                pais=?, provincia=?, ciudad=?, direccion=? WHERE id=?
        ");
        return $stmt->execute([
            $empresa->nombre, $empresa->cif, $empresa->telefono, $empresa->sector, $empresa->descripcion,
            $empresa->pais, $empresa->provincia, $empresa->ciudad, $empresa->direccion, $empresa->id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM empresas WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function getPendientes() {
        $stmt = $this->db->query("SELECT * FROM empresas WHERE aprobada = 0 ORDER BY created_at DESC");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new EmpresaEntity($row);
        }
        return $result;
    }


    
    public function aprobar($id) {
        $stmt = $this->db->prepare("UPDATE empresas SET aprobada = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function rechazar($id) {
        $stmt = $this->db->prepare("UPDATE empresas SET aprobada = 0 WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function getLogo($id) {
        $stmt = $this->db->prepare("SELECT logo FROM empresas WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['logo'] : null;
    }


    
    public function findByUsuarioId($usuarioId) {
        $stmt = $this->db->prepare("SELECT * FROM empresas WHERE usuario_id = ?");
        $stmt->execute([$usuarioId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new EmpresaEntity($row) : null;
    }

}
