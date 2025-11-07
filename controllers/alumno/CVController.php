<?php
require_once __DIR__ . '/../../dao/AlumnoDAO.php';

class CVController {
    private $dao;
    
    public function __construct() {
        $this->dao = new AlumnoDAO();
    }
    
    public function upload() {
        try {
            session_start();
            $alumnoId = $_SESSION['alumno_id'] ?? null;
            
            if (!$alumnoId) {
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'No autorizado']);
                return;
            }
            
            if (!isset($_FILES['cv'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'No se subió ningún archivo']);
                return;
            }
            
            $archivo = $_FILES['cv'];
            
            $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
            if ($extension !== 'pdf') {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Solo se permiten archivos PDF']);
                return;
            }
            
            if ($archivo['size'] > 5 * 1024 * 1024) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'El archivo no puede superar 5MB']);
                return;
            }
            
            $cvBlob = file_get_contents($archivo['tmp_name']);
            $this->dao->updateCV($alumnoId, $cvBlob);
            
            echo json_encode(['success' => true, 'message' => 'CV subido correctamente']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    public function show() {
        try {
            session_start();
            $alumnoId = $_SESSION['alumno_id'] ?? null;
            
            if (!$alumnoId) {
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'No autorizado']);
                return;
            }
            
            $cv = $this->dao->getCV($alumnoId);
            
            echo json_encode([
                'success' => true,
                'has_cv' => $cv !== null,
                'download_url' => '/api/alumno/cv-download.php'
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    public function delete() {
        try {
            session_start();
            $alumnoId = $_SESSION['alumno_id'] ?? null;
            
            if (!$alumnoId) {
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'No autorizado']);
                return;
            }
            
            $this->dao->updateCV($alumnoId, null);
            echo json_encode(['success' => true, 'message' => 'CV eliminado']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
