<?php
$this->layout('layout', ['title' => 'Dashboard Alumno']);

require_once __DIR__ . "/../api/alumno/ofertasController.php";

$ofertasController = new ofertasController();

$ofertas = $ofertasController->getOfertas(0);
$contador = 0;
$ultimaOferta = end($ofertas);

$ofertasPostuladas = $ofertasController->getOfertas(1);
$ultimaOfertaPostulada = end($ofertasPostuladas);
?>
<script src="/public/js/alumno/ofertas.js"></script>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Panel de Alumno</h1>
        <p>Bienvenido, <?= htmlspecialchars($_SESSION['email']) ?></p>
    </div>
    
    <div class="divCentral">
        
        <div id="menu-izq"> 
            <h3>Panel de Navegación</h2>
            <div class="optLateral"></div>
            <div class="optLateral"></div>
            </div>
        
        <div class="table-container">
            <div id="divh2">
                <h2>Ofertas Disponibles</h2>

            </div>
            <div id="ofertas-container">
                <?php

                    foreach($ofertas as $oferta)
                    {
                        
                        if($contador == 0)
                        {
                            ?>
                                <div class="containerOfertas">
                            <?php
                        }
                            ?>
                                <div class="oferta-card">
                                    <div class="containerNombreEmpresaOferta">
                                        <h4 class="nombreEmpresaOferta">
                                            <?php
                                                echo $ofertasController->findEmpresaById($oferta->empresa_id)->nombre;
                                            ?>
                                        </h4>
                                    </div>
                                    <h3><?php echo $oferta->titulo ?></h3>
                                    <span class="oferta-badge"><?php echo $oferta->salario ?> $ </span>
                                    <span class="oferta-badge"><?php echo $oferta->modalidad ?></span>
                                    <p id="descripcion"><?php echo $oferta->descripcion ?></p>
                                    <button id="add[<?php $oferta->id?>]" class="btnAplicar" value="<?php echo $oferta->id?>">Aplicar</button>
                                </div>
                            <?php

                        $contador++;

                        if($contador == 2 || $oferta == $ultimaOferta){
                            ?>
                                </div>
                            <?php
                            $contador = 0;
                        }
                    }
                ?>
            </div>
        </div>
        <div class="table-container">
            <div id="divh2">
                <h2>Mis Postulaciones</h2>
            </div>
            <div id="postulaciones-container">
                    <?php

                    foreach($ofertasPostuladas as $oferta)
                    {
                        
                        if($contador == 0)
                        {
                            ?>
                                <div class="containerOfertas">
                            <?php
                        }
                            ?>
                                <div class="oferta-card">
                                    <div class="containerNombreEmpresaOferta">
                                        <h4 class="nombreEmpresaOferta">
                                            <?php
                                                echo $ofertasController->findEmpresaById($oferta->empresa_id)->nombre;
                                            ?>
                                        </h4>
                                    </div>
                                    <h3><?php echo $oferta->titulo ?></h3>
                                    <span class="oferta-badge"><?php echo $oferta->salario ?> $ </span>
                                    <span class="oferta-badge"><?php echo $oferta->modalidad ?></span>
                                    <p id="descripcion"><?php echo $oferta->descripcion ?></p>
                                    <button id="add[<?php $oferta->id?>]" class="btnAnular" value="<?php echo $oferta->id?>">Anular</button>
                                </div>
                            <?php

                        $contador++;

                        if($contador == 2 || $oferta == $ultimaOfertaPostulada){
                            ?>
                                </div>
                            <?php
                            $contador = 0;
                        }
                    }
                ?>
            </div>
        </div>
        
    </div>
</div>