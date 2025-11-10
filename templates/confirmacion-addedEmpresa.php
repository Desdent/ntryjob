<?php
$this->layout('layout', ['title' => 'Dashboard Admin']);

AuthMiddleware::requiereAuth(['admin']);

$errores = [];

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty(trim($_POST['nombre']))){
        $errores["nombreError"] = "Rellena el campo nombre"; 
    }

    if(empty(trim($_POST['email']))){
        $errores["emailError"] = "Rellena el campo email"; 
    }

    if(empty(trim($_POST['telefono']))){
        $errores["telefonoError"] = "Rellena el campo telefono"; 
    }

    if(!empty($errores))
    {

        $_SESSION["errores"] = $errores;

        header("location: index.php?page=dashboard-admin-addEmpresa");
        exit;
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




