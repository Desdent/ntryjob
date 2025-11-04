<?php

class LogoutController {
    
    /**
     * POST - Logout
     */
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        
        echo json_encode(['success' => true, 'message' => 'Sesión cerrada correctamente']);
    }
}
