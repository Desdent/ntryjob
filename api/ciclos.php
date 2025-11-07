<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../dao/CicloDAO.php';

try {
    $dao = new CicloDAO();
    $ciclos = $dao->getAll();
    echo json_encode(['success' => true, 'data' => array_map(fn($c) => $c->toArray(), $ciclos)]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
