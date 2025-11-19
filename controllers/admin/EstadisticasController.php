<?php
require_once __DIR__ . '/../../config/Database.php';

class EstadisticasController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getStats() {
        try {
            $stats = [
                'usuarios' => $this->getDistribucionUsuarios(),
                'ofertas' => $this->getEstadoOfertas(),
                'ciclos' => $this->getTopCiclos()
            ];
            
            echo json_encode(['success' => true, 'data' => $stats]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    private function getDistribucionUsuarios() {
        // Contar Alumnos
        $stmtA = $this->db->query("SELECT COUNT(*) as total FROM alumnos");
        $alumnos = $stmtA->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Contar Empresas
        $stmtE = $this->db->query("SELECT COUNT(*) as total FROM empresas");
        $empresas = $stmtE->fetch(PDO::FETCH_ASSOC)['total'];
        
        return ['alumnos' => $alumnos, 'empresas' => $empresas];
    }
    
    private function getEstadoOfertas() {
        

        // Si fecha_cierre es mayor o igual a hoy -> Activa, sino -> Finalizada
        $sql = "SELECT 
                    CASE 
                        WHEN fecha_cierre >= CURDATE() THEN 'Activa' 
                        ELSE 'Finalizada' 
                    END as estado, 
                    COUNT(*) as total 
                FROM ofertas 
                GROUP BY estado";
                
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function getTopCiclos() {
        // Top 5 ciclos con más alumnos registrados
        $sql = "SELECT c.nombre, COUNT(a.id) as total 
                FROM ciclos c 
                LEFT JOIN alumnos a ON c.id = a.ciclo_id 
                GROUP BY c.id, c.nombre 
                ORDER BY total DESC 
                LIMIT 5";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>