<?php

class AuthMiddleware {
    
    /**
     * Requerir autenticación y roles específicos
     * @param array $rolesPermitidos Roles permitidos ['admin', 'empresario', 'alumno']
     */
    public static function requiereAuth($rolesPermitidos = []) {
        // Verificar si hay sesión iniciada
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
            http_response_code(401);
            echo json_encode(['error' => 'No autenticado']);
            exit;
        }
        
        $rolUsuario = $_SESSION['role'];
        
        // Verificar si el rol está permitido
        if (!empty($rolesPermitidos) && !in_array($rolUsuario, $rolesPermitidos)) {
            http_response_code(403);
            echo json_encode(['error' => 'No autorizado para este recurso']);
            exit;
        }
        
        // Si es empresario, verificar que esté aprobado
        if ($rolUsuario === 'empresario' && isset($_SESSION['aprobada']) && $_SESSION['aprobada'] != 1) {
            http_response_code(403);
            echo json_encode(['error' => 'Empresa pendiente de aprobación']);
            exit;
        }
        
        return true;
    }
    
    /**
     * Obtener usuario actual de la sesión
     */
    public static function obtenerUsuarioActual() {
        return [
            'id' => $_SESSION['user_id'] ?? null,
            'email' => $_SESSION['email'] ?? null,
            'role' => $_SESSION['role'] ?? null,
            'aprobada' => $_SESSION['aprobada'] ?? 1
        ];
    }
}
