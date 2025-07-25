<?php


class ControladorInicio
{

    public static function ctrObtenerPrestamosPorDia($tipo = 'actual')
    {
        return ModeloInicio::mdlObtenerPrestamosPorDia($tipo);

    }


    public static function ctrObtenerPrestamosPorEstado()
    {
        require_once "modelos/inicio.modelo.php";

        $modelo = new ModeloInicio();
        $resultado = $modelo->mdlObtenerPrestamosPorEstado();

        return $resultado;
    }

    public static function ctrObtenerEstadosEquipos() {
        $tabla = "equipos";
        $respuesta = ModeloInicio::mdlObtenerEstadosEquipos($tabla);
        return $respuesta;
    }
   // grafica Franco
  static public function ctrContarUsuariosPorGenero($codigoFicha)
    {
        $respuesta = ModeloInicio::mdlContarUsuariosPorGenero($codigoFicha);
        return $respuesta;

    
    }
}

