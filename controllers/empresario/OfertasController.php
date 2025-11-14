<?php

// Requerir las dependencias
require_once __DIR__ . '/../../dao/OfertaDAO.php';
require_once __DIR__ . '/../../dao/EmpresaDAO.php';
require_once __DIR__ . '/../../dao/CicloDAO.php';
require_once __DIR__ . '/../../models/entities/OfertaEntity.php';

class OfertaController
{
    private OfertaDAO $ofertaDAO;
    private EmpresaDAO $empresaDAO;
    private CicloDAO $cicloDAO;

    public function __construct()
    {
        $this->ofertaDAO = new OfertaDAO();
        $this->empresaDAO = new EmpresaDAO();
        $this->cicloDAO = new CicloDAO();
    }



    public function _getEmpresaId(int $userId)
    {
        $empresa = $this->empresaDAO->findByUsuarioId($userId);

        if (!$empresa) {
            
            return 'Empresa no encontrada';
        }

        return $empresa->id;
    }


    public function getOfertasByEmpresa(int $userId)
    {

        $empresaId = $this->_getEmpresaId($userId);

        if (is_string($empresaId)) {
            return $empresaId; // Devuelve el mensaje de error si la empresa no existe
        }

        return $this->ofertaDAO->getByEmpresa($empresaId);
    }

    public function getAllCiclos()
    {
        return $this->cicloDAO->getAll();
    }


    public function getCicloById(int $cicloId)
    {
        $ciclo = $this->cicloDAO->getById($cicloId);

        if (!$ciclo) {
            return null;
        }

        return $ciclo->nombre;
    }
    
    public function create(int $userId, array $data)
    {
        $empresaId = $this->_getEmpresaId($userId);
        if (is_string($empresaId)) {
            return $empresaId;
        }

        $data['empresa_id'] = $empresaId;
        
        $oferta = new OfertaEntity($data);
        $nueva = $this->ofertaDAO->create($oferta);

        return $nueva->id;
    }

    public function update(int $userId, array $data)
    {
        $empresaId = $this->_getEmpresaId($userId);
        if (is_string($empresaId)) {
            return $empresaId;
        }

        $data['empresa_id'] = $empresaId;

        $oferta = new OfertaEntity($data);
        $result = $this->ofertaDAO->update($oferta);

        return $result;
    }

    public function delete(int $userId, ?int $ofertaId)
    {
        $empresaId = $this->_getEmpresaId($userId);
        if (is_string($empresaId)) {
            return $empresaId;
        }
        
        if (empty($ofertaId)) {
            return 'ID de oferta requerido';
        }

        $result = $this->ofertaDAO->delete($ofertaId);

        return $result;
    }
}