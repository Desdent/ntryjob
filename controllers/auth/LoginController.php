<?php

class LoginController {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
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
            $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user || !password_verify($password, $user['password'])) {
                echo json_encode(['success' => false, 'error' => 'Credenciales incorrectas']);
                exit;
            }
            
            $role = $this->detectRole($user['id']);
            
            if (!$role) {
                echo json_encode(['success' => false, 'error' => 'Usuario sin rol']);
                exit;
            }
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $role['type'];

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
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'role' => $role['type'],
                    'aprobada' => $role['aprobada'] ?? null
                ]
            ]);
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    private function detectRole($userId) {
       // Es alumno?
        $stmt = $this->pdo->prepare("SELECT id FROM alumnos WHERE usuario_id = :id");
        $stmt->execute(['id' => $userId]);
        $alumno = $stmt->fetch();
        if ($alumno) return ['type' => 'alumno', 'alumno_id' => $alumno['id']];
        
        // Es empresa?
        $stmt = $this->pdo->prepare("SELECT id, aprobada FROM empresas WHERE usuario_id = :id");
        $stmt->execute(['id' => $userId]);
        $empresa = $stmt->fetch();
        if ($empresa) return [
            'type' => 'empresario', 
            'empresa_id' => $empresa['id'],
            'aprobada' => $empresa['aprobada']
        ];
        
        // Es admin?
        $stmt = $this->pdo->prepare("SELECT id FROM admin WHERE usuario_id = :id");
        $stmt->execute(['id' => $userId]);
        if ($stmt->fetch()) return ['type' => 'admin'];
        
        return null;
    }
}
