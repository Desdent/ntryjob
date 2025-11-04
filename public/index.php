<?php

session_start();

file_put_contents('/tmp/debug_session.txt', print_r($_SESSION, true) . "\n", FILE_APPEND);


require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

use League\Plates\Engine;

$templates = new Engine(__DIR__ . '/../templates');

// Obtener página 
$page = $_GET['page'] ?? 'home';

// Si es POST 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Conectar BD

    $pdo = Database::getInstance()->getConnection();
    
    // Crear repositorio
    $repoUser = new User($pdo);
    
}

// Router
switch($page) {
    case 'home':
        echo $templates->render('home');
        break;
    
    case 'login':
        // Si ya está logeado, redirigir al dashboard
        if (isset($_SESSION['user_id'])) {
            $rol = $_SESSION['role'];
            switch($rol) {
                case "admin": 
                    header('Location: index.php?page=dashboard-admin'); 
                    exit;
                case "empresario": 
                    header('Location: index.php?page=dashboard-empresario'); 
                    exit;
                case "alumno": 
                    header('Location: index.php?page=dashboard-alumno'); 
                    exit;
            }
        }
        echo $templates->render('auth/login');
        break;
    
    case 'register':
        echo $templates->render('auth/register');
        break;
    
    case 'register-alumno':
        echo $templates->render('auth/register-alumno');
        break;
    
    case 'register-empresa': 
        echo $templates->render('auth/register-empresa');
        break;
    
    case 'dashboard-admin':
        AuthMiddleware::requiereAuth(["admin"]);
        echo $templates->render('dashboard-admin');
        break;

    case 'dashboard-admin-alumnos':
        AuthMiddleware::requiereAuth(["admin"]);
        echo $templates->render('dashboard-admin-alumnos');
        break;
    
    case 'dashboard-empresario':
        AuthMiddleware::requiereAuth(["empresario"]);
        echo $templates->render('dashboard-empresario');
        break;
        
    case 'dashboard-alumno':
        AuthMiddleware::requiereAuth(["alumno"]);
        echo $templates->render('dashboard-alumno');
        break;
    
    default:
        echo $templates->render('home');
        break;
}
?>
