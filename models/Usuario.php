<?php

namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla = 'usuario';
    protected static $columnasDB = ['usu_nombre','usu_usuario','usu_password','usu_estado','usu_situacion'];
    protected static $idTabla = 'usu_id';

    public $usu_id;
    public $usu_nombre;
    public $usu_usuario;
    public $usu_password;
    public $usu_estado;
    public $usu_situacion;

    public function __construct($args =[])
    {
        $this->usu_id = $args['usu_id'] ?? null;
        $this->usu_nombre = $args['usu_nombre'] ?? '';
        $this->usu_usuario = $args['usu_usuario'] ?? '';
        $this->usu_password = $args['usu_password'] ?? '';        
        $this->usu_estado = $args['usu_estado'] ?? 'PENDIENTE';
        $this->usu_situacion = $args['usu_situacion'] ?? '1';
    }

}