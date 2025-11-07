<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../dao/EmpresaDAO.php';
require_once __DIR__ . '/../../models/entities/EmpresaEntity.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    try {
        $data = $_POST;
        
        // Validaciones básicas
        $required = ['nombre', 'email', 'password', 'cif'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                echo json_encode(['success' => false, 'error' => "El campo $field es requerido"]);
                exit;
            }
        }
        
        if ($data['password'] !== $data['password_confirm']) {
            echo json_encode(['success' => false, 'error' => 'Las contraseñas no coinciden']);
            exit;
        }
        
        $dao = new EmpresaDAO();
        
        // Procesar logo
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $data['logo'] = file_get_contents($_FILES['logo']['tmp_name']);
        }
        
        $empresa = new EmpresaEntity($data);
        $nueva = $dao->create($empresa);
        
        echo json_encode(['success' => true, 'message' => 'Registro exitoso. Espera aprobación del admin.']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
