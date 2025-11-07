<?php
$this->layout('layout', ['title' => 'Dashboard Alumno']);
?>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Mi Panel</h1>
        <p>Bienvenido, <?= htmlspecialchars($_SESSION['email']) ?></p>
    </div>
    
    <div class="dashboard-actions">
        <div class="action-card">
            <h3>Ofertas Disponibles</h3>
            <p>Explora las ofertas de empleo disponibles para tus ciclos formativos</p>
            <div id="ofertasContainer" class="ofertas-container">
                <!-- Las ofertas se cargarán aquí via JavaScript -->
            </div>
        </div>
        
        <div class="action-card">
            <h3>Mi CV</h3>
            <p>Gestiona tu curriculum vitae</p>
            <button onclick="gestionarCV()">Gestionar CV</button>
        </div>
        
        <div class="action-card">
            <h3>Mis Postulaciones</h3>
            <p>Revisa el estado de tus postulaciones</p>
            <button onclick="verPostulaciones()">Ver Postulaciones</button>
        </div>
    </div>
</div>

<script src="/public/js/alumno/ofertas.js"></script>
<script>
function gestionarCV() {
    window.location.href = '/public/index.php?page=cv-alumno';
}

function verPostulaciones() {
    window.location.href = '/public/index.php?page=postulaciones-alumno';
}
</script>