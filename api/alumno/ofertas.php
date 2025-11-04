<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../controllers/alumno/OfertasController.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../../models/Alumno.php';


session_start();

$id = $_SESSION["id"];
AuthMiddleware::requiereAuth(['alumno']);

$controlador = new OfertasController();
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        if(isset($_GET["action"]) && $_GET["action"] === "findCiclos")
        {
            $controlador->getCiclos($id);
        }
        else
        {
            // Recibe múltiples IDs: ?action=byCiclos&ids=1,2,3
            $ids = $_GET['ids'] ?? '';
            $ciclosArray = explode(',', $ids);
            $controlador->getOfertas($ciclosArray);
        }
        
        break;
    case 'POST':
        
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
}
