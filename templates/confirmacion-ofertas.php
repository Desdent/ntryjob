<?php
$this->layout('layout', ['title' => 'Dashboard Admin']);

require_once $_SERVER["DOCUMENT_ROOT"] . '/dao/OfertaDAO.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/models/entities/OfertaEntity.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/middleware/AuthMiddleware.php';
require_once $_SERVER["DOCUMENT_ROOT"] . "/controllers/empresario/OfertasController.php";

$controlador = new OfertaController();
$errores = [];
$datosPrevios = [];
$dao = new OfertaDAO();

if(isset($_POST["id"]))
{
    $datosPrevios["id"] = $_POST["id"];
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_SESSION["confirmarEdicion"]))
    {
        unset($_SESSION["confirmarEdicion"]);

        if(empty(trim($_POST['titulo']))){
        $errores["tituloError"] = "Rellena el campo titulo"; 
        }
        else
        {
            $datosPrevios["titulo"] = $_POST["titulo"];
        }

        if(empty(trim($_POST['descripcion']))){
            $errores["descripcionError"] = "Rellena el campo descripción"; 
        }
        else
        {
            $datosPrevios["descripcion"] = $_POST["descripcion"];
        }

        if(empty(trim($_POST['requisitos']))){
            $errores["requisitosError"] = "Rellena el campo requisitos"; 
        }
        else
        {
            $datosPrevios["requisitos"] = $_POST["requisitos"];
        }

        if(empty(trim($_POST["ciclo"]))){
            $errores["cicloError"] = "Selecciona un ciclo"; 
        }
        else
        {   
            $datosPrevios["ciclo_id"] = $_POST["ciclo"];
        }

        if(empty(trim($_POST["fecha_inicio"]))){
            $errores["fechaInicioError"] = "Selecciona una fecha"; 
        }
        else
        {
            $datosPrevios["fecha_inicio"] = $_POST["fecha_inicio"];
        }

        if(empty(trim($_POST["fecha_cierre"]))){
            $errores["fechaFinError"] = "Selecciona una fecha"; 
        }
        else
        {
            $datosPrevios["fecha_cierre"] = $_POST["fecha_cierre"];
        }

        if(empty(trim($_POST["modalidad"]))){
            $errores["modalidadError"] = "Selecciona una modalidad"; 
        }
        else
        {
            $datosPrevios["modalidad"] = $_POST["modalidad"];
        }

        if(empty(trim($_POST["salario"]))){
            $errores["salarioError"] = "Introduce un salario"; 
        }
        else
        {
            $datosPrevios["salario"] = $_POST["salario"];
        }

        if(!empty($errores))
        {

            $_SESSION["datosPrevios"] = $datosPrevios;

            $_SESSION["errores"] = $errores;

            header("location: ");
            exit;
        }

        if(isset($_SESSION["datosPrevios"])) {
            unset($_SESSION["datosPrevios"]);
        }

        $datosPrevios["id"];

        $oferta = new OfertaEntity($datosPrevios);
        $nuevo = $dao->update($oferta);


        if($nuevo)
        {
            $_SESSION["exito"] = "editada";
            header("location: index.php?page=dashboard-empresario-oferta-ver-editar");
            exit;
        }

    }
    elseif(isset($_SESSION["confirmarBorrado"]))
    {


        $borrado = $dao->delete($datosPrevios["id"]);

    if($borrado)
        {
            $_SESSION["exito"] = "borrada";
            header("location: index.php?page=dashboard-empresario-oferta-ver-editar");
            exit;
        }
    }

    

}
else
{
    header("location: index.php?page=dashboard-empresario-oferta-ver-editar");
    exit;
}
?>
