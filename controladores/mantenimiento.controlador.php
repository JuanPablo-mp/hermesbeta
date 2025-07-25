<?php

class ControladorMantenimiento{
	// Mostrar mantenimientos
	static public function ctrMostrarMantenimientos($item, $valor)
	{
		$tabla = "mantenimiento";
		$respuesta = ModeloMantenimiento::mdlMostrarMantenimientos($tabla, $item, $valor);
		return $respuesta;
	}

    static public function ctrFinalizarMantenimiento($idMantenimiento, $gravedad, $detalles) {
		return ModeloMantenimiento::mdlFinalizarMantenimiento($idMantenimiento, $gravedad, $detalles);
	}
    
}

