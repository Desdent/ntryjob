<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../dao/AlumnoDAO.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

session_start();
AuthMiddleware::requiereAuth(['alumno']);

$dao = new AlumnoDAO();
$metodo = $_SERVER['REQUEST_METHOD'];

try {
    $alumno = $dao->findByUsuarioId($_SESSION['user_id']);
    
    switch ($metodo) {
        case 'GET':
            $cv = $dao->getCV($alumno->id);
            echo json_encode(['success' => true, 'tiene_cv' => $cv !== null]);
            break;
        case 'POST':
            if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
                $cvBlob = file_get_contents($_FILES['cv']['tmp_name']);
                $dao->updateCV($alumno->id, $cvBlob);
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'No se recibió archivo']);
            }
            break;
        case 'DELETE':
            $dao->updateCV($alumno->id, null);
            echo json_encode(['success' => true]);
            break;
        default:
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
