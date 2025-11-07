<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../dao/OfertaDAO.php';
require_once __DIR__ . '/../../models/entities/OfertaEntity.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

session_start();
AuthMiddleware::requiereAuth(['admin']);

$dao = new OfertaDAO();
$metodo = $_SERVER['REQUEST_METHOD'];

try {
    switch ($metodo) {
        case 'GET':
            if (isset($_GET['id'])) {
                $oferta = $dao->getById($_GET['id']);
                echo json_encode(['success' => true, 'data' => $oferta ? $oferta->toArray() : null]);
            } else {
                $ofertas = $dao->getAll();
                echo json_encode(['success' => true, 'data' => array_map(fn($o) => $o->toArray(), $ofertas)]);
            }
            break;
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            if (empty($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'ID requerido']);
                break;
            }
            $oferta = new OfertaEntity($data);
            $result = $dao->update($oferta);
            echo json_encode(['success' => true, 'updated' => $result]);
            break;
        case 'DELETE':
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'] ?? null;
            if ($id) {
                $result = $dao->delete($id);
                echo json_encode(['success' => true, 'deleted' => $result]);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'ID requerido']);
            }
            break;
        default:
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
