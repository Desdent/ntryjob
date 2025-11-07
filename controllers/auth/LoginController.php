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
            
            // Detectar rol usando la misma lógica que el login.php corregido
            $pdo = Database::getInstance()->getConnection();
            $rol = null;
            $aprobada = 1;

            // Verificar si es alumno
            $stmt = $pdo->prepare("SELECT id FROM alumnos WHERE usuario_id = ?");
            $stmt->execute([$user->id]);
            if ($stmt->fetch()) {
                $rol = 'alumno';
            } else {
                // Verificar si es empresa
                $stmt = $pdo->prepare("SELECT id, aprobada FROM empresas WHERE usuario_id = ?");
                $stmt->execute([$user->id]);
                if ($row = $stmt->fetch()) {
                    $rol = 'empresario';
                    $aprobada = $row['aprobada'];
                } else {
                    // Verificar si es admin
                    $stmt = $pdo->prepare("SELECT id FROM admin WHERE usuario_id = ?");
                    $stmt->execute([$user->id]);
                    if ($stmt->fetch()) {
                        $rol = 'admin';
                    }
                }
            }

            if (!$rol) {
                echo json_encode(['success' => false, 'error' => 'Usuario sin rol asignado']);
                exit;
            }
            
            $_SESSION['user_id'] = $user->id;
            $_SESSION['email'] = $user->email;
            $_SESSION['role'] = $rol;
            $_SESSION['aprobada'] = $aprobada;

            echo json_encode([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'role' => $rol,
                    'aprobada' => $aprobada
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
