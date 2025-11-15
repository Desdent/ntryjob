<?php
$this->layout('layout', ['title' => 'Dashboard Alumno']);
?>

<script src="/public/js/alumno/ofertas.js"></script>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Panel de Alumno</h1>
        <p>Bienvenido, <?= htmlspecialchars($_SESSION['email']) ?></p>
    </div>
    
    <div class="divCentral">
        
        <div id="menu-izq"> 
            <h3>Panel de Navegación</h2>
            <div class="optLateral"></div>
            <div class="optLateral"></div>
            </div>
        
        <div class="table-container">
            <div id="divh2">
                <h2>Ofertas Disponibles</h2>
            </div>
            <div id="ofertas-container">

            </div>
        </div>
        <div class="table-container">
            <div id="divh2">
                <h2>Mis Postulaciones</h2>
            </div>
            <div id="postulaciones-container">

            </div>
        </div>
        
    </div>
</div>