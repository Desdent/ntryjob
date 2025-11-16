<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../dao/PostulacionDAO.php';
require_once __DIR__ . '/../../dao/AlumnoDAO.php';
require_once __DIR__ . '/../../models/entities/PostulacionEntity.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

session_start();
AuthMiddleware::requiereAuth(['alumno']);

$alumnoDAO = new AlumnoDAO();
$metodo = $_SERVER['REQUEST_METHOD'];

try {
    $alumno = $alumnoDAO->findByUsuarioId($_SESSION['user_id']);
    
    if (!$alumno) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Alumno no encontrado']);
        exit;
    }
    
    switch ($metodo) {
        case 'GET':
            if(isset($_GET["obtainImgBLOB"]))
            {
                if($alumno->foto)
                {
                    header("Content-Type: image/jpeg");

                    echo $alumno->foto;
                    exit;
                }
                else
                {
                    http_response_code(404);
                    exit;
                }
            }
            elseif(isset($_GET["obtainCVBLOB"]))
            {
                if($alumno->cv)
                {
                    header("Content-Type: application/PDF");

                    echo $alumno->cv;
                    exit;
                }
                else
                {
                    http_response_code(400);
                    exit;
                }
            }
            else
            {
                echo json_encode(["success" => true, "datos" => [
                "nombre" => $alumno->nombre,
                "apellidos" => $alumno->apellidos,
                "telefono" => $alumno->telefono,
                "fecha_nacimiento" => $alumno->fecha_nacimiento,
                "pais" => $alumno->pais,
                "provincia" => $alumno->provincia,
                "ciudad" => $alumno->ciudad,
                "direccion" => $alumno->direccion,
                "codigo_postal" => $alumno->codigo_postal,
                "ciclo_id" => $alumno->ciclo_id,
                "fecha_inicio" => $alumno->fecha_inicio,
                "fecha_fin" => $alumno->fecha_fin,
                "tieneCV" => ($alumno->cv) ? true : false,
                "tieneFoto" => ($alumno->foto) ? true : false
                    ]
                ]);
            }
            break;
            
        default:
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}