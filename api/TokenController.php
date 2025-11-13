<?php 

require_once __DIR__ . "/../config/Token.php";
require_once __DIR__ . "/../dao/UserDAO.php";
require_once __DIR__ . "/../models/entities/UserEntity.php";
require_once __DIR__ . "/../dao/AlumnoDAO.php";
require_once __DIR__ . "/../dao/TokenDAO.php";

$dao = new UserDAO();
$daoToken = new TokenDAO();

$method = $_SERVER["REQUEST_METHOD"];

try{
    switch($method){
        case "POST":
            $data = json_decode(file_get_contents("php://input"), true);

            if(empty($data)){
                http_response_code(400);
                echo json_encode(["Error" => "No se han enviado datos"]);
            }

            if(!isset($data["email"]) || !isset($data["password"]))
            {
                http_response_code(400);
                echo json_encode(["Error" => "No se ha enviado email o contraseña"]);
            }

            $exists = $dao->emailExists($data["email"]);

            if($exists == 0)
            {
                http_response_code(400);
                echo json_encode(["Error" => "No existe ese email en la base de datos"]);
            }

            $resultadoREPO = $dao->findByEmail($data["email"]);
            
            $user = new UserEntity($resultadoREPO);

            if(!$dao->verifyPassword($data["password"], $user->password)){
                http_response_code(400);
                echo json_encode(["error" => "Contraseña Incorrecta"]);
            }

            
            $token = Token::generarToken($user);
            
            $tieneToken = $daoToken->tieneToken($user->id);
            if($tieneToken > 0)
            {
                $daoToken->updateToken($user->id, $token);
            }
            else
            {
                $daoToken->guardarToken($user->id, $token);
            }
            
            
            
            echo json_encode([
                "success" => true,
                "token" => $token
            ]);
            break;
    }
}catch(Exception $e){
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}