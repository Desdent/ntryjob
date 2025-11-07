<?php
session_start();
require_once __DIR__ . '/../../dao/AlumnoDAO.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

AuthMiddleware::requiereAuth(['alumno', 'empresario', 'admin']);

try {
    $dao = new AlumnoDAO();
    
    if ($_SESSION['role'] === 'alumno') {
        $alumno = $dao->findByUsuarioId($_SESSION['user_id']);
        $alumnoId = $alumno->id;
    } else {
        $alumnoId = $_GET['alumno_id'] ?? null;
        if (!$alumnoId) {
            http_response_code(400);
            echo 'ID de alumno requerido';
            exit;
        }
    }
    
    $cv = $dao->getCV($alumnoId);
    
    if (!$cv) {
        http_response_code(404);
        echo 'CV no encontrado';
        exit;
    }
    
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="cv_alumno_' . $alumnoId . '.pdf"');
    header('Content-Length: ' . strlen($cv));
    
    echo $cv;
} catch (Exception $e) {
    http_response_code(500);
    echo 'Error al descargar CV: ' . $e->getMessage();
}
