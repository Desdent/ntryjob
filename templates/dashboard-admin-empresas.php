<?php
$this->layout('layout', ['title' => 'Dashboard Admin']);

require_once $_SERVER["DOCUMENT_ROOT"] . '/dao/EmpresaDAO.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/models/entities/EmpresaEntity.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/middleware/AuthMiddleware.php';


AuthMiddleware::requiereAuth(['admin']);


$dao = new EmpresaDAO();
$empresas = $dao->getAll();
$empresasPendientes = $dao->getPendientes();
$resultado = [];
$resultadoPendientes = [];
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
                        <button class="botonesAñadirCargar" id="createEmpresa">Añadir Empresa</button>
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
                            echo "<tr>";
                                foreach($data as $campo)
                                {
                                    echo "<td> $campo </td>";
                                }
                                ?>
                                <td>
                                    <form action="">
                                    <input type="submit" value="Editar" class="botonesAccionEmpresas">
                                    <input type="submit" value="Borrar" class="botonesAccionEmpresas">
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
                    <h2>Pendientes de aprobación</h2>
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
                            echo "<tr>";
                                foreach($dataPendientes as $campoPendientes)
                                {
                                    echo "<td> $campoPendientes </td>";
                                }
                                ?>
                                <td>
                                    <form action="">
                                    <input type="submit" value="Aprobar" class="botonesAccionEmpresas">
                                    <input type="submit" value="Rechazar" class="botonesAccionEmpresas">
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