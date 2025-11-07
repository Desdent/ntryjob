<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../dao/EmpresaDAO.php';
require_once __DIR__ . '/../../dao/OfertaDAO.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

AuthMiddleware::requiereAuth(['admin']);

try {
    $empresaDAO = new EmpresaDAO();
    $ofertaDAO = new OfertaDAO();
    
    $empresas = $empresaDAO->getAll();
    $ofertas = $ofertaDAO->getAll();
    
    echo json_encode([
        'success' => true,
        'empresas' => count($empresas),
        'ofertas' => count($ofertas)
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
