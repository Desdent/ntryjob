<?php
$this->layout('layout', ['title' => 'Dashboard Admin']);

require_once __DIR__ . '/../api/admin/EmpresasController.php';

require_once $_SERVER["DOCUMENT_ROOT"] . '/dao/EmpresaDAO.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/models/entities/EmpresaEntity.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/middleware/AuthMiddleware.php';


AuthMiddleware::requiereAuth(['admin']);

$datosForm = [];

if(isset($_POST["datosSerialized"]))
{
    $datosForm = unserialize($_POST["datosSerialized"]);
    $datosSerialized = $_POST["datosSerialized"];
}

$dao = new EmpresaDAO();
$empresas = $dao->getAll();
$empresasPendientes = $dao->getPendientes();
$resultado = [];
$resultadoPendientes = [];

$empresa;

foreach($empresas as $empresa)
{
    $resultado[] = $empresa->toArrayDTO();
}

foreach($empresasPendientes as $empresaPendiente)
{
    $resultadoPendientes[] = $empresaPendiente->toArrayDTO();
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
        
        <div class="table-container">
            <div class="headerTableContainer">
                <div id="divh2">
                    <h2>Listado de Empresas</h2>
                </div>
                <div id="containerSearchEmpresas">
                    <div id="input-searchEmpresas">
                        <input type="text" id="search-empresas" name="search-empresas" placeholder="Buscar empresa, email...">
                    </div>

                    <div>
                        <a href="index.php?page=dashboard-admin-addEmpresa" class="addEmpresa">Añadir Empresa</a>
                    </div>
                </div>
            </div>
            <table id="tablaEmpresas">
                <thead>
                    <tr>
                        <th>Nombre  ◀</th>
                        <th>CIF  ◀</th>
                        <th>Email  ◀</th>
                        <th>Teléfono  ◀</th>
                        <th>Ciudad  ◀</th>
                        <th>Acciones  ◀</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        
                        
                        foreach($resultado as $data){
                            
                            new EmpresasController();
                            $empresa = EmpresasController::obtenerEmpresa($data["email"]);
                            
                            $empresaDatos = $empresa->toArray();

                            echo "<tr>";
                                foreach($data as $campo)
                                {
                                    echo "<td> $campo </td>";
                                }

                            ?>
                            <td>
                                <form action="?page=admin-editarEmpresa" method="POST">

                                    <?php
                                    $datosSerialized = serialize($empresaDatos);
                                    ?>
                                    <!-- Para pasar el string a array -->
                                    <input type="hidden" name="datosSerialized" value="<?php echo htmlspecialchars($datosSerialized)?>">

                                    <input type="submit" value="Editar" class="botonesAccionEmpresas">
                                </form>

                                <form action="" method="POST">
                                    <input type="hidden" name="datosSerialized" value="<?php echo htmlspecialchars($datosSerialized)?>">
                                    <input type="submit" name="btnBorrarEmpresa" value="Borrar" class="botonesAccionEmpresas">
                                </form>
                            </td>
                                

                    <?php
                    echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="tablePendientes-container">
            <div class="headerTableContainer">
                <div id="divh2Pendientes">
                    <h2>Pendientes de Aprobación</h2>
                </div>
                <div id="containerSearchPendientes">
                    <div id="input-searchPendientes">
                        <input type="text" id="search-empresasPendientes" name="search-empresasPendientes" placeholder="Buscar empresa, email...">
                    </div>

                    <div>
                    </div>
                </div>
            </div>
            <table id="tablaPendientes">
                <table id="tablaEmpresas">
                <thead>
                    <tr>
                        <th>Nombre  ◀</th>
                        <th>CIF  ◀</th>
                        <th>Email  ◀</th>
                        <th>Teléfono  ◀</th>
                        <th>Ciudad  ◀</th>
                        <th>Acciones  ◀</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        
                        foreach($resultadoPendientes as $dataPendientes){

                            new EmpresasController();
                            $empresaPendiente = EmpresasController::obtenerEmpresa($dataPendientes["email"]);
                            
                            $empresaPendienteDatos = $empresaPendiente->toArray();


                            echo "<tr>";
                                foreach($dataPendientes as $campoPendientes)
                                {
                                    echo "<td> $campoPendientes </td>";
                                }
                                ?>
                                <td>
                                    <form action="" method="POST">

                                        <?php
                                        $datosPendienteSerialized = serialize($empresaPendienteDatos);
                                        ?>
                                        <!-- Para pasar el string a array -->
                                        <input type="hidden" name="datosPendienteSerialized" value="<?php echo htmlspecialchars($datosPendienteSerialized)?>">
                                        
                                        <input type="submit" name="btnRechazarEmpresa" value="Rechazar" class="botonesAccionEmpresas">
                                    </form>

                                    <form action="" method="POST">

                                        <input type="hidden" name="datosPendienteSerialized" value="<?php echo htmlspecialchars($datosPendienteSerialized)?>">

                                        <input type="submit" name="btnAprobarEmpresa" value="Aprobar" class="botonesAccionEmpresas">
                                    </form>
                                </td>
                                

                                <?php
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
            </table>
        </div>
    </div>

    
</div>