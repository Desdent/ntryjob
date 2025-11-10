<?php
$this->layout('layout', ['title' => 'Dashboard Admin']);

AuthMiddleware::requiereAuth(['admin']);

$errores = [];
$datosPrevios = [];

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty(trim($_POST['nombre']))){
        $errores["nombreError"] = "Rellena el campo nombre"; 
    }
    else
    {
        $datosPrevios["nombre"] = $_POST["nombre"];
    }

    if(empty(trim($_POST['email']))){
        $errores["emailError"] = "Rellena el campo email"; 
    }
    else
    {
        $datosPrevios["email"] = $_POST["email"];
    }

    if(empty(trim($_POST['telefono']))){
        $errores["telefonoError"] = "Rellena el campo telefono"; 
    }
    else
    {
        $datosPrevios["telefono"] = $_POST["telefono"];
    }

    if(!empty($errores))
    {

        $_SESSION["datosPrevios"] = $datosPrevios;

        $_SESSION["errores"] = $errores;

        header("location: index.php?page=dashboard-admin-addEmpresa");
        exit;
    }

    if(isset($_SESSION["datosPrevios"])) {
        unset($_SESSION["datosPrevios"]);
    }
    $_SESSION["exito"] = "exito";
    header("location: index.php?page=dashboard-admin-addEmpresa");
    exit;

}
else
{
    header("location: index.php?page=dashboard-admin-addEmpresa");
    exit;
}
?>




