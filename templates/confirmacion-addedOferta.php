<?php
$this->layout('layout', ['title' => 'Dashboard Admin']);

require_once $_SERVER["DOCUMENT_ROOT"] . '/dao/OfertaDAO.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/models/entities/OfertaEntity.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/middleware/AuthMiddleware.php';
require_once $_SERVER["DOCUMENT_ROOT"] . "/controllers/empresario/OfertasController.php";

$controlador = new OfertaController();
$id = $controlador->_getEmpresaId($_SESSION["user_id"]);

$errores = [];
$datosPrevios = [];
$datosPrevios["empresa_id"] = $id;
$dao = new OfertaDAO();

if($_SERVER["REQUEST_METHOD"] == "POST")
{
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

    if(empty(trim($_POST["fechaInicio"]))){
        $errores["fechaInicioError"] = "Selecciona una fecha"; 
    }
    else
    {
        $datosPrevios["fecha_inicio"] = $_POST["fechaInicio"];
    }

    if(empty(trim($_POST["fechaFin"]))){
        $errores["fechaFinError"] = "Selecciona una fecha"; 
    }
    else
    {
        $datosPrevios["fecha_cierre"] = $_POST["fechaFin"];
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

        header("location: index.php?page=dashboard-empresario-crearOferta");
        exit;
    }

    if(isset($_SESSION["datosPrevios"])) {
        unset($_SESSION["datosPrevios"]);
    }


    $oferta = new OfertaEntity($datosPrevios);
    $nuevo = $dao->create($oferta);


    if($nuevo)
    {
        $_SESSION["exito"] = "exito";
        header("location: index.php?page=dashboard-empresario-crearOferta");
        exit;
    }

    



}
else
{
    header("location: index.php?page=dashboard-empresario-crearOferta");
    exit;
}
?>




