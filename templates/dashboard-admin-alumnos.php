<?php
$this->layout('layout', ['title' => 'Dashboard Admin']);
?>

<script src="/public/js/auth/alumnos.js"></script>


<div class="trasfondoModal">
    <div class="modalContainer">
        <div class="modalHeader">
            <h3>Aqui va a ir el titulo</h3>
        </div>
        <div class="modalBody">
        </div>
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
            <h2>Listado de Alumnos</h2>
            <table id="tablaAlumnos"></table>
            <p></p>
        </div>
        
    </div>
</div>

<script src="/public/js/auth/alumnos.js"></script>
   <script src="/public/js/admin/main.js"></script>


    

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