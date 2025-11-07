<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../dao/PostulacionDAO.php';
require_once __DIR__ . '/../../dao/AlumnoDAO.php';
require_once __DIR__ . '/../../models/entities/PostulacionEntity.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

session_start();
AuthMiddleware::requiereAuth(['alumno']);

$postulacionDAO = new PostulacionDAO();
$alumnoDAO = new AlumnoDAO();
$metodo = $_SERVER['REQUEST_METHOD'];

try {
    $alumno = $alumnoDAO->findByUsuarioId($_SESSION['user_id']);
    
    if (!$alumno) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Alumno no encontrado']);
        exit;
    }
    
    switch ($metodo) {
        case 'GET':
            $postulaciones = $postulacionDAO->getByAlumno($alumno->id);
            echo json_encode(['success' => true, 'postulaciones' => array_map(fn($p) => $p->toArray(), $postulaciones)]);
            break;
            
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            if (empty($data['oferta_id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'ID de oferta requerido']);
                exit;
            }
            
            $postulacion = new PostulacionEntity([
                'alumno_id' => $alumno->id,
                'oferta_id' => $data['oferta_id']
            ]);
            
            $nueva = $postulacionDAO->create($postulacion);
            echo json_encode(['success' => true, 'id' => $nueva->id]);
            break;
            
        case 'DELETE':
            $data = json_decode(file_get_contents('php://input'), true);
            if (empty($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'ID requerido']);
                exit;
            }
            
            $postulacionDAO->delete($data['id']);
            echo json_encode(['success' => true]);
            break;
            
        default:
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}