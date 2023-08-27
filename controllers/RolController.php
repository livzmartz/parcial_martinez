<?php

namespace Controllers;

use Exception;
use Model\Rol;
use MVC\Router;

class RolController {
    public static function guardarAPI()
    {
        try {
            $rol = new Rol($_POST);
            $resultado = $rol->crear();

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
        $rol_nombre = $_GET['rol_nombre'] ?? '';

        $sql = "SELECT * FROM roles WHERE rol_situacion = 1 ";
        if ($rol_nombre != '') {
            $rol_nombre = strtolower($rol_nombre);
            $sql .= " AND LOWER(rol_nombre) LIKE '%$rol_nombre%' ";
        }

        try {

            $roles = Rol::fetchArray($sql);

            echo json_encode($roles);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
}