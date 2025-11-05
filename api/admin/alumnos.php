<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

AuthMiddleware::requiereAuth(['admin']);

try {
    $pdo = Database::getInstance()->getConnection();
    
    $stmt = $pdo->query("
        SELECT 
        a.id, a.usuario_id, a.nombre, a.apellidos, a.fecha_nacimiento, a.telefono, 
        a.pais, a.provincia, a.ciudad, a.direccion, a.codigo_postal, 
        a.ciclo_id, a.fecha_inicio, a.fecha_fin, 
        u.email, c.nombre as ciclo_nombre,
        -- Puedes incluir banderas booleanas en lugar de los datos BLOB:
        CASE WHEN a.cv IS NOT NULL THEN 1 ELSE 0 END AS tiene_cv,
        CASE WHEN a.foto IS NOT NULL THEN 1 ELSE 0 END AS tiene_foto
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

