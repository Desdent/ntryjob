<?php 

class Token {

    public static function generarToken($user)
    {
        $ms = round(microtime(true) * 1000); // Para obtener los ms

        $concated = $user->email . $user->password . $ms;

        $token = hash("sha256", $concated);

        return $token;
    }

}