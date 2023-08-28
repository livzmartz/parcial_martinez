<?php

namespace Controllers;

use Exception;
use Model\Permiso;
//use Model\Rol;
use MVC\Router;

class PermisoController{
    public static function index(Router $router) {

    $usuario= Permiso::all();
        $rol= Permiso::all();
        $usuarios = static::usuarios();
        $roles = static::roles();
        $router->render('permisos/index', [
            'permiso_usuario' => $usuario,
            'permiso_rol' => $rol,
            'usuarios' => $usuarios, 
            'roles' => $roles
       ]);
     
    }   
    
    public static function guardarApi(){

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

        $sql = 
        "SELECT 
            p.permiso_id, 
            u.usu_nombre AS permiso_usuario,
            u.usu_id,
            r.rol_nombre AS permiso_rol,
            r.rol_id,
            u.usu_situacion,
            u.usu_estado,
            u.usu_password 
        FROM permiso p
        INNER JOIN
            usuario u ON p.permiso_usuario = u.usu_id
        INNER JOIN
            rol r ON p.permiso_rol = r.rol_id
        WHERE
            p.permiso_situacion = '1'";
    
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

    public static function eliminarAPI()
    {
        try {
            $permiso_id = $_POST['permiso_id'];
            $permiso = Permiso::find($permiso_id);
            $permiso->permiso_situacion = 0;
            $resultado = $permiso->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro eliminado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }

        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
 
    public  static function roles()
    {
        $sql = "SELECT * FROM rol WHERE rol_situacion = '1' ";
        
        try {
            
            $roles = Permiso::fetchArray($sql);
 
            if ($roles){
                
                return $roles; 
            }else {
                return 0;
            }
        } catch (Exception $e) {
            
        }
    }
    
    public  static function usuarios()
    {
        $sql = "SELECT * FROM usuario ";
        
        try {
            
            $usuarios = Permiso::fetchArray($sql);
 
            if ($usuarios){
                
                return $usuarios; 
            }else {
                return 0;
            }
        } catch (Exception $e) {
            
        }
    }
    
}
