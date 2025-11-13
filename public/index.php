<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../dao/EmpresaDAO.php';
require_once __DIR__ . '/../api/admin/EmpresasController.php';
require_once __DIR__ . '/../models/entities/AlumnoEntity.php';
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
        if(isset($_POST["btnBorrarEmpresa"]) || isset($_POST["btnAprobarEmpresa"]) || isset($_POST["btnRechazarEmpresa"]) )
        {
            if(isset($_POST["btnBorrarEmpresa"]))
            {
                $datosSerialize = unserialize($_POST["datosSerialized"]);
                new EmpresasController;
                EmpresasController::borrarEmpresa($datosSerialize);
            }
            elseif(isset($_POST["btnAprobarEmpresa"]))
            {
                $datosSerialize = unserialize($_POST["datosPendienteSerialized"]);
                new EmpresasController;
                EmpresasController::aprobarEmpresa($datosSerialize);
            }
            elseif(isset($_POST["btnRechazarEmpresa"]))
            {
                $datosSerialize = unserialize($_POST["datosPendienteSerialized"]);
                new EmpresasController;
                EmpresasController::rechazarEmpresa($datosSerialize);
            }
            AuthMiddleware::requiereAuth(["admin"]);
            echo $templates->render('admin-empresaConfirmarAcciones');
            break;
        }
        else
        {
            AuthMiddleware::requiereAuth(["admin"]);
            echo $templates->render('dashboard-admin-empresas');
            break;
        }
        

    case 'dashboard-admin-addEmpresa':
        AuthMiddleware::requiereAuth(["admin"]);
        echo $templates->render('dashboard-admin-addEmpresa');
        break;

    case 'admin-editarEmpresa':
        if(isset($_POST["btnActualizarEmpresa"]))
        {
                $datosSerialize = unserialize($_POST["datosSerialized"]);
                new EmpresasController;
                EmpresasController::actualizarEmpresa($datosSerialize);

            if(isset($_POST["btnBorrarEmpresa"]))
            {
                $datosSerialize = unserialize($_POST["datosSerialized"]);
                new EmpresasController;
                EmpresasController::borrarEmpresa($datosSerialize);
            }
            elseif(isset($_POST["btnAprobarEmpresa"]))
            {
                $datosSerialize = unserialize($_POST["datosPendienteSerialized"]);
                new EmpresasController;
                EmpresasController::aprobarEmpresa($datosSerialize);
            }
            elseif(isset($_POST["btnRechazarEmpresa"]))
            {
                $datosSerialize = unserialize($_POST["datosPendienteSerialized"]);
                new EmpresasController;
                EmpresasController::rechazarEmpresa($datosSerialize);
            }
            AuthMiddleware::requiereAuth(["admin"]);
            echo $templates->render('admin-empresaConfirmarAcciones');
            break;

            
        }
        else
        {
            AuthMiddleware::requiereAuth(["admin"]);
            echo $templates->render('admin-editarEmpresa');
            break;
        }
    
    case 'confirmacion-addedEmpresa':
        AuthMiddleware::requiereAuth(["admin"]);
        echo $templates->render('confirmacion-addedEmpresa');
        break;

    case 'admin-empresaActualizada';
        AuthMiddleware::requiereAuth(["admin"]);
        echo $templates->render('admin-empresaActualizada');
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
