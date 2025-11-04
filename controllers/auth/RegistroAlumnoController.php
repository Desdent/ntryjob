<?php
require_once __DIR__ . '/../../models/Alumno.php';
require_once __DIR__ . '/../../models/User.php';

class RegistroAlumnoController {
    
    /**
     * POST - Registrar alumno
     */
    public function register() {
        try {
            $data = $_POST;
            
            if (empty($data['nombre']) || empty($data['apellidos']) || empty($data['email']) || 
                empty($data['password']) || empty($data['ciclo_id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Campos requeridos faltantes']);
                return;
            }
            
            if (User::emailExists($data['email'])) {
                http_response_code(409);
                echo json_encode(['success' => false, 'error' => 'El email ya está registrado']);
                return;
            }
            
            // Procesar CV como BLOB
            if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
                $data['cv'] = $this->procesarCV($_FILES['cv']);
            }
            
            // Procesar foto desde Base64 como BLOB
            if (!empty($data['foto_base64'])) {
                $data['foto'] = $this->procesarFotoBase64($data['foto_base64']);
            }
            
            $id = Alumno::create($data);
            
            echo json_encode(['success' => true, 'id' => $id, 'message' => 'Alumno registrado correctamente']);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Procesar CV y devolver BLOB
     */
    private function procesarCV($archivo) {
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        $permitidas = ['pdf', 'docx'];
        
        if (!in_array($extension, $permitidas)) {
            throw new Exception('Solo se permiten archivos PDF o DOCX');
        }
        
        if ($archivo['size'] > 5 * 1024 * 1024) {
            throw new Exception('El CV no puede superar 5MB');
        }
        
        $blob = file_get_contents($archivo['tmp_name']);
        
        if ($blob === false) {
            throw new Exception('Error al leer el CV');
        }
        
        return $blob;
    }

    /**
     * Procesar foto desde Base64 y devolver BLOB
     */
    private function procesarFotoBase64($base64String) {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
            $base64String = substr($base64String, strpos($base64String, ',') + 1);
            $type = strtolower($type[1]);
            
            if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                throw new Exception('Formato de imagen no válido');
            }
            
            $blob = base64_decode($base64String);
            
            if ($blob === false) {
                throw new Exception('Error al decodificar la imagen');
            }
            
            return $blob;
        } else {
            throw new Exception('Formato Base64 inválido');
        }
    }
}