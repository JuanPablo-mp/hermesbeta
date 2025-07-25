<?php

class ControladorTrazabilidadEquipos{
    static public function ctrMostrarTrazabilidadEquipos($item, $valor){
    $tabla = "trazabilidad_equipos";
    
    $respuesta = ModeloTrazabilidadEquipos::mdlMTrazabilidadObtenerEquipo($tabla, $item, $valor);
    error_log(print_r($respuesta, true));
    return $respuesta;
}
}