<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../dao/AlumnoDAO.php';
require_once __DIR__ . '/../../models/entities/AlumnoEntity.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    try {
        $data = json_decode(file_get_contents('php://input'), true) ?: $_POST;
        
        if ($data['password'] !== $data['password_confirm']) {
            echo json_encode(['success' => false, 'error' => 'Las contraseñas no coinciden']);
            exit;
        }
        
        $dao = new AlumnoDAO();
        $alumno = new AlumnoEntity($data);
        $nuevo = $dao->create($alumno);
        
        echo json_encode(['success' => true, 'message' => 'Registro exitoso']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
