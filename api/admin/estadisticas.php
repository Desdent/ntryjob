<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

AuthMiddleware::requiereAuth(['admin']);

try {
    $pdo = Database::getInstance()->getConnection();
    
    $stmt = $pdo->query("SELECT COUNT(*) FROM empresas");
    $totalEmpresas = $stmt->fetchColumn();
    
    $totalOfertas = 0; // Temporal
    
    echo json_encode([
        'success' => true,
        'empresas' => $totalEmpresas,
        'ofertas' => $totalOfertas
    ]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
