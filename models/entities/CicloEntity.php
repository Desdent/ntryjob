<?php
class CicloEntity {
    public $id;
    public $nombre;
    public $codigo;
    
    public function __construct($data=[]) {
        foreach ($data as $k => $v) if (property_exists($this, $k)) $this->$k = $v;
    }
    public function toArray() { return get_object_vars($this); }
}
