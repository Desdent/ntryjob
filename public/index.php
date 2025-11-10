<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

use League\Plates\Engine;

$templates = new Engine(__DIR__ . '/../templates');

$page = $_GET['page'] ?? 'home';

// Router
switch($page) {
    case 'home':
        echo $templates->render('home');
        break;
    
    case 'login':
        if (isset($_SESSION['user_id'])) {
            $rol = $_SESSION['role'];
            switch($rol) {
                case "admin": 
                    header('Location: index.php?page=dashboard-admin'); 
                    exit;
                case "empresario": 
                    if ($_SESSION['aprobada'] == 1) {
                        header('Location: index.php?page=dashboard-empresario'); 
                    } else {
                        // Mostrar página de espera de aprobación
                        echo $templates->render('auth/espera-aprobacion');
                    }
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

    case 'dashboard-admin-empresas':
        AuthMiddleware::requiereAuth(["admin"]);
        echo $templates->render('dashboard-admin-empresas');
        break;

    case 'dashboard-admin-addEmpresa':
        AuthMiddleware::requiereAuth(["admin"]);
        echo $templates->render('dashboard-admin-addEmpresa');
        break;
    
    case 'confirmacion-addedEmpresa':
        AuthMiddleware::requiereAuth(["admin"]);
        echo $templates->render('confirmacion-addedEmpresa');
        break;

    case 'dashboard-admin-ofertas':
        AuthMiddleware::requiereAuth(["admin"]);
        echo $templates->render('dashboard-admin-ofertas');
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
