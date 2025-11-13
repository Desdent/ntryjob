<?php

require_once __DIR__ . '/../../dao/UserDAO.php';

class LoginController {
    public function handleLogin() {

        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['iniciar-sesion'])) {
            try {
                // Validar campos requeridos
                if (empty($_POST['email']) || empty($_POST['password'])) {
                    $_SESSION['error_login'] = 'Por favor completa todos los campos';
                    return;
                }

                
                
                $email = $_POST['email'];
                $password = $_POST['password'];

                $userDAO = new UserDAO();
                $user = $userDAO->findByEmail($email);
                
                if (!$user) {
                    $_SESSION['error_login'] = 'Usuario no encontrado';
                    return;
                }
                
                if (!$userDAO->verifyPassword($password, $user->password)) {
                    $_SESSION['error_login'] = 'Contraseña incorrecta';
                    return;
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
                    $_SESSION['error_login'] = 'Usuario sin rol asignado';
                    return;
                }
                
                if ($rol === 'empresario' && $aprobada != 1) {
                    $_SESSION['error_login'] = 'Tu empresa está pendiente de aprobación';
                    return;
                }
                
                // Login exitoso - establecer sesión
                $_SESSION['user_id'] = $user->id;
                $_SESSION['email'] = $user->email;
                $_SESSION['role'] = $rol;
                $_SESSION['aprobada'] = $aprobada;

                // Redirigir según el rol
                $this->redirectByRole($rol, $aprobada);
                
            } catch (Exception $e) {
                $_SESSION['error_login'] = 'Error del servidor. Intenta de nuevo.';
                error_log("Login error: " . $e->getMessage());
            }
        }
    }
    
    private function redirectByRole($role, $aprobada) {
        switch ($role) {
            case 'admin':
                header('Location: /public/index.php?page=dashboard-admin');
                break;
            case 'empresario':
                if ($aprobada == 1) {
                    header('Location: /public/index.php?page=dashboard-empresario');
                } else {
                    // Esto no debería pasar debido a la validación anterior, pero por seguridad
                    $_SESSION['error_login'] = 'Tu empresa está pendiente de aprobación';
                    return;
                }
                break;
            case 'alumno':
                header('Location: /public/index.php?page=dashboard-alumno');
                break;
            default:
                $_SESSION['error_login'] = 'Rol no reconocido';
                return;
        }
        exit;
    }
    
    public function showLoginPage() {
        // Si el usuario ya está logueado, redirigir al dashboard correspondiente
        if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
            $this->redirectByRole($_SESSION['role'], $_SESSION['aprobada'] ?? 1);
        }
        
        // Mostrar la página de login
        require_once __DIR__ . '/../../templates/auth/login.php';
    }
}