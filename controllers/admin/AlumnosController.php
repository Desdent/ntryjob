<?php
require_once __DIR__ . '/../../dao/AlumnoDAO.php';
require_once __DIR__ . '/../../models/entities/AlumnoEntity.php';
require_once __DIR__ . '/../../helpers/Validator.php';

class AlumnosController {
    private $dao;
    
    public function __construct() {
        $this->dao = new AlumnoDAO();
        
        //para detectar carga masiva
        if (isset($_GET['accion']) && $_GET['accion'] === 'massive') {
            $this->createMassive();
            exit; 
        }
    }
    
    public function index() {
        try {
            $alumnos = $this->dao->getAll();
            echo json_encode(['success' => true, 'data' => array_map(fn($a) => $a->toArray(), $alumnos)]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    public function create() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            // Validar datos
            if (!Validator::esTextoValido($data['nombre'] ?? '')) throw new Exception('Nombre inválido');
            if (!Validator::esEmail($data['email'] ?? '')) throw new Exception('Email inválido');
            
            if (empty($data['nombre']) || empty($data['email'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Campos requeridos faltantes']);
                return;
            }
            
            $alumno = new AlumnoEntity($data);
            $nuevo = $this->dao->create($alumno);
            echo json_encode(['success' => true, 'id' => $nuevo->id]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    public function update() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            if (empty($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'ID requerido']);
                return;
            }
            
            $alumno = new AlumnoEntity($data);
            $result = $this->dao->update($alumno);
            echo json_encode(['success' => true, 'updated' => $result]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    public function delete() {
        try {
            $data = json_decode(file_get_contents('php://input'), true); 
            $id = $_GET['id'] ?? $data['id'] ?? null;
            
            if (empty($id)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'ID requerido']);
                return;
            }
            
            $result = $this->dao->delete($id);
            echo json_encode(['success' => true, 'deleted' => $result]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function createMassive() {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input || !is_array($input)) {
                throw new Exception("Datos inválidos para carga masiva");
            }

            $creados = 0;
            $errores = [];

            foreach ($input as $index => $datosAlumno) {
                // Validar datos
                if (!Validator::esEmail($datosAlumno['email']) || 
                    !Validator::esTelefono($datosAlumno['telefono']) ||
                    !Validator::esTextoValido($datosAlumno['nombre'])) {
                    $errores[] = "Fila " . ($index + 1) . ": Datos inválidos";
                    continue;
                }

                // Asignar contraseña por defecto si no existe
                if (empty($datosAlumno['password'])) {
                    $datosAlumno['password'] = '123456';
                }
                
                $alumno = new AlumnoEntity($datosAlumno);
                $this->dao->create($alumno);
                $creados++;
            }

            echo json_encode(['success' => true, 'creados' => $creados, 'errores' => $errores]);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
?>