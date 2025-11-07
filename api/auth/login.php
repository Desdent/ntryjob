<?php
session_start();  
header('Content-Type: application/json');

require_once __DIR__ . '/../../dao/UserDAO.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Validar campos requeridos
        if (empty($data['email']) || empty($data['password'])) {
            echo json_encode(['success' => false, 'error' => 'Email y contraseña requeridos']);
            exit;
        }
        
        $email = $data['email'];
        $password = $data['password'];

        $userDAO = new UserDAO();
        $user = $userDAO->findByEmail($email);
        
        if (!$user) {
            echo json_encode(['success' => false, 'error' => 'Usuario no encontrado']);
            exit;
        }
        
        if (!$userDAO->verifyPassword($password, $user->password)) {
            echo json_encode(['success' => false, 'error' => 'Contraseña incorrecta']);
            exit;
        }
        
        // Verificar rol y estado
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
        
        if ($rol === 'empresario' && $aprobada != 1) {
            echo json_encode(['success' => false, 'error' => 'Empresa pendiente de aprobación']);
            exit;
        }
        
        $_SESSION['user_id'] = $user->id;
        $_SESSION['email'] = $user->email;
        $_SESSION['role'] = $rol;
        $_SESSION['aprobada'] = $aprobada;

        echo json_encode([
            'success' => true, 
            'user' => [
                'role' => $rol,
                'aprobada' => $aprobada
            ]
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
?>