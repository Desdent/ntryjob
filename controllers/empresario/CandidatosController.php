<?php
require_once __DIR__ . '/../../dao/OfertaDAO.php';

class CandidatosController {
    private $ofertaDAO;
    
    public function __construct() {
        $this->ofertaDAO = new OfertaDAO();
    }
    
    public function indexAllPostulantes($OfertaId) {
        try {
            session_start();
            
            $idEmpresa = $_SESSION["empresa_id"] ?? null;
            
            if (!$idEmpresa) {
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'No autorizado']);
                return;
            }
            
            $oferta = $this->ofertaDAO->getById($OfertaId);
            
            if (!$oferta || $oferta->empresa_id != $idEmpresa) {
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'No autorizado']);
                return;
            }
            
            echo json_encode(['success' => true, 'oferta' => $oferta->toArray()]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
