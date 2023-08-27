<?php

namespace Controllers;

use Exception;
use Model\Permiso;
use Model\Usuario;
use Model\Rol;
use MVC\Router;

class PermisoController{
 
    public static function buscarUsuario(){
        $sql = "SELECT * FROM usuarios where usu_situacion = '1'";
    
        try {
            $usuarios = Usuario::fetchArray($sql);
    
            return $usuarios;
        } catch (Exception $e) {

            return [];
            
        }
    }

    public static function buscarRol(){
        $sql = "SELECT * FROM roles where rol_situacion = '1'";
    
        try {
            $roles = Rol::fetchArray($sql);
            return $roles;

        } catch (Exception $e) {
            return [];
            
        }
    }

    public static function guardarAPI()
    {
        try {
            $permiso = new Permiso($_POST);
            $resultado = $permiso->crear();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }
            // echo json_encode($resultado);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    public static function buscarAPI()
    {
        $usu_id = $_GET['usu_id'];
        $rol_id = $_GET['rol_id'];

        $sql = "SELECT 
        permisos.permiso_id, 
        usuarios.usu_nombre AS permiso_usuario, 
        usuarios.usu_id, 
        roles.rol_nombre AS permiso_rol, 
        roles.rol_id
    FROM 
        permisos
    INNER JOIN 
        usuarios ON permisos.permiso_usuario = usuarios.usu_id 
    INNER JOIN 
        roles ON permisos.permiso_rol = roles.rol_id 
    WHERE 
        permisos.permiso_situacion = '1'";
    
    if ($usu_id != '') {
        $sql .= " AND usuarios.usu_id = '$usu_id'";
    }
    
    if ($rol_id != '') {
        $sql .= " AND roles.rol_id = '$rol_id'";
    }

        try {

            $permisos = Permiso::fetchArray($sql);

            echo json_encode($permisos);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
}