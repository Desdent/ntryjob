<?php
session_start();  
header('Content-Type: application/json');

require_once __DIR__ . '/../../dao/UserDAO.php';
require_once __DIR__ . '/../../dao/AlumnoDAO.php';
require_once __DIR__ . '/../../dao/EmpresaDAO.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
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
        
        if ($user->role === 'empresario' && ($user->aprobada ?? 0) == 0) {
            echo json_encode(['success' => false, 'error' => 'Empresa pendiente de aprobación']);
            exit;
        }
        
        $_SESSION['user_id'] = $user->id;
        $_SESSION['email'] = $user->email;
        $_SESSION['role'] = $user->role;
        $_SESSION['aprobada'] = $user->aprobada ?? 1;

        echo json_encode([
            'success' => true, 
            'user' => [
                'role' => $user->role,
                'aprobada' => $user->aprobada ?? 1
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