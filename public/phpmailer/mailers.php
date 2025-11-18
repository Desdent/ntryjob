<?php

class mailers{

    public function rechazarSolicitud($nombre)
    {
        echo "<h2>Hola, <?php echo $nombre ?></h2>
            <hr>
            <p>Con respecto a tu solicitud, lamentamos decirte que ha sido rechazada</p>
            <br>
            <p>Ánimo machine</p>";
    }

    public function aceptarSolicitud($nombre)
    {
        echo "<h2>Hola, <?php echo $nombre ?></h2>
            <hr>
            <p>Con respecto a tu solicitud, nos alegra decirte que ha sido aceptada</p>
            <br>
            <p>Grande machine</p>";
    }

    public function completaRegistro($nombre)
    {
        echo "<h2>Hola, <?php echo $nombre ?></h2>
            <hr>
            <p>Has sido dado de alta por un administrador</p>
            <p>Te invitamos a completar tus datos iniciando sesion</p>
            <br>
            <p>Tu contraseña temporal es: admin123</p>
            <br>
            <p>Venga machine</p>";
    }

    public function rechazarEmpresa($nombre)
    {
        echo "<h2>Hola, <?php echo $nombre ?></h2>
            <hr>
            <p>Con respecto al alta de su cuenta empresarial</p>
            <p>Le informamos de que ha sido rechazada</p>
            <br>
            <p>Sorry machines</p>";
    }

    public function aceptarEmpresa($nombre)
    {
        echo "<h2>Hola, <?php echo $nombre ?></h2>
            <hr>
            <p>Con respecto al alta de su cuenta empresarial</p>
            <p>Le informamos de que ya ha sido aceptada</p>
            <br>
            <p>Un besi machines</p>";
    }

}

