<?php
class OfertaEntity {
    public $id;
    public $empresa_id;
    public $titulo;
    public $descripcion;
    public $requisitos;
    public $ciclo_id;
    public $fecha_inicio;
    public $fecha_cierre;
    public $modalidad;
    public $salario;
    public $fecha_creacion;
    
    public function __construct($data=[]) {
        foreach ($data as $k => $v) if (property_exists($this, $k)) $this->$k = $v;
    }
    public function toArray() { return get_object_vars($this); }
}
