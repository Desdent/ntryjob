<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../controllers/auth/RegistroAlumnoController.php';

// No requiere autenticación (es el registro público)

$controller = new RegistroAlumnoController();

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $controller->register();
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
