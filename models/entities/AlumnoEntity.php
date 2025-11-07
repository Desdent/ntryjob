<?php
class AlumnoEntity {
    public $id;
    public $usuario_id;
    public $nombre;
    public $apellidos;
    public $telefono;
    public $fecha_nacimiento;
    public $pais;
    public $provincia;
    public $ciudad;
    public $direccion;
    public $codigo_postal;
    public $cv;
    public $foto;
    public $ciclo_id;
    public $fecha_inicio;
    public $fecha_fin;
    public $verificado;
    public $created_at;

    public $email;
    public $password;

    public function __construct($data=[]) {
        foreach ($data as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
            }
        }
    }
    public function toArray() { return get_object_vars($this); }
}
