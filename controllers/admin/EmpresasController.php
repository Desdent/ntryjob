<?php
require_once __DIR__ . '/../../dao/EmpresaDAO.php';

class EmpresasController {
    private $dao;
    
    public function __construct() {
        $this->dao = new EmpresaDAO();
    }
    
    public function index() {
        try {
            $empresas = $this->dao->getPendientes();
            echo json_encode(['success' => true, 'empresas' => array_map(fn($e) => $e->toArray(), $empresas)]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    public function aprobar() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'ID requerido']);
                return;
            }
            
            $action = $data['action'] ?? 'aprobar';
            
            if ($action === 'aprobar') {
                $result = $this->dao->aprobar($data["id"]);
            } else {
                $result = $this->dao->rechazar($data["id"]);
                $deleted = $this->dao->delete($data["id"]);
            }
            
            echo json_encode(['success' => true, 'action' => $action]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
