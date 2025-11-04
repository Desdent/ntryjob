<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Ciclo.php';

try {
    $ciclos = Ciclo::getAll();
    echo json_encode(['success' => true, 'data' => $ciclos]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}