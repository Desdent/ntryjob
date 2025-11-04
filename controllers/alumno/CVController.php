<?php
require_once __DIR__ . '/../../models/Alumno.php';

class CVController {
    
    /**
     * POST - Subir CV
     */
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
            
            // Validar extensión PDF
            $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
            if ($extension !== 'pdf') {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Solo se permiten archivos PDF']);
                return;
            }
            
            // Validar tamaño (5MB máximo)
            if ($archivo['size'] > 5 * 1024 * 1024) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'El archivo no puede superar 5MB']);
                return;
            }
            
            // Leer archivo como blob
            $cvBlob = file_get_contents($archivo['tmp_name']);
            
            // Actualizar BD 
            Alumno::updateCV($alumnoId, $cvBlob);
            
            echo json_encode(['success' => true, 'message' => 'CV subido correctamente']);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    /**
     * GET - Ver mi CV
     */
    public function show() {
        try {
            session_start();
            $alumnoId = $_SESSION['alumno_id'] ?? null;
            
            if (!$alumnoId) {
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'No autorizado']);
                return;
            }
            
            $cv = Alumno::getCV($alumnoId);
            
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
    
    /**
     * DELETE - Eliminar mi CV
     */
    public function delete() {
        try {
            session_start();
            $alumnoId = $_SESSION['alumno_id'] ?? null;
            
            if (!$alumnoId) {
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'No autorizado']);
                return;
            }
            
            Alumno::updateCV($alumnoId, null);
            
            echo json_encode(['success' => true, 'message' => 'CV eliminado']);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}