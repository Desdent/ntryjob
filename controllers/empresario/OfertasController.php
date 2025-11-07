<?php
require_once __DIR__ . '/../../dao/OfertaDAO.php';
require_once __DIR__ . '/../../models/entities/OfertaEntity.php';

class OfertasController {
    private $dao;
    
    public function __construct() {
        $this->dao = new OfertaDAO();
    }
    
    public function index() {
        try {
            session_start();
            $empresaId = $_SESSION['empresa_id'] ?? null;
            
            if (!$empresaId) {
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'No autorizado']);
                return;
            }
            
            $ofertas = $this->dao->getByEmpresa($empresaId);
            echo json_encode(['success' => true, 'data' => array_map(fn($o) => $o->toArray(), $ofertas)]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    public function create() {
        try {
            session_start();
            $data = json_decode(file_get_contents('php://input'), true);
            
            $data['empresa_id'] = $_SESSION['empresa_id'] ?? null;
            
            if (!$data['empresa_id']) {
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'No autorizado']);
                return;
            }
            
            $oferta = new OfertaEntity($data);
            $nueva = $this->dao->create($oferta);
            echo json_encode(['success' => true, 'id' => $nueva->id]);
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
            $result = $this->dao->update($oferta);
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
            
            $result = $this->dao->delete($data['id']);
            echo json_encode(['success' => true, 'deleted' => $result]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}

