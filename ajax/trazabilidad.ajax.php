<?php

require_once "../controladores/trazabilidad_equipos.controlador.php";
require_once "../modelos/trazabilidad_equipos.modelo.php";

class AjaxTrazabilidad{
    public $idEquipoTrazabilidad; //Id del equipo por su trazabilidad

    public function ajaxTrazabilidadEquipo(){
    $item = "equipo_id"; //Campo de la tabla por el cual haremos la búsqueda en la tabla de trazabilidad
    $valor = $this -> idEquipoTrazabilidad; //Trayendo el valor del idEquipoTrazabilidad desde el js

    $respuesta = ControladorTrazabilidadEquipos::ctrMostrarTrazabilidadEquipos($item, $valor);
    echo json_encode($respuesta);
    }
}

if(isset($_POST["idEquipoTrazabilidad"])){
    $idEquipoTrazabilidad = new AjaxTrazabilidad();
    $idEquipoTrazabilidad -> idEquipoTrazabilidad = $_POST["idEquipoTrazabilidad"];
    $idEquipoTrazabilidad -> ajaxTrazabilidadEquipo();
}