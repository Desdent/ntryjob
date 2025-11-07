<?php $this->layout('layout', ['title' => 'Registro Empresa']) ?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <img src="/assets/imagenes/ntryjob-removebg-preview.png" alt="NTRYJOB Logo" class="auth-logo">
            <h1>Registro de Empresa</h1>
            <p>Completa los datos para registrar tu empresa</p>
        </div>

        <form action="/api/auth/registro-empresa.php" method="POST" enctype="multipart/form-data" class="auth-form">
            <!-- Datos de Acceso -->
            <div class="form-section">
                <h3>Datos de Acceso</h3>
                <div class="form-group">
                    <label for="email">Email corporativo *</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña *</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="password_confirm">Confirmar Contraseña *</label>
                    <input type="password" id="password_confirm" name="password_confirm" required>
                </div>
            </div>

            <!-- Es el register-empresa -->
            <!-- Datos de la Empresa -->
            <div class="form-section">
                <h3>Datos de la Empresa</h3>
                <div class="form-group">
                    <label for="nombre">Nombre de la Empresa *</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="cif">CIF *</label>
                    <input type="text" id="cif" name="cif" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" required>
                </div>
                <div class="form-group">
                    <label for="logo">Logo (Imagen)</label>
                    <input type="file" id="logo" name="logo" accept="image/*" required>
                </div>

            </div>

            <!-- Dirección -->
            <div class="form-section">
                <h3>Dirección</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="pais">País</label>
                        <input type="text" id="pais" name="pais" value="España" required>
                    </div>
                    <div class="form-group">
                        <label for="provincia">Provincia</label>
                        <input type="text" id="provincia" name="provincia" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" id="ciudad" name="ciudad" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" id="direccion" name="direccion" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">Registrar Empresa</button>
            
            <p class="auth-footer">
                ¿Ya tienes cuenta? <a href="/login">Inicia sesión</a>
            </p>
        </form>
    </div>
</div>
