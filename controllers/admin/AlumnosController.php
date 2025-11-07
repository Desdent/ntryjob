<?php
require_once __DIR__ . '/../../dao/AlumnoDAO.php';
require_once __DIR__ . '/../../models/entities/AlumnoEntity.php';

class AlumnosController {
    private $dao;
    
    public function __construct() {
        $this->dao = new AlumnoDAO();
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
            
            if (empty($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'ID requerido']);
                return;
            }
            
            $result = $this->dao->delete($data['id']);
            echo json_encode(['success' => true, 'deleted' => $result]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}

