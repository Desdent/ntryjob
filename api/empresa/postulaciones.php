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



                    $postulantes = $postulacionDAO->getPostulantesByOfertaId($data["ofertaId"]);
                    // TO-DO: ACABAR, SACAR LAS POSTULACIONES CON EL ID DE LA FOERTA Y EL ID DEL ALUMNO (LO TRAE EN EL OBJETO EN POSTULANTES)
                            //Y CON ESO SACAR LAS POSTULACIONES PARA CAMBIAR SUS ESTADOS 

                    if($postulantes)
                    {
                        echo json_encode(["success" => true, "postulantes" => $postulantes]);
                    }
                    else
                    {
                        echo json_encode(["success" => false, "error" => "No hay postulantes"]);
                    }
            }
            break;
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($data['id'])) {
                $dao->aprobar($data['id']);
                echo json_encode(['success' => true]);
            }
            break;
        case 'DELETE':
            $id = $_GET['id'] ?? null;
            if ($id) {
                $dao->delete($id);
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
