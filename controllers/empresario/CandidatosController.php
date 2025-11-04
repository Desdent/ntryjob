<?php
require_once __DIR__ . '/../../models/Oferta.php';

class CandidatosController {

    /**
     * GET - Listar alumnos postulados a una oferta
     */

    public function indexAllPostulantes($OfertaId){

        try{
            session_start();

            $idEmpresa = $_SESSION["empresa_id"];

            if (!$empresaId) {
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'No autorizado']);
                return;
            }
            
            $oferta = Oferta::findByID($OfertaId);

        }
    }

}