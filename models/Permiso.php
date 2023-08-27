<?php

namespace Model;

class Permiso extends ActiveRecord{
    protected static $tabla = 'permisos';
    protected static $columnasDB = ['PERMISO_USUARIO','PERMISO_ROL','PERMISO_SITUACION'];
    protected static $idTabla = 'permiso_id';
    
    public $permiso_id;
    public $permiso_usuario;
    public $permiso_rol;
    public $permiso_situacion;

    public function __construct($args = [])
    {
        $this->permiso_id = $args['permiso_id'] ?? null;
        $this->permiso_usuario = $args['permiso_usuario'] ?? '';
        $this->permiso_rol = $args['permiso_rol'] ?? '';
        $this->permiso_situacion = $args['permiso_situacion'] ?? '1';
    }
}