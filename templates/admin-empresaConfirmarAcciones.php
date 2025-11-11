<?php
$this->layout('layout', ['title' => 'Dashboard Admin']);

// Se desserializa el objeto enviado por post en hidden serializado

if($_SERVER["REQUEST_METHOD"] == "POST")
{

    
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
                <div class="optLateral">
                    <a href="index.php?page=dashboard-admin-ofertas">Panel de Ofertas</a>
                </div>
            </div>
            
            <div class="table-container">
                <div class="headerTableContainer">
                    <div id="divh2">
                        <?php if(isset($_POST["btnActualizarEmpresa"])) : ?>
                        <h2>¡Empresa Actualizada!</h2>
                        <?php elseif(isset($_POST["btnBorrarrEmpresa"])) : ?>
                        <h2>¡Empresa Borrada!</h2>
                        <?php elseif(isset($_POST["btnAprobarEmpresa"])) : ?>
                        <h2>¡Empresa Aprobada!</h2>
                        <?php elseif(isset($_POST["btnRechazarEmpresa"])) : ?>
                        <h2>¡Empresa Rechazada!</h2>
                        <?php
                        endif
                        ?>
                    </div>
                    <div>
                        <h3>
                            Redirigiendo al panel de empresas...
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        
    </div>


        <!-- <meta http-equiv="refresh" content="3;url=?page=dashboard-admin-empresas"> -->
        <?php
}

?>