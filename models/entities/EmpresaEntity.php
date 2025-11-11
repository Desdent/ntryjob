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
    public $email;
    public $password;
    
    public function __construct($data=[]) {
        foreach ($data as $k => $v) if (property_exists($this, $k)) $this->$k = $v;
    }

    public function setAlgunosParametros($nombre, $cif, $email, $telefono, $sector, $pais, $provincia, $ciudad, $direccion, $descripcion)
    {
        $this->nombre = $nombre;
        $this->cif = $cif;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->sector = $sector;
        $this->pais = $pais;
        $this->provincia = $provincia;
        $this->ciudad = $ciudad;
        $this->direccion = $direccion;
        $this->direccion = $descripcion;
    }

    public function toArray() { return get_object_vars($this); }

    public function toArrayDTO(){
        return [
            "nombre" => $this->nombre,
            "cif" => $this->cif,
            "email" => $this->email,
            "telefono" => $this->telefono,
            "ciudad" => $this->ciudad
        ];
    }
}
