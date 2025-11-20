<?php $this->layout('layout', ['title' => 'Registro Empresa']) ?>
<script src="/public/js/auth/registro-alumno.js" defer></script>


    <main>
        <div class="divMarco">
            <div class="divContentSeleccion">
                <h2 class="fontDivContent titulo-seleccion">¿Qué tipo de cuenta quieres crear?</h2>
                
                <div class="opciones-registro">
                    <div class="opcion-card">
                        <h3 class="fontDivContent">Soy Alumno</h3>
                        <p class="fontDivContent">Busco oportunidades laborales y prácticas</p>
                        <a href="#" id="btnAbrirModalAlumno" class="boton-seleccion">Registrarme como Alumno</a>
                    </div>

                    <div class="opcion-card">
                        <h3 class="fontDivContent">Soy Empresa</h3>
                        <p class="fontDivContent">Quiero publicar ofertas de empleo</p>
                        <a href="index.php?page=register-empresa" class="boton-seleccion">Registrarme como Empresa</a>
                    </div>
                </div>

                <span class="campos-registro centro">
                    <p class="fontDivContent">¿Ya tienes cuenta? <a href="index.php?page=login" id="link-login-sel">Inicia sesión aquí</a></p>
                </span>
            </div>
        </div>
    </main>

    <!-- Modal Registro Alumno -->
    <div id="modalRegistroAlumno" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Registro de Alumno</h2>
                <span class="modal-close">&times;</span>
            </div>
            
            <form id="formRegistroAlumno" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" id="nombre" name="nombre" required minlength="2" maxlength="50" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo letras y espacios">
                    <span class="error-message"></span>
                </div>

                <div class="form-group">
                    <label for="apellidos">Apellidos *</label>
                    <input type="text" id="apellidos" name="apellidos" required minlength="2" maxlength="100" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+">
                    <span class="error-message"></span>
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required maxlength="100">
                    <span class="error-message"></span>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña *</label>
                    <input type="password" id="password" name="password" required minlength="6" maxlength="255">
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
                    <label for="ultimoCiclo">Último ciclo cursado *</label>
                    <select id="ultimoCiclo" name="ultimoCiclo" required>
                        <option value="">Cargando ciclos...</option>
                    </select>
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
                </div>

                <div class="form-group campo-foto-container">
                    <label>Foto de perfil</label>
                    
                    <img id="fotoPreview" class="img-preview-simple" src="" alt="Previsualización">
                    
                    <input type="hidden" id="fotoAlumnoBase64" name="fotoAlumnoBase64">

                    <button type="button" id="btnAbrirCamaraAlumno" class="botonesAccion btn-camara-simple">
                        📷 Abrir Cámara
                    </button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancelar" id="btnCancelarModal">Cancelar</button>
                    <button type="submit" class="btn-registrar">Registrarse</button>
                </div>
                
            </form>
        </div>
    </div>
    <!-- Es el register.php -->

    <!-- Modal Cámara -->
    <div id="modalCamaraAlumno" class="modal">
        <div class="modal-content" style="max-width:420px">
            <div class="modal-header">
                <h2>Hazte una foto</h2>
                <span class="modal-camara-close" style="cursor:pointer">&times;</span>
            </div>
            <div class="modal-body" style="text-align:center;">
                <video id="camaraVideo" autoplay playsinline width="300" height="300" style="border-radius:8px;"></video>
                <canvas id="fotoCanvas" width="300" height="300" style="display:none; border-radius:8px;"></canvas>
                <div style="margin:10px 0; color:#2563eb; font-size:14px">
                    Pulsa <b>Ctrl</b> y mueve la rueda para ajustar el tamaño. 
                    Pulsa <b>Ctrl + click y arrastra</b> para mover la zona de recorte.
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnCapturarFoto">Capturar</button>
                <button id="btnGuardarFoto" style="display:none">Usar esta foto</button>
                <button id="btnCancelarFoto">Cancelar</button>
            </div>
        </div>
    </div>
    
    <footer>
        <p>&copy; 2025 NTRYJOB - Tu espacio de búsqueda tranquilo</p>
    </footer>


<script src="/public/js/validators.js"></script>
