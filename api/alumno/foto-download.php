<?php
session_start();
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/Alumno.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

AuthMiddleware::requiereAuth(['alumno', 'empresario', 'admin']);

try {
    if ($_SESSION['role'] === 'alumno') {
        $alumnoId = $_SESSION['alumno_id'];
    } else {
        $alumnoId = $_GET['alumno_id'] ?? null;
        
        if (!$alumnoId) {
            http_response_code(400);
            echo 'ID de alumno requerido';
            exit;
        }
    }
    
    $foto = Alumno::getFoto($alumnoId);
    
    if (!$foto) {
        http_response_code(404);
        echo 'Foto no encontrada';
        exit;
    }
    
    header('Content-Type: image/jpeg');
    header('Content-Length: ' . strlen($foto));
    header('Cache-Control: max-age=3600');
    
    echo $foto;
    
} catch (Exception $e) {
    http_response_code(500);
    echo 'Error al descargar foto: ' . $e->getMessage();
}