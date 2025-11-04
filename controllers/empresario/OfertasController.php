<?php
require_once __DIR__ . '/../../models/Oferta.php';

class OfertasController {
    
    /**
     * GET - Listar mis ofertas
     */
    public function index() {
        try {
            session_start();
            $empresaId = $_SESSION['empresa_id'] ?? null;
            
            if (!$empresaId) {
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'No autorizado']);
                return;
            }
            
            $ofertas = Oferta::getByEmpresa($empresaId);
            echo json_encode(['success' => true, 'data' => $ofertas]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    
    /**
     * POST - Crear oferta
     */
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
            
            $id = Oferta::create($data);
            echo json_encode(['success' => true, 'id' => $id]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    /**
     * PUT - Actualizar oferta
     */
    public function update() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'ID requerido']);
                return;
            }
            
            $result = Oferta::update($data['id'], $data);
            echo json_encode(['success' => true, 'updated' => $result]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    /**
     * DELETE - Eliminar oferta
     */
    public function delete() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'ID requerido']);
                return;
            }
            
            $result = Oferta::delete($data['id']);
            echo json_encode(['success' => true, 'deleted' => $result]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
