<?php
$this->layout('layout', ['title' => 'Dashboard Admin']);

// Se desserializa el objeto enviado por post en hidden serializado

if($_SERVER["REQUEST_METHOD"] == "POST")
{

    
    ?>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Panel de Administración</h1>
            <p>Bienvenido, <?= htmlspecialchars($_SESSION['email']) ?></p>
        </div>
        
        <div class="divCentral">
            
            <div id="menu-izq"> 
                <h3>Panel de Navegación</h3>
                <div class="optLateral">
                    <a href="index.php?page=dashboard-admin-alumnos">Panel de Alumnos</a>
                </div>
                <div class="optLateral">
                    <a href="index.php?page=dashboard-admin-empresas">Panel de Empresas</a>
                </div>
                <div class="optLateral">
                    <a href="index.php?page=dashboard-admin-ofertas">Panel de Ofertas</a>
                </div>
            </div>
            
            <div class="table-container">
                <div class="headerTableContainer">
                    <div id="divh2">
                        <h2>¡Empresa Actualizada!</h2>
                    </div>
                </div>
            </div>
        </div>

        
    </div>

        <?php

    header:("Refresh: 3; url=?page=dashboard-admin-empresas");
}

?>