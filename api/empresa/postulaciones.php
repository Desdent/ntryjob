<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../dao/OfertaDAO.php';
require_once __DIR__ . '/../../dao/PostulacionDAO.php';
require_once __DIR__ . '/../../dao/EmpresaDAO.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';
require_once __DIR__.'/../../models/entities/CiclosAlumnosEntity.php';

session_start();
AuthMiddleware::requiereAuth(['empresario']);

$dao = new OfertaDAO();
$postulacionDAO = new PostulacionDAO();
$empresaDAO = new EmpresaDAO();
$metodo = $_SERVER['REQUEST_METHOD'];

try {
    switch ($metodo) {
        case 'POST':
            {
                $data = json_decode(file_get_contents("php://input"), true);
                $oferta_id = $data["ofertaId"];



                    $postulantes = $postulacionDAO->getPostulantesByOfertaId($oferta_id);


                    $postulaciones = [];
                    foreach($postulantes as $postulante)
                    {
                        $postulaciones[] = $postulacionDAO->getPostulacionByOfertaIdAlumnoId($oferta_id, $postulante->id);
                    }

                    if($postulaciones)
                    {
                        echo json_encode(["success" => true, "postulaciones" => $postulaciones]);
                    }
                    else
                    {
                        echo json_encode(["success" => false, "error" => "No hay postulantes"]);
                    }
            }
            break;
        case 'DELETE':
            $id = $_GET['id'] ?? null;
            if ($id) {
                $postulacionDAO->delete($id);
                echo json_encode(['success' => true]);
            }
            break;
        default:
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
