<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../dao/AlumnoDAO.php';
require_once __DIR__ . '/../../models/entities/AlumnoEntity.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

session_start();
AuthMiddleware::requiereAuth(['admin']);

$dao = new AlumnoDAO();
$method = $_SERVER['REQUEST_METHOD'];

try {
    switch ($method) {
        case 'GET':
            if (isset($_GET['id'])) {
                $alumno = $dao->getById($_GET['id']);
                echo json_encode($alumno ? $alumno->toArray() : null);
            } else {
                $alumnos = $dao->getAll();
                echo json_encode([
                    'success' => true, 
                    'data' => array_map(fn($a) => $a->toArray(), $alumnos)
                ]);
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data) {
                $data = $_POST;
            }
            
            // Verificar si es carga masiva
            if (isset($_GET["accion"]) && $_GET["accion"] === "massive") {
                
                // Validar que $data sea un array
                if (!is_array($data)) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'error' => 'Formato de datos inválido']);
                    break;
                }
                
                $resultados = [];
                $errores = [];
                
                foreach ($data as $index => $alumnoData) {
                    try {
                        // Validar datos mínimos
                        if (empty($alumnoData['nombre']) || empty($alumnoData['email'])) {
                            $errores[] = "Fila " . ($index + 1) . ": Nombre y email requeridos";
                            continue;
                        }
                        
                        $alumno = new AlumnoEntity($alumnoData);
                        $nuevo = $dao->create($alumno);
                        $resultados[] = [
                            'id' => $nuevo->id,
                            'nombre' => $nuevo->nombre,
                            'email' => $nuevo->email
                        ];
                    } catch (Exception $e) {
                        $errores[] = "Fila " . ($index + 1) . ": " . $e->getMessage();
                    }
                }
                
                if (count($errores) > 0 && count($resultados) === 0) {
                    // Si todos fallaron
                    http_response_code(400);
                    echo json_encode([
                        'success' => false, 
                        'error' => 'No se pudo crear ningún alumno',
                        'detalles' => $errores
                    ]);
                } else {
                    // Si al menos uno tuvo éxito
                    echo json_encode([
                        'success' => true,
                        'creados' => count($resultados),
                        'errores' => count($errores),
                        'resultados' => $resultados,
                        'detalles_errores' => $errores
                    ]);
                }
                break;
            }
            
            // Creación individual de alumno
            if (empty($data['nombre']) || empty($data['email'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Nombre y email requeridos']);
                break;
            }
            
            $alumno = new AlumnoEntity($data);
            $nuevo = $dao->create($alumno);
            echo json_encode([
                'success' => true, 
                'id' => $nuevo->id, 
                'alumno' => $nuevo->toArray()
            ]);
            break;

        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'ID requerido']);
                break;
            }
            
            $alumno = new AlumnoEntity($data);
            $dao->update($alumno);
            echo json_encode(['success' => true]);
            break;

        case 'DELETE':
            $id = $_GET['id'] ?? null;
            
            if (!$id) {
                $data = json_decode(file_get_contents('php://input'), true);
                $id = $data['id'] ?? null;
            }
            
            if ($id) {
                $dao->delete($id);
                echo json_encode(['success' => true]);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'ID requerido']);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}