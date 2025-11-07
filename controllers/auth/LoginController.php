<?php
require_once __DIR__ . '/../../dao/UserDAO.php';
require_once __DIR__ . '/../../dao/AlumnoDAO.php';
require_once __DIR__ . '/../../dao/EmpresaDAO.php';
require_once __DIR__ . '/../../config/Database.php';

class LoginController {
    private $userDAO;
    private $alumnoDAO;
    private $empresaDAO;
    
    public function __construct() {
        $this->userDAO = new UserDAO();
        $this->alumnoDAO = new AlumnoDAO();
        $this->empresaDAO = new EmpresaDAO();
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Método no permitido']);
            exit;
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $email = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            echo json_encode(['success' => false, 'error' => 'Email y contraseña requeridos']);
            exit;
        }
        
        try {
            $user = $this->userDAO->findByEmail($email);
            
            if (!$user || !$this->userDAO->verifyPassword($password, $user->password)) {
                echo json_encode(['success' => false, 'error' => 'Credenciales incorrectas']);
                exit;
            }
            
            $role = $this->detectRole($user->id);
            
            if (!$role) {
                echo json_encode(['success' => false, 'error' => 'Usuario sin rol']);
                exit;
            }
            
            $_SESSION['user_id'] = $user->id;
            $_SESSION['email'] = $user->email;
            $_SESSION['role'] = $role['type'];
            $_SESSION['id'] = $user->id;
            
            if (isset($role['alumno_id'])) {
                $_SESSION['alumno_id'] = $role['alumno_id'];
            }
            if (isset($role['empresa_id'])) {
                $_SESSION['empresa_id'] = $role['empresa_id'];
            }
            if (isset($role['aprobada'])) {
                $_SESSION['aprobada'] = $role['aprobada'];
            }
            
            echo json_encode([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'role' => $role['type'],
                    'aprobada' => $role['aprobada'] ?? null
                ]
            ]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    private function detectRole($userId) {
        $alumno = $this->alumnoDAO->findByUsuarioId($userId);
        if ($alumno) return ['type' => 'alumno', 'alumno_id' => $alumno->id];
        
        $empresa = $this->empresaDAO->findByUsuarioId($userId);
        if ($empresa) return [
            'type' => 'empresario', 
            'empresa_id' => $empresa->id,
            'aprobada' => $empresa->aprobada
        ];
        
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT id FROM admin WHERE usuario_id = :id");
        $stmt->execute(['id' => $userId]);
        if ($stmt->fetch()) return ['type' => 'admin'];
        
        return null;
    }
}
