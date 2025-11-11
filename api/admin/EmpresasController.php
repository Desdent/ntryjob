<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/dao/EmpresaDAO.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/models/entities/EmpresaEntity.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/middleware/AuthMiddleware.php';


class EmpresasController {

    public static function actualizarEmpresa()
    {
        $empresa = new EmpresaEntity($_POST);
        $dao = new EmpresaDAO();
        $dao->update($empresa);
    }

}

