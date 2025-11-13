<?php 

require_once __DIR__ . "/../config/Database.php";

class TokenDAO {

    private $db;
    public function __construct() { $this->db = Database::getInstance()->getConnection(); }

    public function guardarToken($usuario_id, $token)
    {

        $sql = "INSERT INTO tokens(usuario_id, token)
                VALUES (?, ?)";

        try{
            $stmt = $this->db->prepare($sql);

            $resultado = $stmt->execute([$usuario_id, $token]);

            return $resultado;
        }
        catch(PDOException $e){
            return false;
        }
    }


    public function tieneToken($usuario_id)
    {
        $sql = "SELECT id FROM tokens 
            WHERE usuario_id = ?
            LIMIT 1";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$usuario_id]);
            
            $encontrado = $stmt->rowCount() > 0;
            
            return $encontrado; 

        } catch (PDOException $e) {

            return false;
        }
    
    }

    
    public function updateToken($usuario_id, $token)
    {
        $sql = "UPDATE tokens
                SET token = ?
                WHERE usuario_id = ?";

        try{
            $stmt = $this->db->prepare($sql);

            $resultado = $stmt->execute([$token, $usuario_id]);

            return $resultado;
        }
        catch(PDOException $e){
            return false;
        }
    
    }
    
}