<?php
$this->layout('layout', ['title' => 'Dashboard Empresa']);
?>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Panel de Empresa</h1>
        <p>Bienvenido, <?= htmlspecialchars($_SESSION['email']) ?></p>
    </div>


    <div class="table-container">
        <h2>Mis Ofertas Publicadas</h2>
        <p>Administra tus ofertas de empleo</p>
    </div>
</div>