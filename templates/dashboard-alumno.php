<?php
$this->layout('layout', ['title' => 'Dashboard Alumno']);
?>
<?php echo '<pre>'; ?>
<?php print_r($_SESSION); ?>
<?php echo '</pre>'; ?>
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Mi Panel</h1>
        <p>Bienvenido, <?= htmlspecialchars($_SESSION['email']) ?></p>
    </div>
    
    <div class="table-container">
        <h2>Ofertas Disponibles</h2>
        <p>Aquí verás las ofertas de empleo disponibles</p>
    </div>

    <script src="/public/js/alumno/ofertas.js"></script>
</div>