<?php
require_once "../controladores/inicio.controlador.php";
require_once "../modelos/inicio.modelo.php";
class AjaxInicio
{
    public $item;
    public $idFichaBarra;
    static public function ajaxObtenerGraficos()
    {
        $respuesta = ControladorInicio::ctrObtenerEstadosEquipos();
        echo json_encode($respuesta);
        error_log(print_r($respuesta, true));
    }

    static public function ajaxObtenerPrestamosPorDia($tipo)
    {
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
            $datosCompletos[$dia] = (int) $cantidad;
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
    //grafica Franco
public function ajaxUsuariosPorFicha()
    {
        $codigoFicha = $this->idFichaBarra;
        $respuesta = ControladorInicio::ctrContarUsuariosPorGenero($codigoFicha);

        // Inicializa conteo por género
        $hombres = 0;
        $mujeres = 0;
        $otros = 0;
        $total = 0;

        foreach ($respuesta as $dato) {
            switch (strtolower($dato['genero'])) {
                case '2':
                case 'hombre':
                    $hombres = (int) $dato['cantidad'];
                    break;
                case '1':
                case 'mujer':
                    $mujeres = (int) $dato['cantidad'];
                    break;
                default:
                    $otros = (int) $dato['cantidad'];
                    break;
            }
        }

        
        foreach ($respuesta as $fila) {
            $total += $fila['cantidad'];
        }

        echo json_encode([
            'hombres' => $hombres,
            'mujeres' => $mujeres,
            'otros' => $otros,
            'nombre_ficha' => $respuesta[0]['nombre_ficha'] ?? 'Sin nombre',
            'total' => $total
        ]);
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

if (isset($_POST['codigoFicha'])) {
    $codigo = $_POST['codigoFicha'];
    $ajaxInicio = new AjaxInicio();
    $ajaxInicio->idFichaBarra = $codigo;
    $ajaxInicio->ajaxUsuariosPorFicha();
}
