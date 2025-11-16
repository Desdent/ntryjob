<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../dao/PostulacionDAO.php';
require_once __DIR__ . '/../../dao/AlumnoDAO.php';
require_once __DIR__ . '/../../dao/CicloDAO.php';
require_once __DIR__ . '/../../dao/CicloAlumnosDAO.php';
require_once __DIR__ . '/../../models/entities/CiclosAlumnosEntity.php';
require_once __DIR__ . '/../../models/entities/PostulacionEntity.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

session_start();
AuthMiddleware::requiereAuth(['alumno']);

$alumnoDAO = new AlumnoDAO();
$cicloDAO = new CicloDAO();
$cicloAlumnoDAO = new CicloAlumnosDAO();
$metodo = $_SERVER['REQUEST_METHOD'];

try {

    $alumno = $alumnoDAO->findByUsuarioId($_SESSION['user_id']);

    switch ($metodo) {
        case 'GET':
            if (!$alumno) {
                http_response_code(404);
                echo json_encode(['success' => false, 'error' => 'Alumno no encontrado']);
                exit;
            }

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
            elseif(isset($_GET["getCiclosAlumno"]))
            {
                $idAlumno = $alumno->id;
                $ciclos = $alumnoDAO->getCiclosAlumno($idAlumno);

                if($ciclos)
                {
                    echo json_encode(["success" => true, "ciclos" => $ciclos]);
                }
                else
                {
                    http_response_code(400);
                    echo json_encode(["success" => false, "error" => "No tiene ciclos"]);
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
        case 'POST':
            $id_alumno = $alumno->id;
            var_dump($_POST);


            $cicloAlumnosArray = [
                "nombre_ciclo" => $_POST["nombreCiclo"],
                "alumno_id" => $id_alumno,
                "ciclo_id" => (int)($_POST["selectCiclos"]),
                "fecha_inicio" => $_POST["fechaInicio"],
                "fecha_fin" => $_POST["fechaFin"]
            ];

            $ciclosAlumnoEntity = new CiclosAlumnosEntity($cicloAlumnosArray);

            $nuevo = $cicloAlumnoDAO->create($ciclosAlumnoEntity);

            if($nuevo)
            {
                echo json_encode(["success" => true]);
                exit;
            }
            else
            {
                http_response_code(400);
                echo json_encode(["success" => false, "error" => "Error conectando con el cicloAlumnos"]);
                exit;
            }
            break;

        case 'DELETE':
            $id_ciclo = json_decode(file_get_contents("php://input"), true);

            $exito = $cicloAlumnoDAO->delete($id_ciclo);
            if($exito)
            {
                echo json_encode(["success" => true]);
            }
            else
            {
                $exito = $cicloDAO->delete($id_ciclo);
                if($exito){
                    echo json_encode(["success" => true]);
                    exit;
                }
                else
                {
                    echo json_encode(["success" => false, "error" => "No se encuentra el ciclo que borrar"]);
                    exit;
                }
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