<?php

session_start(); 

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../dao/UserDAO.php';

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

// Verificar token
$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? '';



if (empty($authHeader) || !preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
    echo json_encode(['success' => false, 'error' => 'Token no proporcionado']);
    exit;
}

$token = $matches[1];



// Leer datos JSON del body
$input = json_decode(file_get_contents('php://input'), true);

if (empty($input['email']) || empty($input['password'])) {
    echo json_encode(['success' => false, 'error' => 'Por favor completa todos los campos']);
    exit;
}

try {
    $email = $input['email'];
    $password = $input['password'];

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
        echo json_encode(['success' => false, 'error' => 'Tu empresa está pendiente de aprobación']);
        exit;
    }
    
    // Login exitoso - establecer sesión
    $_SESSION['user_id'] = $user->id;
    $_SESSION['email'] = $user->email;
    $_SESSION['role'] = $rol;
    $_SESSION['aprobada'] = $aprobada;
    $_SESSION['token'] = $token;

    // Determinar URL de redirección
    $redirectUrls = [
        'admin' => '/public/index.php?page=dashboard-admin',
        'empresario' => '/public/index.php?page=dashboard-empresario',
        'alumno' => '/public/index.php?page=dashboard-alumno'
    ];
    
    $redirectUrl = $redirectUrls[$rol] ?? null;
    
    echo json_encode([
        'success' => true,
        'redirect_url' => $redirectUrl,
        'role' => $rol
    ]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Error del servidor']);
    error_log("Login error: " . $e->getMessage());
}