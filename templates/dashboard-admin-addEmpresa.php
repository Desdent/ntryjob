<?php
$this->layout('layout', ['title' => 'Dashboard Admin']);

require_once $_SERVER["DOCUMENT_ROOT"] . '/dao/EmpresaDAO.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/models/entities/EmpresaEntity.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/middleware/AuthMiddleware.php';

AuthMiddleware::requiereAuth(['admin']);

$errores = [];
if (isset($_SESSION["errores"])) {
    $errores = $_SESSION["errores"];
    
    unset($_SESSION["errores"]); 
}

if(isset($_SESSION["exito"]))
{
?>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Panel de Administración</h1>
            <p>Bienvenido, <?= htmlspecialchars($_SESSION['email']) ?></p>
        </div>

        <div class="divCentral">
            <div id="menu-izq"> 
                <h3>Panel de Navegación</h2>
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
                    <h2 id="h2AddEmpresa">Empresa Añadida</h2>
            </div>
        </div>

        
    </div>

<?php
}
?>



<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Panel de Administración</h1>
        <p>Bienvenido, <?= htmlspecialchars($_SESSION['email']) ?></p>
    </div>

    <div class="divCentral">
        <div id="menu-izq"> 
            <h3>Panel de Navegación</h2>
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
    
    
        <div class="addEmpresa-container">
            <h2 id="h2AddEmpresa">Añadir Empresa</h2>
                <div class="filasAddAlumno">
                    <form action="index.php?page=confirmacion-addedEmpresa" method="POST" novalidate>
                        <div>
                            <label for="nombre">Nombre:</label>
                            <input type="text" name="nombre" class="inputsAddEmpresa" required>
                            <?php
                                if (isset($errores["nombreError"])) {
                                    echo "<span> 
                                            <p class='pErrorAddEmpresa'>" . htmlspecialchars($errores["nombreError"]) . "</p>
                                        </span>";
                                }
                            ?>
                        </div>

                        <div>
                            <label for="email">Email:</label>
                            <input type="text" name="email" class="inputsAddEmpresa" required>
                            <?php
                                if (isset($errores["emailError"])) {
                                    echo "<span> 
                                            <p class='pErrorAddEmpresa'>" . htmlspecialchars($errores["emailError"]) . "</p>
                                        </span>";
                                }
                            ?>
                        </div>

                        <div>
                            <label for="telefono">Telefono:</label>
                            <input type="text" name="telefono" class="inputsAddEmpresa" required>
                            <?php
                                if (isset($errores["telefonoError"])) {
                                    echo "<span class='spanErrorsAddEmpresa'> 
                                            <p class='pErrorAddEmpresa'>" . htmlspecialchars($errores["telefonoError"]) . "</p>
                                        </span>";
                                }
                            ?>
                        </div>

                        
                        </div>
                        <div id="divAddEmpresa">
                            <input type="submit" value="Añadir Empresa" class="addEmpresa">
                        </div>
                    </form>
        </div>
    </div>

    
</div>