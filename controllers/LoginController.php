<?php

namespace Controllers;

use Exception;

use MVC\Router;
use Model\Usuario;

class LoginController {

    public static function index(Router $router) {
        $router->render('login/index', []);
        
    }


    public static function loginAPI() {
        $catalogo = filter_var($_POST['usu_catalogo'], FILTER_SANITIZE_NUMBER_INT);
        $password = filter_var($_POST['usu_password'], FILTER_DEFAULT);
        $usuarioRegistrado = Usuario::fetchFirst("SELECT * FROM usuario WHERE usu_catalogo = $catalogo");

        try {
            if (is_array($usuarioRegistrado)) {
                $verificacion = password_verify($password, $usuarioRegistrado['usu_password']);
                $nombre = $usuarioRegistrado["usu_nombre"];
                
                if ($verificacion) {
                    session_start();
                    $_SESSION['auth_user'] = $catalogo;
                
                    echo json_encode([
                        'codigo' => 1,
                        'mensaje' => "Sesión iniciada correctamente. Bienvenido $nombre",
                    ]);
                    
                } else {
                    echo json_encode([
                        'codigo' => 2,
                        'mensaje' => 'Contraseña incorrecta'
                    ]);
                }
            } else {
                echo json_encode([
                    'codigo' => 2,
                    'mensaje' => 'Usuario no encontrado'
                ]);
            }
        } catch (\Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'codigo' => 0,
                'mensaje' => 'Usuario no encontrado'
            ]);
        }
    }
    public static function logout(){
        $_SESSION = [];
        session_unset();
        session_destroy();
        header('Location: /parcial_martinez/');
    }
}