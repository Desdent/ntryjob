<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/styles.css">
    <script src="/public/js/auth/login.js"></script>
</head>
<body>
    <header>
        <nav>
            <h1>NTRYJOB</h1>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="index.php?page=login">Login</a></li>
                <li><a href="index.php?page=register">Registro</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="divMarco">
            <div class="divContent">
                <div id="divIniciar-sesion">
                    <h3 class="fontDivContent">
                    Accede con tu usuario
                    </h3>

                    <?php
                        if (isset($_SESSION['error_login'])): ?>
                        <p class="msgError">
                            <?= $_SESSION['error_login'] ?>
                        </p>
                        <?php unset($_SESSION['error_login']); // Elimina el error después de mostrarlo ?>
                    <?php endif; ?>


                    <div id="mensaje-error" class="msgError" style="display:none;"></div>
                    <form action="" method="post" id="form-login">
                        <span class="campos-login">
                            <label for="email" class="fontDivContent">Email: </label><br>
                            <input type="text" name="email" id="email"><br>
                        </span>

                        <span class="campos-login">
                            <label for="password" class="fontDivContent">Contraseña: </label><br>
                            <input type="password" name="password" id="password"><br>

                        </span>
                        
                        <span class="campos-login">
                            <button type="submit" name="iniciar-sesion" id="botonIniciarSesion">Iniciar Sesión</button>
                            <a href="#" id="forgotten-pass">He olvidado mi contraseña</a>
                        </span>
                        
                        <span class="campos-login" id="spanRecuerdame">
                            <input type="checkbox" name="recuerdame" id="recuerdame"><br>
                            <label for="recuerdame" class="fontDivContent">Recuérdame</label>
                        </span>
                    </form>
                </div>

                <div id="divRegistrarse">
                    <span class="campos-registrarse">
                        <h3 class="fontDivContent">
                            ¿No tienes usuario?
                        </h3>
                    </span>
                    <span class="campos-registrarse">

                        <p class="fontDivContent">
                            ¡Regístrate y accede a miles de ofertas disponibles!
                        </p>
                    </span>

                   <span class="campos-registrarse">
                        <a href="/public/index.php?page=register" id="botonRegistrarse" class="button">
                            Registrarse
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </main>
    
    <footer>
        <p>&copy; 2025 NTRYJOB - Tu espacio de búsqueda tranquilo</p>
    </footer>

</body>
</html>