<?php

include_once "conexion.php";

class ModeloInicio
{

    public static function mdlObtenerPrestamosPorDia($tipo)
    {
        $conexion = Conexion::conectar();

        if ($tipo == 'anterior') {
            $sql = "SELECT 
                    ELT(WEEKDAY(fecha_solicitud)+1, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo') AS dia,
                    COUNT(*) AS cantidad
                FROM prestamos
                WHERE WEEK(fecha_solicitud, 1) = WEEK(CURDATE(), 1) - 1
                  AND YEAR(fecha_solicitud) = YEAR(CURDATE())
                GROUP BY dia
                ORDER BY FIELD(dia, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo')";

        } else {
            $sql = "SELECT 
                    ELT(WEEKDAY(fecha_solicitud)+1, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo') AS dia,
                    COUNT(*) AS cantidad
                FROM prestamos
                WHERE WEEK(fecha_solicitud, 1) = WEEK(CURDATE(), 1)
                  AND YEAR(fecha_solicitud) = YEAR(CURDATE())
                GROUP BY dia
                ORDER BY FIELD(dia, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo')";

        }

        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function mdlObtenerPrestamosPorEstado()
    {
        $sql = "SELECT 
                    estado_prestamo,
                    COUNT(*) AS cantidad
                    FROM prestamos
                    GROUP BY estado_prestamo";

        $stmt = Conexion::conectar()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function mdlObtenerEstadosEquipos($tabla)
    {
        try {
            $stmt = Conexion::conectar()->prepare("SELECT es.estado, COUNT(*) as cantidad 
                                                FROM $tabla eq
                                                INNER JOIN estados es ON eq.id_estado = es.id_estado GROUP BY es.estado");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            $stmt = null;
        }
    }
    //grafica Franco
 static public function mdlContarUsuariosPorGenero($codigoFicha)
    {
        $tablaUsuarios = "usuarios";
        $tablaAprendices = "aprendices_ficha";
        $tablaFichas = "fichas";

        $db = Conexion::conectar();

        $sql = "SELECT 
                u.genero,
                f.descripcion AS nombre_ficha,
                COUNT(*) as cantidad
            FROM $tablaUsuarios u
            INNER JOIN $tablaAprendices af ON u.id_usuario = af.id_usuario
            INNER JOIN $tablaFichas f ON af.id_ficha = f.id_ficha
            WHERE f.codigo = :codigoFicha
            GROUP BY u.genero";
            

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":codigoFicha", $codigoFicha, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
 
}




