<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$this->e($title)?> - NTRYJOB</title>
    <link rel="icon" href="/public/assets/imagenes/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/public/css/styles.css">
    <script src="/public/js/layout.js"></script>
</head>
<body>
    <!-- HEADER -->
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <div class="navbar-logo">
                    <a href="index.php">
                        <h1>NTRYJOB</h1>
                    </a>
                </div>
                <ul class="navbar-menu">
                    <li><a href="index.php?page=home">Inicio</a></li>
                    <li><a href="index.php?page=empleos">Buscar Empleo</a></li>
                    <li><a href="index.php?page=empresas">Buscar Empresas</a></li>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <li><a href="index.php?page=login">Acceso Empresas</a></li>
                    <?php endif; ?>
                </ul>
                <div class="navbar-actions">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="index.php?page=dashboard-<?php 
                            echo $_SESSION['role'];
                        ?>" class="user-email">
                            <?= htmlspecialchars($_SESSION['email']) ?>
                        </a>
                        <a href="#" id="btnLogout" class="btn-logout-header">Cerrar Sesión</a>
                    <?php else: ?>
                        <a href="index.php?page=login" class="btn-primary">Acceso Usuarios</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>

    <!-- CONTENIDO -->
    <main>
        <?=$this->section('content')?>
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <p>© 2025 ntryjob. Tu espacio de búsqueda tranquila.</p>
        <p>Aviso Legal | Política de Privacidad</p>
        <div class="footer-social">
            <a href="#">IG</a>
            <a href="#">LI</a>
            <a href="#">TW</a>
        </div>
    </footer>
</body>
</html>
