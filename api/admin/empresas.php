<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../dao/EmpresaDAO.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

session_start();
AuthMiddleware::requiereAuth(['admin']);

$dao = new EmpresaDAO();
$metodo = $_SERVER['REQUEST_METHOD'];

try {
    switch ($metodo) {
        case 'GET':
            if (isset($_GET['pendientes'])) {
                $empresas = $dao->getPendientes();
            } else {
                $empresas = $dao->getAll();
            }
            echo json_encode(['success' => true, 'empresas' => array_map(fn($e) => $e->toArray(), $empresas)]);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($data['id'])) {
                $dao->aprobar($data['id']);
                echo json_encode(['success' => true]);
            }
            break;
        case 'DELETE':
            $id = $_GET['id'] ?? null;
            if ($id) {
                $dao->delete($id);
                echo json_encode(['success' => true]);
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
