<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../dao/AlumnoDAO.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

AuthMiddleware::requiereAuth(['admin']);

try {
    $dao = new AlumnoDAO();
    $alumnos = $dao->getAll();
    $alumnosArray = array_map(fn($a) => $a->toArray(), $alumnos);
    echo json_encode(['success' => true, 'alumnos' => $alumnosArray]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
