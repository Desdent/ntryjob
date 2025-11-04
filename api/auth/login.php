<?php
session_start();  
header('Content-Type: application/json');

require_once __DIR__ . '/../../config/Database.php'; 
require_once __DIR__ . '/../../controllers/auth/LoginController.php'; 

$controller = new LoginController();

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $controller->login();
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
