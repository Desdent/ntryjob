<?php
require_once __DIR__ . '/../../dao/OfertaDAO.php';
require_once __DIR__ . '/../../dao/AlumnoDAO.php';

class OfertasController {
    private $ofertaDAO;
    private $alumnoDAO;
    
    public function __construct() {
        $this->ofertaDAO = new OfertaDAO();
        $this->alumnoDAO = new AlumnoDAO();
    }
    
    public function index($cicloId) {
        try {
            $ofertas = $this->ofertaDAO->getAllByCiclos($cicloId);
            echo json_encode(['success' => true, 'ofertas' => array_map(fn($o) => $o->toArray(), $ofertas)]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    public function getCiclos($id) {
        try {
            $ciclos = $this->alumnoDAO->getCiclosAlumno($id);
            echo json_encode(['success' => true, 'ciclos' => $ciclos]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    public function getOfertas($ciclosArray) {
        try {
            $ofertas = $this->ofertaDAO->getAllByCiclos($ciclosArray);
            echo json_encode(['success' => true, 'ofertas' => array_map(fn($o) => $o->toArray(), $ofertas)]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
