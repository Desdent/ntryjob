<?php
$this->layout('layout', ['title' => 'Dashboard Admin']);
?>

<script src="/public/js/admin/alumnos.js"></script>


<div class="trasfondoModal">
    <div class="modalContainer">
        <div class="modal-header">
                <h2>Editar Alumno</h2>
                <span class="modal-close">&times;</span>
            </div>

        <div class="modalBody">
            <form id="formRegistroAlumno" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- Columna Izquierda -->
                    <div class="form-column">
                        <div class="form-group">
                            <label for="nombre">Nombre *</label>
                            <input type="text" id="nombre" name="nombre" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="pais">País *</label>
                            <input type="text" id="pais" name="pais" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="telefono">Teléfono *</label>
                            <input type="tel" id="telefono" name="telefono" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="codigoPostal">Código Postal *</label>
                            <input type="text" id="codigoPostal" name="codigoPostal" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="ultimoCiclo">Último ciclo cursado *</label>
                            <select id="ultimoCiclo" name="ultimoCiclo" required>
                            
                            </select>
                            <span class="error-message"></span>
                        </div> 


                    </div>

                    <!-- Columna Derecha -->
                    <div class="form-column">
                        <div class="form-group">
                            <label for="apellidos">Apellidos *</label>
                            <input type="text" id="apellidos" name="apellidos" required>
                            <span class="error-message"></span>
                        </div>


                        <div class="form-group">
                            <label for="fechaNacimiento">Fecha de nacimiento *</label>
                            <input type="date" id="fechaNacimiento" name="fechaNacimiento" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="provincia">Provincia *</label>
                            <input type="text" id="provincia" name="provincia" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="localidad">Localidad *</label>
                            <input type="text" id="localidad" name="localidad" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="direccion">Dirección *</label>
                            <input type="text" id="direccion" name="direccion" required>
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
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancelar" id="btnCancelarModal">Cancelar</button>
                    <button type="submit" class="btn-actualizar">Actualizar</button>
                </div>
            </form>
        </div>
    </div>





    <div class="modalContainerAdd">
        <div class="modal-headerAdd">
                <h2>Crear Alumno (temporal)</h2>
                <span class="modal-closeAdd">&times;</span>
            </div>

        <div class="modalBodyAdd">
            <form id="formAddAlumno" enctype="multipart/form-data">
                <div class="modal-bodyAdd">
                    <!-- Columna Izquierda -->
                    <div class="form-columnAdd">
                        <div class="form-groupAdd">
                            <label for="nombreAdd">Nombre *</label>
                            <input type="text" id="nombreAdd" name="nombreAdd" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-groupAdd">
                            <label for="emailAdd">Email *</label>
                            <input type="email" id="emailAdd" name="emailAdd" required>
                            <span class="error-message"></span>
                        </div>


                    </div>

                    <!-- Columna Derecha -->
                    <div class="form-columnAdd">
                        <div class="form-groupAdd">
                            <label for="apellidosAdd">Apellidos *</label>
                            <input type="text" id="apellidosAdd" name="apellidosAdd" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-groupAdd">
                            <label for="telefonoAdd">Teléfono *</label>
                            <input type="tel" id="telefonoAdd" name="telefonoAdd" required>
                            <span class="error-message"></span>
                        </div>
                    </div>

                </div>

                <div class="modal-footerAdd">
                    <button type="button" class="btn-cancelar" id="btnCancelarModalAdd">Cancelar</button>
                    <button type="submit" class="btn-actualizar" id="btnAdd">Añadir</button>
                </div>
            </form>
        </div>
    </div>
    
    

    <div class="modalContainerMassive">

    </div>

    


    
</div>


<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Panel de Administración</h1>
        <p>Bienvenido, <?= htmlspecialchars($_SESSION['email']) ?></p>
    </div>
    
    <div class="divCentral">
        
        <div id="menu-izq"> 
            <h3>Panel de Navegación</h2>
            <div class="optLateral"></div>
            <div class="optLateral"></div>
            </div>
        
        <div class="table-container">
            <div id="headerTableContainer">
                <div id="divh2">
                    <h2>Listado de Alumnos</h2>
                </div>
                <div id="containerAddSearch">
                    <div id="input-search">
                        <input type="text" id="search-admin" name="search-admin" placeholder="Buscar alumno, email...">
                    </div>

                    <div>
                        <button class="botonesAñadirCargar" id="createUser">Añadir Alumno</button>
                        <button class="botonesAñadirCargar" id="massiveAdd">Carga Masiva</button>
                    </div>
                </div>
            </div>
            <table id="tablaAlumnos"></table>
            <p></p>
        </div>
        
    </div>
</div>
