<?php
require_once __DIR__ . '/../../dao/EmpresaDAO.php';
require_once __DIR__ . '/../../dao/UserDAO.php';
require_once __DIR__ . '/../../models/entities/EmpresaEntity.php';

class RegistroEmpresaController {
    private $empresaDAO;
    private $userDAO;
    
    public function __construct() {
        $this->empresaDAO = new EmpresaDAO();
        $this->userDAO = new UserDAO();
    }
    
    public function register() {
        try {
            $data = $_POST;
            
            if (empty($data['nombre']) || empty($data['email']) || empty($data['password'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Campos requeridos faltantes']);
                return;
            }
            
            if ($data['password'] !== $data['password_confirm']) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Las contraseñas no coinciden']);
                return;
            }
            
            if ($this->userDAO->emailExists($data['email'])) {
                http_response_code(409);
                echo json_encode(['success' => false, 'error' => 'El email ya está registrado']);
                return;
            }
            
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                $data['logo'] = $this->procesarLogo($_FILES['logo']);
            }
            
            $empresa = new EmpresaEntity($data);
            $nueva = $this->empresaDAO->create($empresa);
            
            echo json_encode([
                'success' => true, 
                'id' => $nueva->id, 
                'message' => 'Empresa registrada correctamente. Pendiente de aprobación por administrador.'
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    private function procesarLogo($archivo) {
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (!in_array($extension, $permitidas)) {
            throw new Exception('Solo se permiten imágenes JPG, PNG o GIF');
        }
        
        if ($archivo['size'] > 2 * 1024 * 1024) {
            throw new Exception('El logo no puede superar 2MB');
        }
        
        $blob = file_get_contents($archivo['tmp_name']);
        
        if ($blob === false) {
            throw new Exception('Error al leer el logo');
        }
        
        return $blob;
    }
}
