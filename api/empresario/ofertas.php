<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../dao/OfertaDAO.php';
require_once __DIR__ . '/../../dao/EmpresaDAO.php';
require_once __DIR__ . '/../../models/entities/OfertaEntity.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

session_start();
AuthMiddleware::requiereAuth(['empresario']);

$ofertaDAO = new OfertaDAO();
$empresaDAO = new EmpresaDAO();
$metodo = $_SERVER['REQUEST_METHOD'];

try {
    $empresa = $empresaDAO->findByUsuarioId($_SESSION['user_id']);
    
    if (!$empresa) {
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'Empresa no encontrada']);
        exit;
    }
    
    switch ($metodo) {
        case 'GET':
            $ofertas = $ofertaDAO->getByEmpresa($empresa->id);
            echo json_encode(['success' => true, 'data' => array_map(fn($o) => $o->toArray(), $ofertas)]);
            break;
            
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true) ?: $_POST;
            $data['empresa_id'] = $empresa->id;
            $oferta = new OfertaEntity($data);
            $nueva = $ofertaDAO->create($oferta);
            echo json_encode(['success' => true, 'id' => $nueva->id]);
            break;
            
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            $data['empresa_id'] = $empresa->id;
            $oferta = new OfertaEntity($data);
            $result = $ofertaDAO->update($oferta);
            echo json_encode(['success' => true, 'updated' => $result]);
            break;
            
        case 'DELETE':
            $data = json_decode(file_get_contents('php://input'), true);
            if (empty($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'ID requerido']);
                return;
            }
            $result = $ofertaDAO->delete($data['id']);
            echo json_encode(['success' => true, 'deleted' => $result]);
            break;
            
        default:
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
