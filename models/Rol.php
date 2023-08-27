<?php

namespace Model;

class Rol extends ActiveRecord{
    protected static $tabla = 'rol';
    protected static $columnasDB = ['rol_nombre', 'rol_situacion'];
    protected static $idTabla = 'rol_id';

    public $rol_id;
    public $rol_nombre;
    public $rol_situacion;

    public function __construct($args = [])
    {
        $this->rol_id = $args['rol_id'] ?? null;
        $this->rol_nombre = $args['rol_nombre'] ?? ''; 
        $this->rol_situacion = $args['rol_situacion'] ?? 1;
    }
}