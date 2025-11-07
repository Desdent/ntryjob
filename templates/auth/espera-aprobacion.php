<?php $this->layout('layout', ['title' => 'Esperando Aprobación']) ?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <img src="/assets/imagenes/ntryjob-removebg-preview.png" alt="NTRYJOB Logo" class="auth-logo">
            <h1>Esperando Aprobación</h1>
        </div>
        
        <div class="auth-message">
            <p>Tu empresa está pendiente de aprobación por parte del administrador.</p>
            <p>Recibirás un email cuando tu cuenta sea activada.</p>
            <p>Por favor, intenta iniciar sesión más tarde.</p>
            
            <div class="auth-actions">
                <a href="/public/index.php?page=login" class="btn-primary">Volver al Login</a>
                <a href="/public/index.php?page=home" class="btn-secondary">Ir al Inicio</a>
            </div>
        </div>
    </div>
</div>