<?php
require_once __DIR__ . '/../../dao/OfertaDAO.php';
require_once __DIR__ . '/../../dao/EmpresaDAO.php';
require_once __DIR__ . '/../../models/entities/OfertaEntity.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

class OfertasController {
    private $dao;
    private $empresaDAO;
    
    public function __construct() {
        $this->dao = new OfertaDAO();
        $this->empresaDAO = new EmpresaDAO();
    }
    
    public function index() {
        try {
            session_start();
            AuthMiddleware::requiereAuth(['empresario']);
            
            $empresa = $this->empresaDAO->findByUsuarioId($_SESSION['user_id']);
            if (!$empresa) {
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'Empresa no encontrada']);
                return;
            }
            
            $ofertas = $this->dao->getByEmpresa($empresa->id);
            echo json_encode(['success' => true, 'data' => array_map(fn($o) => $o->toArray(), $ofertas)]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    public function create() {
        try {
            session_start();
            AuthMiddleware::requiereAuth(['empresario']);
            
            $empresa = $this->empresaDAO->findByUsuarioId($_SESSION['user_id']);
            if (!$empresa) {
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'Empresa no encontrada']);
                return;
            }
            
            $data = json_decode(file_get_contents('php://input'), true);
            if (!$data) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
                return;
            }
            
            $data['empresa_id'] = $empresa->id;
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

