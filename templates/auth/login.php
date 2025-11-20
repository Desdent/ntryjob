<?php $this->layout('layout', ['title' => 'Registro Empresa']) ?>
<script src="/public/js/auth/login.js"></script>


    <main>
        <div class="divMarco">
            <div class="divContent">
                <div id="divIniciar-sesion">
                    <h3 class="fontDivContent">
                    Accede con tu usuario
                    </h3>

                    <?php
                    // Mostrar errores de PHP
                    if (isset($_SESSION['error_login'])): ?>
                        <p class="msgError">
                            <?= $_SESSION['error_login'] ?>
                        </p>
                        <?php unset($_SESSION['error_login']); ?>
                    <?php endif; ?>

                    <form action="/public/index.php?page=login" method="post" id="form-login">
                        <span class="campos-login">
                            <label for="email" class="fontDivContent">Email: </label><br>
                            <input type="text" name="email" id="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"><br>
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
