<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../controllers/auth/RegistroEmpresaController.php';

$controller = new RegistroEmpresaController();

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $controller->register();
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}