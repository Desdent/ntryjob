<div class="form-group">
    <label for="nombre">Nombre *</label>
    <input type="text" id="nombre" name="nombre" required minlength="2" maxlength="50" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo letras y espacios">
    <span class="error-message"></span>
</div>

<div class="form-group">
    <label for="email">Email *</label>
    <input type="email" id="email" name="email" required maxlength="100">
    <span class="error-message"></span>
</div>

<div class="form-group">
    <label for="pais">País *</label>
    <input type="text" id="pais" name="pais" required minlength="2" maxlength="50" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+">
    <span class="error-message"></span>
</div>

<div class="form-group">
    <label for="telefono">Teléfono *</label>
    <input type="tel" id="telefono" name="telefono" required pattern="[0-9]{9}" title="Debe contener 9 dígitos numéricos">
    <span class="error-message"></span>
</div>

<div class="form-group">
    <label for="codigoPostal">Código Postal *</label>
    <input type="text" id="codigoPostal" name="codigoPostal" required pattern="[0-9]{5}" title="Debe contener 5 dígitos">
    <span class="error-message"></span>
</div>

<div class="form-group">
    <label for="subirCV">Subir CV (PDF/DOCX, Máx 5MB) *</label>
    <input type="file" id="subirCV" name="subirCV" accept=".pdf,.docx,.doc" required>
    <span class="error-message"></span>
</div>
<div class="form-group">
    <label for="apellidos">Apellidos *</label>
    <input type="text" id="apellidos" name="apellidos" required minlength="2" maxlength="100" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+">
    <span class="error-message"></span>
</div>

<div class="form-group">
    <label for="password">Contraseña *</label>
    <input type="password" id="password" name="password" required minlength="6" maxlength="255">
    <span class="error-message"></span>
</div>

<div class="form-group">
    <label for="fechaNacimiento">Fecha de nacimiento *</label>
    <input type="date" id="fechaNacimiento" name="fechaNacimiento" required>
    <span class="error-message"></span>
</div>

<div class="form-group">
    <label for="provincia">Provincia *</label>
    <input type="text" id="provincia" name="provincia" required minlength="2" maxlength="50" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+">
    <span class="error-message"></span>
</div>

<div class="form-group">
    <label for="localidad">Localidad *</label>
    <input type="text" id="localidad" name="localidad" required minlength="2" maxlength="50">
    <span class="error-message"></span>
</div>

<div class="form-group">
    <label for="direccion">Dirección *</label>
    <input type="text" id="direccion" name="direccion" required minlength="5" maxlength="200">
    <span class="error-message"></span>
</div>

<div class="form-group">
    <label for="fechaInicio">Fecha de inicio *</label>
    <input type="date" id="fechaInicio" name="fechaInicio" required>
    <span class="error-message"></span>
</div>

<div class="form-group">
    <label for="fechaFinalizacion">Fecha de finalización</label>
    <input type="date" id="fechaFinalizacion" name="fechaFinalizacion">
    <span class="error-message"></span>
</div>

<script src="/public/js/validators.js"></script>