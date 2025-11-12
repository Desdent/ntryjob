<?php
$this->layout('layout', ['title' => 'Dashboard Admin']);

require_once __DIR__ . '/../api/admin/EmpresasController.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/dao/EmpresaDAO.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/models/entities/EmpresaEntity.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/middleware/AuthMiddleware.php';

AuthMiddleware::requiereAuth(['admin']);

$datosForm = [];
$resultado = [];
$dao = new EmpresaDAO();
$controller = new EmpresasController();

if(isset($_POST["datosSerialized"]))
{
    $datosForm = unserialize($_POST["datosSerialized"]);
    $datosSerialized = $_POST["datosSerialized"];
}

// GESTIÓN DE EMPRESAS APROBADAS
if(isset($_POST["ordenarEmpresas"]))
{
    switch($_POST["ordenarEmpresas"])
    {
        case "sortNombreEmpresasAsc":
            $empresas = $controller::ordenarEmpresas("nombre", "asc");
            break;
        case "sortNombreEmpresasDesc":
            $empresas = $controller::ordenarEmpresas("nombre", "desc");
            break;
        case "sortCIFEmpresasAsc":
            $empresas = $controller::ordenarEmpresas("cif", "asc");
            break;
        case "sortCIFEmpresasDesc":
            $empresas = $controller::ordenarEmpresas("cif", "desc");
            break;
        case "sortEmailEmpresasAsc":
            $empresas = $controller::ordenarEmpresas("email", "asc");
            break;
        case "sortEmailEmpresasDesc":
            $empresas = $controller::ordenarEmpresas("email", "desc");
            break;
        case "sortTelefonoEmpresasAsc":
            $empresas = $controller::ordenarEmpresas("telefono", "asc");
            break;
        case "sortTelefonoEmpresasDesc":
            $empresas = $controller::ordenarEmpresas("telefono", "desc");
            break;
        case "sortCiudadEmpresasAsc":
            $empresas = $controller::ordenarEmpresas("ciudad", "asc");
            break;
        case "sortCiudadEmpresasDesc":
            $empresas = $controller::ordenarEmpresas("ciudad", "desc");
            break;
    }
}
elseif(isset($_POST["search-empresas"]) && !empty($_POST["search-empresas"]))
{
    $palabra = $_POST["search-empresas"];
    $empresas = $controller::searchByWords($palabra);
}
else
{  
    $empresas = $dao->getAll();
}

// GESTIÓN DE EMPRESAS PENDIENTES
if(isset($_POST["ordenarPendientes"]))
{
    switch($_POST["ordenarPendientes"])
    {
        case "sortNombrePendientesAsc":
            $empresasPendientes = $controller::ordenarPendientes("nombre", "asc");
            break;
        case "sortNombrePendientesDesc":
            $empresasPendientes = $controller::ordenarPendientes("nombre", "desc");
            break;
        case "sortCIFPendientesAsc":
            $empresasPendientes = $controller::ordenarPendientes("cif", "asc");
            break;
        case "sortCIFPendientesDesc":
            $empresasPendientes = $controller::ordenarPendientes("cif", "desc");
            break;
        case "sortEmailPendientesAsc":
            $empresasPendientes = $controller::ordenarPendientes("email", "asc");
            break;
        case "sortEmailPendientesDesc":
            $empresasPendientes = $controller::ordenarPendientes("email", "desc");
            break;
        case "sortTelefonoPendientesAsc":
            $empresasPendientes = $controller::ordenarPendientes("telefono", "asc");
            break;
        case "sortTelefonoPendientesDesc":
            $empresasPendientes = $controller::ordenarPendientes("telefono", "desc");
            break;
        case "sortCiudadPendientesAsc":
            $empresasPendientes = $controller::ordenarPendientes("ciudad", "asc");
            break;
        case "sortCiudadPendientesDesc":
            $empresasPendientes = $controller::ordenarPendientes("ciudad", "desc");
            break;
    }
}
elseif(isset($_POST["search-empresasPendientes"]) && !empty($_POST["search-empresasPendientes"]))
{
    $palabra = $_POST["search-empresasPendientes"];
    $empresasPendientes = $controller::searchPendientesByWords($palabra);
}
else
{
    $empresasPendientes = $dao->getPendientes();
}

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
                    <h2>Listado de Empresas</h2>
                </div>
                <div id="containerSearchEmpresas">
                    <form action="" method="POST">
                        <input type="text" id="search-empresas" name="search-empresas" placeholder="Buscar empresa, email...">
                        <input type="submit" name="submitSearchEmpresas" value="Buscar" class="botonesEmpresa">
                    </form>
                    <form action="" method="POST">
                        <select name="ordenarEmpresas" id="filtrarEmpresas" class="botonesEmpresa">
                            <option value="" disabled selected>Sort By:</option>
                            <option value="sortNombreEmpresasAsc">Nombre ▲</option>
                            <option value="sortNombreEmpresasDesc">Nombre ▼</option>
                            <option value="sortCIFEmpresasAsc">CIF ▲</option>
                            <option value="sortCIFEmpresasDesc">CIF ▼</option>
                            <option value="sortEmailEmpresasAsc">Email ▲</option>
                            <option value="sortEmailEmpresasDesc">Email ▼</option>
                            <option value="sortTelefonoEmpresasAsc">Teléfono ▲</option>
                            <option value="sortTelefonoEmpresasDesc">Teléfono ▼</option>
                            <option value="sortCiudadEmpresasAsc">Ciudad ▲</option>
                            <option value="sortCiudadEmpresasDesc">Ciudad ▼</option>
                        </select>
                        <input type="submit" name="submitOrdenarEmpresas" value="Ordenar Tabla" class="botonesEmpresa">
                        <!-- RECORDAR!!! Para evitar conflictos cuando se usan varios forms, hay que darle names a TODOS los submit -->
                    </form>

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
                                    <?php $datosSerialized = serialize($empresaDatos); ?>
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
                        <form action="" method="POST">
                            <input type="text" id="search-empresasPendientes" name="search-empresasPendientes" placeholder="Buscar empresa, email...">
                            <input type="submit" name="submitSearchPendientes" value="Buscar" class="botonesEmpresa">
                        </form>
                        <form action="" method="POST">
                            <select name="ordenarPendientes" id="filtrarPendientes" class="botonesEmpresa">
                                <option value="" disabled selected>Sort By:</option>
                                <option value="sortNombrePendientesAsc">Nombre ▲</option>
                                <option value="sortNombrePendientesDesc">Nombre ▼</option>
                                <option value="sortCIFPendientesAsc">CIF ▲</option>
                                <option value="sortCIFPendientesDesc">CIF ▼</option>
                                <option value="sortEmailPendientesAsc">Email ▲</option>
                                <option value="sortEmailPendientesDesc">Email ▼</option>
                                <option value="sortTelefonoPendientesAsc">Teléfono ▲</option>
                                <option value="sortTelefonoPendientesDesc">Teléfono ▼</option>
                                <option value="sortCiudadPendientesAsc">Ciudad ▲</option>
                                <option value="sortCiudadPendientesDesc">Ciudad ▼</option>
                            </select>
                            <input type="submit" name="submitOrdenarPendientes" value="Ordenar Tabla" class="botonesEmpresa">
                        </form>
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
                                        <?php $datosPendienteSerialized = serialize($empresaPendienteDatos); ?>
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
        </div>
    </div>
</div>