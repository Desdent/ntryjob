<?php
$this->layout('layout', ['title' => 'Dashboard Empresa']);

require_once $_SERVER["DOCUMENT_ROOT"] . "/controllers/empresario/OfertasController.php";

$controller = new OfertaController();
$userid = $_SESSION["user_id"];
if(isset($_POST["search-ofertas"]))
{

    $ofertas = $controller->buscarOfertas($_POST["search-ofertas"], $userid);
}
elseif(isset($_POST["ordenarOfertas"]))
{

    switch($_POST["ordenarOfertas"])
    {
        case "sortNombreOfertasAsc":
            $ofertas = $controller->sortOfertas("titulo", "asc", $userid);
            break;
        case "sortNombreOfertasDesc":
            $ofertas = $controller->sortOfertas("titulo", "desc", $userid);
            break;
        case "sortCicloOfertasAsc":
            $ofertas = $controller->sortOfertas("ciclo_id", "asc", $userid);
            break;
        case "sortCicloOfertasDesc":
            $ofertas = $controller->sortOfertas("ciclo_id", "desc", $userid);
            break;
        case "sortFechaInicioOfertasAsc":
            $ofertas = $controller->sortOfertas("fecha_inicio", "asc", $userid);
            break;
        case "sortFechaInicioOfertasDesc":
            $ofertas = $controller->sortOfertas("fecha_inicio", "desc", $userid);
            break;
        case "sortFechaFinOfertasAsc":
            $ofertas = $controller->sortOfertas("fecha_cierre", "asc", $userid);
            break;
        case "sortFechaFinOfertasDesc":
            $ofertas = $controller->sortOfertas("fecha_cierre", "desc", $userid);
            break;
        case "sortSalarioOfertasAsc":
            $ofertas = $controller->sortOfertas("salario", "asc", $userid);
            break;
        case "sortSalarioOfertasDesc":
            $ofertas = $controller->sortOfertas("salario", "desc", $userid);
            break; 
        default:
            $ofertas = $controller->getOfertasByEmpresa($userid);
    }
}
else{
    $ofertas = $controller->getOfertasByEmpresa($userid);
}
?>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Panel de Empresa</h1>
        <p>Bienvenido, <?= htmlspecialchars($_SESSION['email']) ?></p>
    </div>


    <div class="table-container">
        <h2>Mis Ofertas Publicadas</h2>
            <div id="headerTableContainer">
                <div id="containerSearcOfertas">
                        <form action="" method="POST">
                            <input type="text" id="search-ofertas" name="search-ofertas" placeholder="Buscar...">
                            <input type="submit" name="submitSearchOfertas" value="Buscar" class="botonesEmpresa">
                        </form>
                        <form action="" method="POST">
                            <select name="ordenarOfertas" id="filtrarOfertas" class="botonesEmpresa">
                                <option value="" disabled selected>Sort By:</option>
                                <option value="sortNombreOfertasAsc">Título ▲</option>
                                <option value="sortNombreOfertasDesc">Título ▼</option>
                                <option value="sortCicloOfertasAsc">Ciclo ▲</option>
                                <option value="sortCicloOfertasDesc">Ciclo ▼</option>
                                <option value="sortFechaInicioOfertasAsc">Fecha Inicio ▲</option>
                                <option value="sortFechaInicioOfertasDesc">Fecha Inicio ▼</option>
                                <option value="sortFechaFinOfertasAsc">Fecha Fin ▲</option>
                                <option value="sortFechaFinOfertasDesc">Fecha Fin ▼</option>
                            </select>
                            <input type="submit" name="submitOrdenarPendientes" value="Ordenar Tabla" class="botonesEmpresa">
                        </form>
                        <div>
                            <form action="" method="POST" >
                                <input type="submit" value="Crear Oferta" class="botonesEmpresa" name="btnCrearOferta">
                            </form>
                            
                        </div>
                </div>
                
            </div>

            <table id="tablaOfertas">
                <thead>
                    <th>Título</th>
                    <th>Ciclo</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Fin</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    <?php
                        foreach($ofertas as $oferta)
                        {
                            $ofertaSerialized = htmlspecialchars(serialize($oferta));
                            ?>
                            <tr>
                                <td>
                                    <?php
                                        echo $oferta->titulo;
                                    ?>
                                </td>

                                <td>
                                    <?php
                                        echo $controller->getCicloById($oferta->ciclo_id);

                                    ?>
                                </td>

                                <td>
                                    <?php
                                        echo $oferta->fecha_inicio;
                                    ?>
                                </td>

                                <td>
                                    <?php
                                        echo $oferta->fecha_cierre;
                                    ?>
                                </td>

                                <td>
                                    <form action="" method="POST">
                                        <input type="submit" value="Editar" name="btnEditarOferta" class="botonesAccionEmpresas">
                                        <input type="submit" value="Borrar" name="btnBorrarOferta" class="botonesAccionEmpresas">
                                        <input type="submit" value="Ver Oferta" name="btnVerOferta" class="botonesAccionEmpresas">
                                        <input type="submit" value="Ver Solicitudes" name="btnVerPostulantes" class="botonesAccionEmpresas">
                                        <input type="hidden" value="<?php echo $ofertaSerialized; ?>" name="ofertaSerialized">
                                        <input type="hidden" name="id_oferta" id="input_id_oferta" value="<?php echo $oferta->id; ?>">
                                        <input type="hidden" name="id_user" id="input_id_user" value="<?php echo $userid?>">
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>
    </div>
</div>