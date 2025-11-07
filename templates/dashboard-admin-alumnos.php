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
                                <option value="">Cargando ciclos...</option>
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


<!-- Es el dashboard-admin-alumnos.php -->




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
            <div class="optLateral"></div>
            </div>
        
        <div class="table-container">
            <div id="headerTableContainer">
                <h2>Listado de Alumnos</h2>
                <div>
                    <button class="botonesAñadirCargar" id="createUser">Añadir Alumno</button>
                    <button class="botonesAñadirCargar" id="massiveAdd">Carga Masiva</button>
                </div>
            </div>
            <table id="tablaAlumnos"></table>
            <p></p>
        </div>
        
    </div>
</div>


    

    <!--
        <div class="stats">
        <div>
            <h3>Total Empresas</h3>
            <p id="total-empresas">0</p>
            <br>

            <h4>Empresas pendientes de aprobación</h4>
            <table id ="tablaEmpresas">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Telefono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaEmpresas-body">
                    <tr>

                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <br>
            <h3>Total Ofertas</h3>
            <p id="total-ofertas">0</p>
            <br>

            <h4>Tabla de ofertas</h4>
            <table id="tablaOfertas">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Titulo</th>
                        <th>Fecha de creacion</th>
                        <th>Fecha de fin</th>
                    </tr>
                </thead>
                <tbody id="tablaOfertas-body">
                    <tr>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>



    Modal edicion oferta
    <div id="modalEditarOferta">
        <div id="modalContent">
            <div class="modal-header">
                <h2>Edición de oferta</h2>
                <span class="modal-close">&times;</span>
            </div>

            <form id="formEditarOferta">
                <label for="tituloModal">Título: </label>
                <input type="text" id="tituloModal" name="titulo">

                <label for="descrpcionModal">Descripción: </label>
                <input type="text" id="descModal" name="descModal">

                <label for="requisitosModal">Requisitos: </label>
                <input type="text" id="requisitosModal" name="requisitosModal">

                <label for="cicloIDModal">Ciclo: </label>
                <input type="number" id="cicloIDModal" name="cicloIDModal">

                <label for="fechaIniModal">Fecha de Inicio: </label>
                <input type="date" name="fechaIniModal" id="fechaIniModal">

                <label for="fechaFinModal">Fecha de Cierre: </label>
                <input type="date" name="fechaFinModal" id="fechaFinModal">

                <label for="modalidadModal">Modalidad:</label>
                <select name="modalidadModal" id="modalidadModal">
                    <option value="presencial">Presencial</option>
                    <option value="remoto">Remoto</option>
                </select>

                <label for="salarioModal">Salario: </label>
                <input type="number" name="salarioModal" id="salarioModal">
            </form>
        </div>

        <div class="modal-footer">
                    <button type="button" class="btn-cancelar" id="btnCancelarModal">Cancelar</button>
                    <button type="submit" class="btn-confirmar" id="botonConfirmarModal">Confirmar</button>
        </div>
    </div> -->