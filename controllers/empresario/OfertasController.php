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

    // --- Métodos Privados de Utilidad ---

    /**
     * Intenta encontrar la Empresa por el ID de usuario.
     * @param int $userId ID del usuario autenticado.
     * @return int|string El ID de la empresa si se encuentra, o un mensaje de error.
     */
    private function _getEmpresaId(int $userId)
    {
        $empresa = $this->empresaDAO->findByUsuarioId($userId);

        if (!$empresa) {
            // Devolver un string de error.
            return 'Empresa no encontrada';
        }

        return $empresa->id;
    }

    // --- Métodos de Acción ---

    /**
     * Obtiene todas las ofertas de la empresa del usuario autenticado.
     * @param int $userId ID del usuario autenticado.
     * @return array<OfertaEntity>|string Lista de objetos OfertaEntity o un mensaje de error.
     */
    public function getOfertasByEmpresa(int $userId)
    {
        $empresaId = $this->_getEmpresaId($userId);

        if (is_string($empresaId)) {
            return $empresaId; // Devuelve el mensaje de error si la empresa no existe
        }

        // Devolver directamente la lista de objetos OfertaEntity (sin array_map)
        return $this->ofertaDAO->getByEmpresa($empresaId);
    }

    /**
     * Obtiene el nombre de un Ciclo por su ID.
     * @param int $cicloId ID del ciclo a buscar.
     * @return string|null El nombre del ciclo o null/string de error.
     */
    public function getCicloById(int $cicloId)
    {
        $ciclo = $this->cicloDAO->getById($cicloId);

        if (!$ciclo) {
            return null;
        }

        return $ciclo->nombre;
    }
    
    /**
     * Crea una nueva oferta.
     * @param int $userId ID del usuario autenticado.
     * @param array $data Los datos de la oferta a crear.
     * @return int|string El ID de la nueva oferta o un mensaje de error.
     */
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

    /**
     * Actualiza una oferta existente.
     * @param int $userId ID del usuario autenticado.
     * @param array $data Los datos de la oferta a actualizar (debe incluir el 'id').
     * @return bool|string El resultado de la actualización (booleano) o un mensaje de error.
     */
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

    /**
     * Elimina una oferta.
     * @param int $userId ID del usuario autenticado.
     * @param ?int $ofertaId ID de la oferta a eliminar.
     * @return bool|string El resultado de la eliminación (booleano) o un mensaje de error.
     */
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