<?php
$this->layout('layout', ['title' => 'Dashboard Admin']);
?>

<script src="/public/js/admin/main.js"></script>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Panel de Administración</h1>
        <p>Bienvenido, <?= htmlspecialchars($_SESSION['email']) ?></p>
    </div>
    
    <div class="divCentral">
        
        <div id="menu-izq"> 
            <h3>Panel de Navegación</h3>
            <div class="optLateral"></div>
            <div class="optLateral"></div>
            </div>
        
        <div class="table-container">
            <h2>Vista Principal</h2>
        </div>
        
    </div>
</div>
