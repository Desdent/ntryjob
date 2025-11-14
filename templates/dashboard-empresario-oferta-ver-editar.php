<?php
$this->layout('layout', ['title' => 'Dashboard Empresa']);
var_dump($_SESSION);
require_once $_SERVER["DOCUMENT_ROOT"] . "/controllers/empresario/OfertasController.php";

$controller = new OfertaController();
$userid = $_SESSION["user_id"];
$ofertas = $controller->getOfertasByEmpresa($userid);
$ciclos = $controller->getAllCiclos();
$errores = [];

$ofertaUnserialized;

if(isset($_POST["ofertaSerialized"])){
    $ofertaUnserialized = unserialize($_POST["ofertaSerialized"]);
    $oferta_id = $ofertaUnserialized->id;
    $empresa_id = $ofertaUnserialized->empresa_id;
}

if (isset($_SESSION["errores"])) {
    $errores = $_SESSION["errores"];
    
    unset($_SESSION["errores"]); 
}

if(isset($_SESSION["exito"]))
{ 

?>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Panel de Empresa</h1>
            <p>Bienvenido, <?= htmlspecialchars($_SESSION['email']) ?></p>
        </div>
        
        <div class="table-container">
            <?php
                if($_SESSION["exito"] == "editada")
                {?>
                    <h2 id="h2AddEmpresa">¡Oferta Editada!</h2>
                <?php
                }
                elseif($_SESSION["exito"] == "borrada")
                {?>
                    <h2 id="h2AddEmpresa">¡Oferta Borrada!</h2>
                <?php
                }
            ?>
        </div>

        
    </div>

<?php
    unset($_SESSION["exito"]);
}

else
{ ?>
    <?php
        if(isset($_SESSION["accion"]) && $_SESSION["accion"] == "editar")
        {
            unset($_SESSION["accion"]);
            $_SESSION["confirmarEdicion"] = "true";
            ?>
                <div class="dashboard-container">
                    <div class="dashboard-header">
                        <h1>Panel de Empresa</h1>
                        <p>Bienvenido, <?= htmlspecialchars($_SESSION['email']) ?></p>
                    </div>


                    <div class="table-container">
                        <h2>Editar Oferta</h2>
                            <div id="headerTableContainer">
                                <div id="containerPublicarOfertas">
                                    <div class="containerdatosOferta">
                                    <div>
                                        <form action="?page=confirmacion-ofertas" method ="POST" novalidate>

                                            <div class="datosOferta">
                                                <div>
                                                    <label for="titulo">Título: </label>
                                                    <input type="text" name="titulo" id="titulo" class="inputsPublicarOfertas"
                                                    value="<?php echo isset($ofertaUnserialized) ? $ofertaUnserialized->titulo : (isset($_SESSION["datosPrevios"]["titulo"]) ? htmlspecialchars($_SESSION["datosPrevios"]["titulo"]) : '' ); ?>" 
                                                    required>

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
                                                    value="<?php echo isset($ofertaUnserialized) ? $ofertaUnserialized->descripcion : (isset($_SESSION["datosPrevios"]["descripcion"]) ? htmlspecialchars($_SESSION["datosPrevios"]["descripcion"]) : '' ); ?>" 
                                                    required>

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
                                                    <input type="text" name="requisitos" id="requisitos" class="inputsPublicarOfertas"
                                                    value="<?php echo isset($ofertaUnserialized) ? $ofertaUnserialized->requisitos : (isset($_SESSION["datosPrevios"]["requisitos"]) ? htmlspecialchars($_SESSION["datosPrevios"]["requisitos"]) : '' ); ?>" 
                                                    required>

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


                                                    $cicloPrevioId = isset($ofertaUnserialized) ? $ofertaUnserialized->ciclo_id : (isset($_SESSION["datosPrevios"]["ciclo_id"]) ? htmlspecialchars($_SESSION["datosPrevios"]["ciclo_id"]) : null);
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
                                                    <input type="text" name="fecha_inicio" id="fecha_inicio" class="inputsPublicarOfertas"
                                                    value="<?php echo isset($ofertaUnserialized) ? $ofertaUnserialized->fecha_inicio : (isset($_SESSION["datosPrevios"]["fecha_inicio"]) ? htmlspecialchars($_SESSION["datosPrevios"]["fecha_inicio"]) : '' ); ?>" 
                                                    required>

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
                                                    <input type="text" name="fecha_cierre" id="fecha_cierre" class="inputsPublicarOfertas"
                                                    value="<?php echo isset($ofertaUnserialized) ? $ofertaUnserialized->fecha_cierre : (isset($_SESSION["datosPrevios"]["fecha_cierre"]) ? htmlspecialchars($_SESSION["datosPrevios"]["fecha_cierre"]) : '' ); ?>" 
                                                    required>

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
                                                    <?php
                                                    $modalidadPrevista = isset($ofertaUnserialized) ? $ofertaUnserialized->modalidad : (isset($_SESSION["datosPrevios"]["modalidad"]) ? $_SESSION["datosPrevios"]["modalidad"] : null);
                                                    ?>

                                                    <label for="modalidad">Modalidad:</label>
                                                    <select name="modalidad" id="modalidad" class="inputsPublicarOfertas" required>
                                                        
                                                        <option value="" disabled <?php echo is_null($modalidadPrevista) ? 'selected' : ''; ?>>Modalidad:</option>
                                                        
                                                        <?php $isSelectedPresencial = ($modalidadPrevista === 'presencial') ? 'selected' : ''; ?>
                                                        <option value="presencial" <?php echo $isSelectedPresencial; ?>>Presencial</option>
                                                        
                                                        <?php $isSelectedRemoto = ($modalidadPrevista === 'remoto') ? 'selected' : ''; ?>
                                                        <option value="remoto" <?php echo $isSelectedRemoto; ?>>Remoto</option>
                                                        
                                                        <?php $isSelectedHibrido = ($modalidadPrevista === 'hibrido') ? 'selected' : ''; ?>
                                                        <option value="hibrido" <?php echo $isSelectedHibrido; ?>>Híbrido</option>
                                                        
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
                                                    <input type="text" name="salario" id="salario" class="inputsPublicarOfertas"
                                                    value="<?php echo isset($ofertaUnserialized) ? $ofertaUnserialized->salario : (isset($_SESSION["datosPrevios"]["salario"]) ? htmlspecialchars($_SESSION["datosPrevios"]["salario"]) : '' ); ?>" 
                                                    required>
                                                        
                                                    <?php
                                                    if (isset($errores["salarioError"])) {
                                                        echo "<span> 
                                                                <p class='erroresAddOferta'>" . htmlspecialchars($errores["salarioError"]) . "</p>
                                                            </span>";
                                                    }

                                                    ?>

                                                    <input type="hidden" name="id" value="<?php echo $ofertaUnserialized->id?>">
                                                </div>
                                            </div>
                                        </div>

                                            <input type="submit" value="Actualizar Oferta" class="botonesEmpresa" name="btnActualizarOferta">
                                        </form>
                                    </div>
                                </div>
                                
                            </div>


                    </div>
                </div>
            <?php
        }
        elseif(isset($_SESSION["accion"]) && $_SESSION["accion"] == "ver")
        {
            ?>

            <?php
        }
        else
        {
            ?>

            <?php
        }

}

