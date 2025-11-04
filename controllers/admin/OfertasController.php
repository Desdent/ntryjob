<?php
require_once __DIR__ . '/../../models/Oferta.php';
require_once __DIR__ . '/../../models/Empresa.php';

class OfertasController {
    
    /**
     * GET - Listar todas las ofertas
     */
    public function index() {
        try {
            $ofertas = Oferta::getAll();
            echo json_encode(['success' => true, 'data' => $ofertas]);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    /**
     * PUT - Editar cualquier oferta
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
     * DELETE - Eliminar cualquier oferta
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


















    

    /**
     * 
     */
    public function findByEmpresaByID()
    {
        try{
            $data = json_decode(file_get_contents('php://input'), true);

            if (empty($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'ID requerido']);
                return;
            }

            $result = Empresa::findEmpresaById($data['id']);
            echo json_encode(['success' => true, 'nombre' => $result ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
