<?php

namespace Controllers;

use Exception;
use Model\Permiso;
use Model\Usuario;
use Model\Rol;
use MVC\Router;

class ReporteController {
    public static function index(Router $router){
        $router->render('reporte1/index', []);
    }
    public static function index2(Router $router){
        $router->render('reporte2/index', []);
    }

    public static function detalleCantidadAPI(){

        $sql = "SELECT 
                    r.rol_nombre AS Rol, 
                    COUNT(p.permiso_usuario) AS Cantidad_Usuarios
                FROM rol r
                LEFT JOIN permiso p ON r.rol_id = p.permiso_rol
                GROUP BY r.rol_nombre";

        try {
            
            $usuarios = Rol::fetchArray($sql);
    
            echo json_encode($usuarios);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    public static function detalleEstadoAPI(){

        $sql = "SELECT
                    CASE
                        WHEN usu_estado = 'ACTIVO' THEN 'Activo'
                        WHEN usu_estado = 'INACTIVO' THEN 'Inactivo'
                        ELSE 'Pendiente'
                    END AS Estado,
                    COUNT(*) AS Cantidad_Usuarios
                FROM usuario
                GROUP BY usu_estado";

        try {
            
            $usuarios = Rol::fetchArray($sql);
    
            echo json_encode($usuarios);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

}