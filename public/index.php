<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\UsuarioController;
use Controllers\PermisoController;
use Controllers\RolController;
use Controllers\ReporteController;


$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);

$router->get('/usuarios', [UsuarioController::class,'index']);
$router->get('/registroUsuario', [UsuarioController::class,'registro']);
$router->get('/API/usuarios/buscar', [UsuarioController::class,'buscarAPI']);
$router->post('/API/usuarios/guardar', [UsuarioController::class,'guardarAPI'] );
$router->post('/API/usuarios/modificar', [UsuarioController::class,'modificarAPI']);
$router->post('/API/usuarios/eliminar', [UsuarioController::class,'eliminarAPI']);
$router->post('/API/usuarios/activar', [UsuarioController::class,'activarAPI']);
$router->post('/API/usuarios/desactivar', [UsuarioController::class,'desactivarAPI']);
// $router->get('/usuarios/estadistica', [PermisoController::class,'estadistica']);



$router->get('/permisos', [PermisoController::class,'index']);
$router->get('/API/permisos/buscar', [PermisoController::class,'buscarAPI'] );
$router->post('/API/permisos/guardar', [PermisoController::class,'guardarAPI'] );
$router->post('/API/permisos/eliminar', [PermisoController::class,'eliminarAPI']);

$router->get('/API/permisos/estadistica/reporte1', [ReporteController::class,'detalleCantidadAPI']);
$router->get('/API/permisos/estadistica/reporte2', [ReporteController::class,'detalleEstadoAPI']);
$router->get('/reporte1', [ReporteController::class,'index']);
$router->get('/reporte2', [ReporteController::class,'index2']);

$router->get('/roles', [RolController::class,'index']);
$router->get('/API/roles/buscar', [RolController::class,'buscarAPI']);
$router->post('/API/roles/guardar', [RolController::class,'guardarAPI'] );
$router->post('/API/roles/modificar', [RolController::class,'modificarAPI']);
$router->post('/API/roles/eliminar', [RolController::class,'eliminarAPI']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
