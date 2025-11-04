<?php
require_once __DIR__ . '/../../models/Empresa.php';

class EmpresasController {
    
    /**
     * GET - Listar empresas pendientes
     */
    public function index() {
        try {
            $empresas = Empresa::getPendientes();
            echo json_encode(['success' => true, 'empresas' => $empresas]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    /**
     * PUT - Aprobar/Rechazar empresa
     */
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
                $result = Empresa::aprobar($data["id"]);
            } else {
                $result = Empresa::rechazar($data["id"]);
                $deleted = Empresa::borrar($data["id"]); //No se que hacer por ahora con las empresas rechazadas
            }
            
            echo json_encode(['success' => true, 'action' => $action]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }


    /**
     * DELETE
     */
}
