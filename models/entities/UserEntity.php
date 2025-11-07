<?php
class UserEntity {
    public $id;
    public $email;
    public $password;
    public $created_at;
    
    public function __construct($data=[]) {
        foreach ($data as $k => $v) if (property_exists($this, $k)) $this->$k = $v;
    }
    public function toArray() { return get_object_vars($this); }
}
