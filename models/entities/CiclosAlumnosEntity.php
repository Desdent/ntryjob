<?php
class CiclosAlumnosEntity {
    public $nombre_ciclo;
    public $alumno_id;
    public $ciclo_id;
    public $fecha_inicio;
    public $fecha_fin;

    public function __construct($data=[]) {
        foreach ($data as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
            }
        }
    }
    public function toArray() { return get_object_vars($this); }
}