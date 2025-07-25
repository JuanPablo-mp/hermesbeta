<?php

require_once "conexion.php";

class ModeloMantenimiento
{
    // Mostrar mantenimientos
    static public function mdlMostrarMantenimientos($tabla, $item, $valor)
    {
        try {
            if ($item == null) {
                $stmt = Conexion::conectar()->prepare(
                    "SELECT 
                    m.id_mantenimiento,
                    e.equipo_id,
                    e.numero_serie,
                    e.etiqueta,
                    e.descripcion,
                    m.detalles,
                    m.gravedad,
                    u.nombre,
                    u.apellido,
                    u.condicion
                FROM 
                    mantenimiento m
                INNER JOIN 
                    equipos e ON m.equipo_id = e.equipo_id
                INNER JOIN
                    prestamos p ON m.id_prestamo = p.id_prestamo
                INNER JOIN
                    usuarios u ON p.usuario_id = u.id_usuario
                WHERE 
                    e.id_estado = 4;"
                );
                $stmt->execute();
                return $stmt->fetchAll();
            }
        } catch (PDOException $e) {
            return "error";
        } finally {
            $stmt = null;
        }
    }

    
    static public function mdlFinalizarMantenimiento($idMantenimiento, $gravedad, $detalles)
    {
        try {
            $db = Conexion::conectar();

            $stmt = $db->prepare(
                "SELECT m.equipo_id, p.usuario_id 
                 FROM mantenimiento m
                 LEFT JOIN prestamos p ON m.id_prestamo = p.id_prestamo
                 WHERE m.id_mantenimiento = :id_mantenimiento"
            );
            $stmt->bindParam(":id_mantenimiento", $idMantenimiento);
            $stmt->execute();
            $datosMantenimiento = $stmt->fetch(PDO::FETCH_ASSOC);

            $equipoId = $datosMantenimiento['equipo_id'];
            $usuarioId = $datosMantenimiento['usuario_id'];

            $stmt2 = $db->prepare(
                "UPDATE mantenimiento 
                 SET gravedad = :gravedad, 
                     detalles = :detalles,
                     fecha_fin = NOW() 
                 WHERE id_mantenimiento = :id_mantenimiento"
            );
            $stmt2->bindParam(":gravedad", $gravedad);
            $stmt2->bindParam(":detalles", $detalles);
            $stmt2->bindParam(":id_mantenimiento", $idMantenimiento);
            $stmt2->execute();

            $estadoEquipo = 1; 

            if ($gravedad == "ninguno") {
                $estadoEquipo = 1;
            } elseif ($gravedad == "leve") {
                $estadoEquipo = 1;
                if ($usuarioId) {
                    $stmt3 = $db->prepare(
                        "UPDATE usuarios 
                         SET condicion = 'advertido' 
                         WHERE id_usuario = :id_usuario"
                    );
                    $stmt3->bindParam(":id_usuario", $usuarioId);
                    $stmt3->execute();
                }
            } elseif ($gravedad == "grave") {
                $estadoEquipo = 8;
                if ($usuarioId) {
                    $stmt4 = $db->prepare(
                        "UPDATE usuarios 
                         SET condicion = 'penalizado' 
                         WHERE id_usuario = :id_usuario"
                    );
                    $stmt4->bindParam(":id_usuario", $usuarioId);
                    $stmt4->execute();
                }
            } elseif ($gravedad == "inrecuperable") {
                $estadoEquipo = 8;
            }

            $stmt5 = $db->prepare(
                "UPDATE equipos 
                 SET id_estado = :estado 
                 WHERE equipo_id = :equipo_id"
            );
            $stmt5->bindParam(":estado", $estadoEquipo);
            $stmt5->bindParam(":equipo_id", $equipoId);
            $stmt5->execute();

            return "ok";
        } catch (PDOException $e) {
            return "error";
        }
    }
}