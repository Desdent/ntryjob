<?php
class EmpresaEntity {
    public $id;
    public $usuario_id;
    public $nombre;
    public $cif;
    public $telefono;
    public $sector;
    public $descripcion;
    public $pais;
    public $provincia;
    public $ciudad;
    public $direccion;
    public $logo;
    public $aprobada;
    public $verificado;
    public $created_at;
    
    public function __construct($data=[]) {
        foreach ($data as $k => $v) if (property_exists($this, $k)) $this->$k = $v;
    }
    public function toArray() { return get_object_vars($this); }
}
