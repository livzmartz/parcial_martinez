<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\LoginController;
use Controllers\UsuarioController;
use Controllers\RolController;
use Controllers\PermisoController;
$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [LoginController::class,'index']);
$router->get('/usuarios', [LoginController::class,'usuarios']);
$router->get('/logout', [LoginController::class,'logout']);
$router->post('/API/login', [LoginController::class,'loginAPI']);


$router->get('/API/usuarios/buscar', [UsuarioController::class,'buscarAPI']);
$router->post('/API/usuarios/guardar', [UsuarioController::class,'guardarAPI'] );

$router->get('/API/roles/buscar', [RolController::class,'buscarAPI'] );
$router->post('/API/roles/guardar', [RolController::class,'guardarAPI'] );

$router->get('/API/permisos/buscar', [PermisoController::class,'buscarAPI'] );
$router->post('/API/permisos/guardar', [PermisoController::class,'guardarAPI'] );


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
