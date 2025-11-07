<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../dao/AlumnoDAO.php';
require_once __DIR__ . '/../../models/entities/AlumnoEntity.php';
require_once __DIR__ . '/../../config/Database.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    try {
        // Verificar si es JSON o FormData
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        
        if (strpos($contentType, 'application/json') !== false) {
            // Es JSON
            $data = json_decode(file_get_contents('php://input'), true);
        } else {
            // Es FormData
            $data = $_POST;
        }
        
        // Validaciones básicas
        $required = ['nombre', 'apellidos', 'email', 'password', 'telefono', 'ciclo_id'];
        $missing = [];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $missing[] = $field;
            }
        }
        
        if (!empty($missing)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Campos requeridos faltantes: ' . implode(', ', $missing)]);
            exit;
        }
        
        // Verificar confirmación de contraseña
        if (isset($data['password_confirm']) && $data['password'] !== $data['password_confirm']) {
            echo json_encode(['success' => false, 'error' => 'Las contraseñas no coinciden']);
            exit;
        }
        
        $dao = new AlumnoDAO();
        
        // Procesar archivos
        if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
            $data['cv'] = file_get_contents($_FILES['cv']['tmp_name']);
        }
        
        if (!empty($data['foto_base64'])) {
            $base64String = $data['foto_base64'];
            if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
                $base64String = substr($base64String, strpos($base64String, ',') + 1);
                $data['foto'] = base64_decode($base64String);
            }
        }
        
        $alumno = new AlumnoEntity($data);
        $nuevo = $dao->create($alumno);
        
        echo json_encode(['success' => true, 'message' => 'Registro exitoso']);
        
    } catch (Exception $e) {
        error_log("Error en registro-alumno.php: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Error del servidor: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
