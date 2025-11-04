<?php
session_start();
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Empresa.php';

try {
    $empresaId = $_GET['empresa_id'] ?? null;
    
    if (!$empresaId) {
        http_response_code(400);
        echo 'ID de empresa requerido';
        exit;
    }
    
    $logo = Empresa::getLogo($empresaId);
    
    if (!$logo) {
        http_response_code(404);
        echo 'Logo no encontrado';
        exit;
    }
    
    header('Content-Type: image/jpeg');
    header('Content-Length: ' . strlen($logo));
    header('Cache-Control: max-age=86400');
    
    echo $logo;
    
} catch (Exception $e) {
    http_response_code(500);
    echo 'Error al descargar logo: ' . $e->getMessage();
}