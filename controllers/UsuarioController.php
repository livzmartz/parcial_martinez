<?php

namespace Controllers;

use Exception;
use Model\Usuario;
use MVC\Router;

class UsuarioController{

    public static function index(Router $router)
    {
        $usuario = usuario::all();
        $router->render('usuarios/index', [
            'usuarios' => $usuario,
        ]);
    }
    public static function registro(Router $router)
    {

        $router->render('registro_usuario/index', []);
    }

    public static function guardarApi()
    {
        try {

            $contrasenia = $_POST['usu_password'];

            $contraseniaHasheada = password_hash($contrasenia, PASSWORD_DEFAULT);

            $_POST['usu_password'] = $contraseniaHasheada;

            $usuario = new Usuario($_POST);

            $resultado = $usuario->crear();

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
        // $usuarios = usuario::all();
        $usu_nombre = $_GET['usu_nombre'];
        $usu_usuario = $_GET['usu_usuario'];

        $sql = "SELECT * FROM usuario WHERE usu_situacion = '1' ";
        if ($usu_nombre != '') {
            $usu_nombre = strtolower($usu_nombre);
            $sql .= " AND LOWER(usu_nombre) LIKE '%$usu_nombre%' ";
        }
        if ($usu_usuario != '') {
            $usu_usuario = strtolower($usu_usuario);
            $sql .= " AND usu_usuario= '$usu_usuario' ";
        }

        try {

            $usuario = Usuario::fetchArray($sql);

            echo json_encode($usuario);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }

    }

    public static function modificarAPI()
    {
        try {
            $contrasenia = $_POST['usu_password'];

            $contraseniaHasheada = password_hash($contrasenia, PASSWORD_DEFAULT);

            $_POST['usu_password'] = $contraseniaHasheada;
            
            $usuario = new Usuario($_POST);
            $resultado = $usuario->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro modificado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error al actualizar',
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

    public static function eliminarAPI()
    {

        try {
            $usu_id = $_POST['usu_id'];
            $usuario = Usuario::find($usu_id);
            $usuario->usu_situacion = 0;

            $resultado = $usuario->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Eliminado correctamente',
                    'codigo' => 1
                ]);

            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error al eliminar el registro',
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

    public static function activarAPI(){

        try {
            $usu_id = $_POST['usu_id'];
            $usuario = Usuario::find($usu_id);
            $usuario->usu_estado = 'ACTIVO';

            $resultado = $usuario->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Se ha activado el usuario correctamente',
                    'codigo' => 1
                ]);

            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error al activar el usuario',
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
    
    public static function desactivarAPI(){

        try {
            $usu_id = $_POST['usu_id'];
            $usuario = Usuario::find($usu_id);
            $usuario->usu_estado = 'INACTIVO';

            $resultado = $usuario->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Se ha desactivado el usuario correctamente',
                    'codigo' => 1
                ]);

            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error al desactivar el usuario',
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
 }