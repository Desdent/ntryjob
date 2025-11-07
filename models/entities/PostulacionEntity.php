<?php
class PostulacionEntity {
    public $id;
    public $alumno_id;
    public $oferta_id;
    public $estado;
    public $fecha_postulacion;
    
    public function __construct($data=[]) {
        foreach ($data as $k => $v) if (property_exists($this, $k)) $this->$k = $v;
    }
    public function toArray() { return get_object_vars($this); }
}
