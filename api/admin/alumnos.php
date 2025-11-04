<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

AuthMiddleware::requiereAuth(['admin']);

try {
    $pdo = Database::getInstance()->getConnection();
    
    $stmt = $pdo->query("
        SELECT a.*, u.email, c.nombre as ciclo_nombre
        FROM alumnos a
        JOIN usuarios u ON a.usuario_id = u.id
        LEFT JOIN ciclos c ON a.ciclo_id = c.id
        ORDER BY a.apellidos, a.nombre
    ");
    
    $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'alumnos' => $alumnos]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

