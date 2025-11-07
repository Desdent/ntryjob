<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../dao/AlumnoDAO.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

AuthMiddleware::requiereAuth(['admin']);

try {
    $dao = new AlumnoDAO();
    $alumnos = $dao->getAll();
    
    // Convertir a array para JSON
    $alumnosArray = [];
    foreach ($alumnos as $alumno) {
        $alumnosArray[] = $alumno->toArray();
    }
    
    echo json_encode(['success' => true, 'alumnos' => $alumnosArray]);
} catch (Exception $e) {
    error_log("Error en alumnos.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Error al cargar alumnos: ' . $e->getMessage()]);
}