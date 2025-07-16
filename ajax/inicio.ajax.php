<?php
require_once "../controladores/inicio.controlador.php";
require_once "../modelos/inicio.modelo.php";

class AjaxInicio{

    static public function ajaxObtenerGraficos(){
        $respuesta = ControladorInicio::ctrObtenerEstadosEquipos();
        echo json_encode($respuesta);
        error_log(print_r($respuesta, true));
    }

    static public function ajaxObtenerPrestamosPorDia($tipo) {
        // Obtener datos del controlador
        $datos = ControladorInicio::ctrObtenerPrestamosPorDia($tipo);

        // Lista fija de días en orden
        $diasSemana = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];

        // Inicializar array con ceros
        $datosCompletos = [];
        foreach ($diasSemana as $dia) {
            $datosCompletos[$dia] = 0;
        }

        // Rellenar con los datos reales
        foreach ($datos as $dato) {
            $dia = $dato["dia"];
            $cantidad = $dato["cantidad"];
            $datosCompletos[$dia] = (int)$cantidad;
        }

        // Formatear para enviar como JSON
        $respuesta = [];
        foreach ($diasSemana as $dia) {
            $respuesta[] = ["dia" => $dia, "cantidad" => $datosCompletos[$dia]];
        }

        header('Content-Type: application/json');
        echo json_encode($respuesta);
        error_log(print_r($respuesta, true));
    }

    
}

if (isset($_POST["accion"])) {

    if ($_POST["accion"] === "obtenerGraficos") {
        AjaxInicio::ajaxObtenerGraficos();
    
    } else if ($_POST["accion"] === "obtenerPrestamosPorDia") {
        $tipo = $_POST["tipo"] ?? 'actual';
        AjaxInicio::ajaxObtenerPrestamosPorDia($tipo);
    }
}
