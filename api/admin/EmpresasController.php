<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/dao/EmpresaDAO.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/models/entities/EmpresaEntity.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/middleware/AuthMiddleware.php';


class EmpresasController {

    public static function actualizarEmpresa($empresaPOST)
    {
        $empresa = new EmpresaEntity($empresaPOST);
        $dao = new EmpresaDAO();
        $empresa->setAlgunosParametros($_POST["nombre"],$_POST["cif"],$_POST["email"],$_POST["telefono"],
                    $_POST["sector"],$_POST["pais"],$_POST["provincia"],$_POST["ciudad"],$_POST["direccion"],
                    $_POST["descripcion"]);
        $dao->update($empresa);
    }

    public static function obtenerEmpresa($email)
    {
        $dao = new EmpresaDAO();
        $empresa = $dao->findByEmail($email);

        return $empresa;
    }

    public static function borrarEmpresa($empresaPOST)
    {
        $empresa = new EmpresaEntity($empresaPOST);
        $dao = new EmpresaDAO();
        $dao->delete($empresa->id);
    }

    public static function aprobarEmpresa($empresaPOST)
    {
        $empresa = new EmpresaEntity($empresaPOST);
        $dao = new EmpresaDAO();
        $dao->aprobar($empresa->id);
    }

    public static function rechazarEmpresa($empresaPOST)
    {
        $empresa = new EmpresaEntity($empresaPOST);
        $dao = new EmpresaDAO();
        $dao->delete($empresa->id);
    }

    public static function ordenarEmpresas($parameter, $metodo)
    {
        $dao = new EmpresaDAO();
        $empresas = $dao->sortBy($parameter, $metodo);
        return $empresas;
    }

    public static function ordenarPendientes($parameter, $metodo)
    {
        $dao = new EmpresaDAO();
        $empresas = $dao->sortPendientesBy($parameter, $metodo);
        return $empresas;
    }

    public static function searchByWords($palabra)
    {
        $dao = new EmpresaDAO();
        
        $empresas = $dao->searchWord($palabra);
        return $empresas;
    }

    public static function searchPendientesByWords($palabra)
    {
        $dao = new EmpresaDAO();
        
        $empresas = $dao->searchPendientesWord($palabra);
        return $empresas;
    }

}

