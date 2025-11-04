<?php
require_once __DIR__ . '/../../models/Oferta.php';
require_once __DIR__ . '/../../models/Alumno.php';

class OfertasController {
    
    /**
     * GET - Listar empresas de X ciclo
     */
    public function index($cicloId) {
        try {
            $ofertas = Oferta::getAllByCiclo($cicloId);
            echo json_encode(['success' => true, 'ofertas' => $ofertas]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }


    /**
     * GET - Obtener ciclos del alumno
     */


    public function getCiclos($id) {
        try {
            $ciclos = Alumno::getCiclosAlumno($id);
            echo json_encode(['success' => true, 'ciclos' => $ciclos]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }


    /**
     * GET - Obtener ofertas por ciclos
     */

    public function getOfertas($ciclosArray)
    {
        try {
            $ofertas = Oferta::getAllByCiclos($ciclosArray);
            echo json_encode(['success' => true, 'ofertas' => $ofertas]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    /**
     * PUT - Aprobar/Rechazar empresa
     */


    /**
     * DELETE
     */

}