<?php
// Headers CORS y JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

require_once __DIR__ . '/../../controllers/admin/EstadisticasController.php';

$controller = new EstadisticasController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller->getStats();
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
?>
