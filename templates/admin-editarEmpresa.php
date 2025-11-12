<?php
$this->layout('layout', ['title' => 'Dashboard Admin']);

$datosForm = [];

if(isset($_POST["datosSerialized"]))
{
    $datosForm = unserialize($_POST["datosSerialized"]);
    $datosSerialized = $_POST["datosSerialized"];
}

// Se desserializa el objeto enviado por post en hidden serializado



if($_SERVER["REQUEST_METHOD"] == "POST")
{

    if(isset($_POST["btnActualizarEmpresa"])) {
        $datosForm = $_POST;
    }
    // Si viene con datos serializados, usar esos
    elseif(isset($_POST["datosSerialized"])) {
        $datosForm = unserialize($_POST["datosSerialized"]);
    }
    // Si no hay datos, array vacío
    else {
        $datosForm = [];
    }

    
    ?>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Panel de Administración</h1>
            <p>Bienvenido, <?= htmlspecialchars($_SESSION['email']) ?></p>
        </div>
        
        <div class="divCentral">
            
            <div id="menu-izq"> 
                <h3>Panel de Navegación</h3>
                <div class="optLateral">
                    <a href="index.php?page=dashboard-admin-alumnos">Panel de Alumnos</a>
                </div>
                <div class="optLateral">
                    <a href="index.php?page=dashboard-admin-empresas">Panel de Empresas</a>
                </div>
            </div>
            
            <div class="table-container">
                <div class="headerTableContainer">
                    <div id="divh2">
                        <h2>Editar Empresa</h2>
                    </div>
                    <form action="" method="POST">
                        <div class="filasEditarEmpresa">
                            
                                <div>
                                    <input type="hidden" name="datosSerialized" value="<?php echo htmlspecialchars($datosSerialized)?>">


                                    <label for="nombre">Nombre:</label>
                                    <input type="text" name="nombre" class="inputsEditarEmpresa"
                                    value="<?php echo $datosForm["nombre"] ? htmlspecialchars($datosForm["nombre"]) : '' ?>"
                                        required>
                                </div>

                                <div>
                                    <label for="cif">CIF:</label>
                                    <input type="text" name="cif" class="inputsEditarEmpresa"
                                    value="<?php echo $datosForm["cif"] ? htmlspecialchars($datosForm["cif"]) : '' ?>">
                                </div>

                                <div>
                                    <label for="email">Email:</label>
                                    <input type="text" name="email" class="inputsEditarEmpresa"
                                    value="<?php echo $datosForm["email"] ? htmlspecialchars($datosForm["email"]) : '' ?>"
                                    required>
                                </div>
                                
                        
                        </div>
                            
                        <div class="filasEditarEmpresa">
                            <div>
                                <label for="telefono">Teléfono:</label>
                                    <input type="number" name="telefono" class="inputsEditarEmpresa"
                                    value="<?php echo $datosForm["telefono"] ? (int)htmlspecialchars($datosForm["telefono"]) : '' ?>"
                                    required>
                            </div>

                            <div>
                                <label for="sector">Sector:</label>
                                <input type="text" name="sector" class="inputsEditarEmpresa"
                                    value="<?php echo $datosForm["sector"] ? htmlspecialchars($datosForm["sector"]) : '' ?>"
                                    required>
                            </div>

                            <div>
                                <label for="pais">País:</label>
                                <input type="text" name="pais" class="inputsEditarEmpresa"
                                    value="<?php echo $datosForm["pais"] ? htmlspecialchars($datosForm["pais"]) : '' ?>"
                                    required>
                            </div>
                        </div>

                        <div class="filasEditarEmpresa">

                            <div>
                                <label for="provincia">Provincia:</label>
                                <input type="text" name="provincia" class="inputsEditarEmpresa"
                                    value="<?php echo $datosForm["provincia"] ? htmlspecialchars($datosForm["provincia"]) : '' ?>"
                                    required>
                            </div>

                                <div>
                                    <label for="ciudad">Ciudad</label>
                                    <input type="text" name="ciudad" class="inputsEditarEmpresa"
                                    value="<?php echo $datosForm["ciudad"] ? htmlspecialchars($datosForm["ciudad"]) : '' ?>"
                                    required>
                                </div>

                                <div>
                                    <label for="direccion">Dirección:</label>
                                    <input type="text" name="direccion" class="inputsEditarEmpresa"
                                    value="<?php echo $datosForm["direccion"] ? htmlspecialchars($datosForm["direccion"]) : '' ?>"
                                    required>
                                </div>
                        </div>

                        <div class="filasEditarEmpresa">
                                <div>
                                    <label for="descripcion">Descripcion</label>
                                    <textarea name="descripcion" id="textareaEditarEmpresa"><?php echo $datosForm["descripcion"] ? htmlspecialchars(trim($datosForm["descripcion"])) : '' ?></textarea>
                                </div>
                        </div>

                        <div id="divActualizarEmpresa">
                            <input type="submit" value="Actualizar Empresa" class="actualizarEmpresa" name="btnActualizarEmpresa">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
    </div>

    <?php
}

?>
