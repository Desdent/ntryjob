<?php
require_once __DIR__ . '/../../dao/OfertaDAO.php';
require_once __DIR__ . '/../../dao/EmpresaDAO.php';
require_once __DIR__ . '/../../models/entities/OfertaEntity.php';

class OfertasController {
    private $ofertaDAO;
    private $empresaDAO;
    
    public function __construct() {
        $this->ofertaDAO = new OfertaDAO();
        $this->empresaDAO = new EmpresaDAO();
    }
    
    public function index() {
        try {
            $ofertas = $this->ofertaDAO->getAll();
            echo json_encode(['success' => true, 'data' => array_map(fn($o) => $o->toArray(), $ofertas)]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    public function update() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'ID requerido']);
                return;
            }
            
            $oferta = new OfertaEntity($data);
            $result = $this->ofertaDAO->update($oferta);
            echo json_encode(['success' => true, 'updated' => $result]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    public function delete() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'ID requerido']);
                return;
            }
            
            $result = $this->ofertaDAO->delete($data['id']);
            echo json_encode(['success' => true, 'deleted' => $result]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    public function findByEmpresaByID() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'ID requerido']);
                return;
            }
            
            $empresa = $this->empresaDAO->getById($data['id']);
            echo json_encode(['success' => true, 'nombre' => $empresa ? $empresa->nombre : null]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}

