<?php
$this->layout('layout', ['title' => 'Dashboard Empresa']);

require_once $_SERVER["DOCUMENT_ROOT"] . "/controllers/empresario/OfertasController.php";

$controller = new OfertaController();
$userid = $_SESSION["user_id"];
var_dump($_POST);

if(isset($_POST["id_oferta"]))
{
    ?>
        <input type="hidden" id="input_id_oferta" value="<?php echo $_POST["id_oferta"] ?>">
        <input type="hidden" id="input_id_user" value="<?php echo $_POST["id_user"] ?>">
    <?php
}
?>

<script src="/public/js/empresario/ofertas.js"></script>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Panel de Empresa</h1>
        <p>Bienvenido, <?= htmlspecialchars($_SESSION['email']) ?></p>
    </div>


    <div class="table-container">
        <h2>Postulantes</h2>
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
                            <input type="submit" name="submitOrdenarPendientes" value="Ordenar" class="botonesEmpresa">
                        </form>
                </div>
                
            </div>

            <div id="containerPostulantes">
            </div>
    </div>
</div>