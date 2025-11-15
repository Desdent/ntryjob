<?php
$this->layout('layout', ['title' => 'Dashboard Empresa']);

require_once $_SERVER["DOCUMENT_ROOT"] . "/controllers/empresario/OfertasController.php";

$controller = new OfertaController();
$userid = $_SESSION["user_id"];
$ofertas = $controller->getOfertasByEmpresa($userid);
$ciclos = $controller->getAllCiclos();
$errores = [];
if (isset($_SESSION["errores"])) {
    $errores = $_SESSION["errores"];
    
    unset($_SESSION["errores"]); 
}


if(isset($_SESSION["exito"]))
{
    unset($_SESSION["exito"]); 
?>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Panel de Empresa</h1>
            <p>Bienvenido, <?= htmlspecialchars($_SESSION['email']) ?></p>
        </div>
        
        <div class="table-container">
            <h2 id="h2AddEmpresa">¡Oferta Creada!</h2>
        </div>

        
    </div>

<?php
}

else
{ ?>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Panel de Empresa</h1>
            <p>Bienvenido, <?= htmlspecialchars($_SESSION['email']) ?></p>
        </div>


        <div class="table-container">
            <h2>Crear Oferta</h2>
                <div id="headerTableContainer">
                    <div id="containerPublicarOfertas">
                        <div class="containerdatosOferta">
                        <div>
                            <form action="?page=confirmacion-addedOferta" method ="POST" novalidate>

                                <div class="datosOferta">
                                    <div>
                                        <label for="titulo">Título: </label>
                                        <input type="text" name="titulo" id="titulo" class="inputsPublicarOfertas"
                                        value="<?php echo isset($_SESSION["datosPrevios"]["titulo"]) ? htmlspecialchars($_SESSION["datosPrevios"]["titulo"]) : '' ?>" required>

                                        <?php
                                        if (isset($errores["tituloError"])) {
                                            echo "<span> 
                                                    <p class='erroresAddOferta'>" . htmlspecialchars($errores["tituloError"]) . "</p>
                                                </span>";
                                        }
                                        ?>
                                    </div>

                                    <div>
                                        <label for="descripcion">Descripción:</label>
                                        <input type="text" name="descripcion" id="descripcion" class="inputsPublicarOfertas"
                                        value="<?php echo isset($_SESSION["datosPrevios"]["descripcion"]) ? htmlspecialchars($_SESSION["datosPrevios"]["descripcion"]) : '' ?>" required>

                                        <?php
                                        if (isset($errores["descripcionError"])) {
                                            echo "<span> 
                                                    <p class='erroresAddOferta'>" . htmlspecialchars($errores["descripcionError"]) . "</p>
                                                </span>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="datosOferta">
                                    <div>
                                        <label for="requisitos">Requisitos:</label>
                                        <input type="requisitos" name="requisitos" id="requisitos" class="inputsPublicarOfertas"
                                        value="<?php echo isset($_SESSION["datosPrevios"]["requisitos"]) ? htmlspecialchars($_SESSION["datosPrevios"]["requisitos"]) : '' ?>" required>

                                        <?php
                                        if (isset($errores["requisitosError"])) {
                                            echo "<span> 
                                                    <p class='erroresAddOferta'>" . htmlspecialchars($errores["requisitosError"]) . "</p>
                                                </span>";
                                        }
                                        ?>
                                    </div>

                                    <div>
                                        <label for="ciclo">Ciclo:</label>
                                        <?php

                                        $cicloPrevioId = isset($_SESSION["datosPrevios"]["ciclo"]) ? $_SESSION["datosPrevios"]["ciclo"] : null;
                                        ?>
                                        <select name="ciclo" id="ciclo" class="inputsPublicarOfertas" required>
                                            
                                            <option value="" disabled <?php echo is_null($cicloPrevioId) ? 'selected' : ''; ?>>
                                                -- Selecciona un Ciclo --
                                            </option>
                                            
                                            <?php
                                                foreach($ciclos as $ciclo)
                                                {
                                                    $isSelected = ($ciclo->id == $cicloPrevioId) ? 'selected' : '';
                                                ?>
                                                    <option value="<?php echo $ciclo->id?>" <?php echo $isSelected; ?>>
                                                        <?php echo htmlspecialchars($ciclo->nombre); ?>
                                                    </option>
                                                <?php
                                                }
                                            ?>
                                        </select>

                                        <?php
                                        if (isset($errores["cicloError"])) {
                                            echo "<span> 
                                                    <p class='erroresAddOferta'>" . htmlspecialchars($errores["cicloError"]) . "</p>
                                                </span>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="datosOferta">
                                    <div>
                                        <label for="fechaInicio">Fecha de Inicio:</label>
                                        <input type="date" name="fechaInicio" id="fechaInicio" class="inputsPublicarOfertas"
                                        value="<?php echo isset($_SESSION["datosPrevios"]["fechaInicio"]) ? htmlspecialchars($_SESSION["datosPrevios"]["fechaInicio"]) : '' ?>" required>

                                        <?php
                                        if (isset($errores["fechaInicioError"])) {
                                            echo "<span> 
                                                    <p class='erroresAddOferta'>" . htmlspecialchars($errores["fechaInicioError"]) . "</p>
                                                </span>";
                                        }
                                        ?>
                                    </div>

                                    <div>
                                        <label for="fechaFin">Fecha de Cierre:</label>
                                        <input type="date" name="fechaFin" id="fechaFin" class="inputsPublicarOfertas"
                                        value="<?php echo isset($_SESSION["datosPrevios"]["fechaFin"]) ? htmlspecialchars($_SESSION["datosPrevios"]["fechaFin"]) : '' ?>" required>

                                        <?php
                                        if (isset($errores["fechaFinError"])) {
                                            echo "<span> 
                                                    <p class='erroresAddOferta'>" . htmlspecialchars($errores["fechaFinError"]) . "</p>
                                                </span>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="datosOferta">
                                    <div>
                                            <label for="modalidad">Modalidad:</label>
                                            <select name="modalidad" id="modalidad" class="inputsPublicarOfertas"
                                            value="<?php echo isset($_SESSION["datosPrevios"]["modalidad"]) ? htmlspecialchars($_SESSION["datosPrevios"]["modalidad"]) : '' ?>" required>
                                                <option value="" disabled selected>Modalidad:</option>
                                                <option value="presencial">Presencial</option>
                                                <option value="remoto">Remoto</option>
                                                <option value="hibrido">Híbrido</option>
                                            </select>

                                            <?php
                                        if (isset($errores["modalidadError"])) {
                                            echo "<span> 
                                                    <p class='erroresAddOferta'>" . htmlspecialchars($errores["modalidadError"]) . "</p>
                                                </span>";
                                        }
                                        ?>
                                    </div>

                                    <div>
                                        <label for="salario">Salario</label>
                                            <input type="number" name="salario" id="salario" class="inputsPublicarOfertas"
                                            value="<?php echo isset($_SESSION["datosPrevios"]["salario"]) ? htmlspecialchars($_SESSION["datosPrevios"]["salario"]) : '' ?>" required>
                                            
                                        <?php
                                        if (isset($errores["salarioError"])) {
                                            echo "<span> 
                                                    <p class='erroresAddOferta'>" . htmlspecialchars($errores["salarioError"]) . "</p>
                                                </span>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>


                                <input type="submit" value="Publicar Oferta" class="botonesEmpresa" name="btnPublicarOferta">
                            </form>

                            <form action="?page=dashboard-empresario" method="POST">
                                                <input type="submit" value="Volver" class="botonesEmpresa" name="btnVolver">
                            </form>
                        </div>
                    </div>
                    
                </div>


        </div>
    </div>
<?php }



