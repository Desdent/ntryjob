<?php
require_once __DIR__.'/DAOInterface.php';
require_once __DIR__.'/UserDAO.php';
require_once __DIR__.'/../models/entities/EmpresaEntity.php';
require_once __DIR__.'/../config/Database.php';

class EmpresaDAO implements DAOInterface {
    private $db;
    public function __construct() { $this->db = Database::getInstance()->getConnection(); }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT e.*, u.*
                    FROM empresas e
                    JOIN usuarios u ON e.usuario_id = u.id
                    WHERE e.id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new EmpresaEntity($row) : null;
    }

    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT 
                e.nombre, e.cif, e.telefono, e.sector, e.pais, e.provincia, e.ciudad,
                e.direccion, e.aprobada, e.verificado, u.email,
                CASE WHEN logo IS NOT NULL THEN 1 ELSE 0 END as tiene_logo
            FROM empresas e
            JOIN usuarios u ON e.usuario_id = u.id
            WHERE e.aprobada = 1");
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
            $password = ($empresa->password) ? $empresa->password : 'admin123';
            $usuarioId = $userDAO->createUser($empresa->email, $password);
            
            if(empty($empresa->password))
            {
                $stmt = $this->db->prepare("
                INSERT INTO empresas (usuario_id, nombre, cif, telefono, sector, descripcion, 
                    pais, provincia, ciudad, direccion, logo, aprobada, verificado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 0)
                ");
            }
            else
            {
                $stmt = $this->db->prepare("
                INSERT INTO empresas (usuario_id, nombre, cif, telefono, sector, descripcion, 
                    pais, provincia, ciudad, direccion, logo, aprobada, verificado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 1)
                ");
            }
            
            $stmt->execute([
                $usuarioId, $empresa->nombre, $empresa->cif ?? null, $empresa->telefono,
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
        

        $empresaActual = $this->getById($empresa->id);
        if(!$empresaActual)
        {
            throw new Exception("Empresa no encontrada");
        }

        $userDAO = new UserDAO();
        if(isset($empresa->email))
        {
            if($empresaActual->email !== $empresa->email)
            {
                if($userDAO->emailExists($empresa->email))
                {
                    throw new Exception ("El email introducido ya está en uso");
                }
                $userDAO->editEmail($empresaActual->id, $empresa->email);
            }
        }

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
        $stmt = $this->db->query("
            SELECT 
                e.*, u.email,
                CASE WHEN logo IS NOT NULL THEN 1 ELSE 0 END as tiene_logo
            FROM empresas e
            JOIN usuarios u ON e.usuario_id = u.id
            WHERE e.aprobada = 0");
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

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT e.*, u.email, u.password
                                    FROM empresas e
                                    JOIN usuarios u ON e.usuario_id = u.id
                                    WHERE u.email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new EmpresaEntity($row) : null;
    }

    public function sortBy($parameter, $metodo)
    {
        if($metodo == "asc")
        {
            $metodoSQL = "ASC";
        }
        else
        {
            $metodoSQL = "DESC";
        }

        $stmt = $this->db->query("
            SELECT 
                e.nombre, e.cif, e.telefono, e.sector, e.pais, e.provincia, e.ciudad,
                e.direccion, e.aprobada, e.verificado, u.email,
                CASE WHEN logo IS NOT NULL THEN 1 ELSE 0 END as tiene_logo
            FROM empresas e
            JOIN usuarios u ON e.usuario_id = u.id
            WHERE e.aprobada = 1
            ORDER BY " . $parameter . " " . $metodoSQL);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new EmpresaEntity($row);
        }
        return $result;
    }

    public function sortPendientesBy($parameter, $metodo)
    {
        if($metodo == "asc")
        {
            $metodoSQL = "ASC";
        }
        else
        {
            $metodoSQL = "DESC";
        }

        $stmt = $this->db->query("
            SELECT 
                e.nombre, e.cif, e.telefono, e.sector, e.pais, e.provincia, e.ciudad,
                e.direccion, e.aprobada, e.verificado, u.email,
                CASE WHEN logo IS NOT NULL THEN 1 ELSE 0 END as tiene_logo
            FROM empresas e
            JOIN usuarios u ON e.usuario_id = u.id
            WHERE e.aprobada = 0
            ORDER BY " . $parameter . " " . $metodoSQL);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new EmpresaEntity($row);
        }
        return $result;
    }

    public function searchWord($searchValue)
    {
        $searchParam = "%" . $searchValue . "%";
        if(empty($searchValue))
        {
            $stmt = $this->db->prepare("
                SELECT 
                    e.*,
                    u.email
                FROM empresas e
                JOIN usuarios u ON e.usuario_id = u.id
                WHERE e.aprobada = 1
            ");
            $stmt->execute();
            
        }
        else
        {
            $stmt = $this->db->prepare("
            SELECT 
                e.*,
                u.email
            FROM empresas e
            JOIN usuarios u ON e.usuario_id = u.id
            WHERE (LOWER(e.nombre) LIKE LOWER(?)
                OR LOWER(e.cif) LIKE LOWER(?)
                OR LOWER(u.email) LIKE LOWER(?)
                OR LOWER(e.telefono) LIKE LOWER(?)
                OR LOWER(e.ciudad) LIKE LOWER(?)
                )
                AND e.aprobada = 1
            ");
        $stmt->execute([$searchParam, $searchParam, $searchParam, $searchParam, $searchParam]);
        }
        

        
        //No hace falta hacerle (int) a ningun parametro, parece que la base de datos lo pasa automatico
        
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new EmpresaEntity($row);
        }
        
        return $result;
    }

    public function searchPendientesWord($searchValue)
    {
        $searchParam = "%" . $searchValue . "%";
        if(empty($searchValue))
        {
            $stmt = $this->db->prepare("
                SELECT 
                    e.*,
                    u.email
                FROM empresas e
                JOIN usuarios u ON e.usuario_id = u.id
                WHERE e.aprobada = 1
            ");
            $stmt->execute();
            
        }
        else
        {
            $stmt = $this->db->prepare("
            SELECT 
                e.*,
                u.email
            FROM empresas e
            JOIN usuarios u ON e.usuario_id = u.id
            WHERE (LOWER(e.nombre) LIKE LOWER(?)
                OR LOWER(e.cif) LIKE LOWER(?)
                OR LOWER(u.email) LIKE LOWER(?)
                OR LOWER(e.telefono) LIKE LOWER(?)
                OR LOWER(e.ciudad) LIKE LOWER(?)
                )
                AND e.aprobada = 1
            ");
        $stmt->execute([$searchParam, $searchParam, $searchParam, $searchParam, $searchParam]);
        }
        

        
        //No hace falta hacerle (int) a ningun parametro, parece que la base de datos lo pasa automatico
        
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new EmpresaEntity($row);
        }
        
        return $result;
    }

}
