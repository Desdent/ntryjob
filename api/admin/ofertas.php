<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../dao/OfertaDAO.php';
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
                echo json_encode($oferta ? $oferta->toArray() : null);
            } else {
                $ofertas = $dao->getAll();
                echo json_encode(array_map(fn($o) => $o->toArray(), $ofertas));
            }
            break;
        case 'POST':
            if (isset($_POST['empresa_id'])) {
                $ofertas = $dao->getByEmpresa($_POST['empresa_id']);
                echo json_encode(array_map(fn($o) => $o->toArray(), $ofertas));
            }
            break;
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            $oferta = new OfertaEntity($data);
            $dao->update($oferta);
            echo json_encode(['success' => true]);
            break;
        case 'DELETE':
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'] ?? null;
            if ($id) {
                $dao->delete($id);
                echo json_encode(['success' => true]);
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
