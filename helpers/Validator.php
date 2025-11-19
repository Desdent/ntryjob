<?php
class Validator {
    
    public static function limpiar($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    public static function esEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function esTelefono($telefono) {
        return preg_match('/^[0-9]{9}$/', $telefono);
    }

    public static function esCodigoPostal($cp) {
        return preg_match('/^[0-9]{5}$/', $cp);
    }

    public static function esPasswordSegura($pass) {
        // Mínimo 6 caracteres
        return strlen($pass) >= 6;
    }

    public static function esTextoValido($texto, $min = 2, $max = 100) {
        $len = strlen($texto);
        // Permite letras, espacios y acentos
        return $len >= $min && $len <= $max && preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u', $texto);
    }

    public static function esCIF($cif) {
        $cif = strtoupper($cif);
        if (!preg_match('/^[ABCDEFGHJKLMNPQRSUVW][0-9]{7}[0-9A-J]$/', $cif)) {
            return false;
        }
        
        $letras = "JABCDEFGHI";
        $digitos = substr($cif, 1, 7);
        $letra_control = substr($cif, -1);
        $suma_par = 0;
        $suma_impar = 0;
        
        for ($i = 0; $i < strlen($digitos); $i++) {
            if ($i % 2 == 0) { // Posiciones impares (en string index 0, 2...)
                $aux = (int)$digitos[$i] * 2;
                $suma_impar += ($aux > 9 ? floor($aux / 10) + $aux % 10 : $aux);
            } else {
                $suma_par += (int)$digitos[$i];
            }
        }
        
        $suma_total = $suma_par + $suma_impar;
        $resto = $suma_total % 10;
        $digito_control = $resto ? 10 - $resto : 0;
        
        // Comprobar si es número o letra
        return ($digito_control == $letra_control) || (substr($letras, $digito_control, 1) == $letra_control);
    }

    public static function esDireccion($texto) {
        // Permite letras, números y simbolos básicos de dirección
        return preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s,.\-\/ºª]+$/u', $texto) && strlen($texto) >= 5;
    }

    public static function esAlfanumerico($texto) {
        return preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s]+$/u', $texto);
    }

    public static function esFechaValida($fecha) {
        if (!$fecha) return false;
        $d = DateTime::createFromFormat('Y-m-d', $fecha);
        return $d && $d->format('Y-m-d') === $fecha;
    }

    public static function validarRangoFechas($inicio, $fin) {
        if (empty($fin)) return true; // Si no hay fin, es válido
        return $inicio <= $fin;
    }

    public static function validarArchivo($archivo, $tiposPermitidos, $maxMB) {
        if (!isset($archivo['error']) || $archivo['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        // Validar tamaño
        if ($archivo['size'] > $maxMB * 1024 * 1024) {
            return false;
        }

        // Validar extensión
        $ext = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $tiposPermitidos)) {
            return false;
        }

        return true;
    }
}
?>