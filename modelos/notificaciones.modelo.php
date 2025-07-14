<?php

require_once "conexion.php";

class ModeloNotificaciones {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    /*=============================================
    LISTAR NOTIFICACIONES NO LEIDAS DE UN USUARIO
    =============================================*/
    static public function mdlListarNoLeidas($tabla, $usuario_id) {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT n.*, t.nombre AS tipo_evento_nombre, t.descripcion AS tipo_evento_descripcion, t.tipo_notificacion, t.prioridad FROM $tabla n INNER JOIN tipos_evento_notificacion t ON n.id_tipo_evento = t.id_tipo_evento WHERE id_usuario = :id_usuario AND leida = 0 ORDER BY fecha_creacion DESC");
        $stmt->bindParam(":id_usuario", $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*=============================================
    lISTAR NOTIFICACIONES LEIDAS 
    =============================================*/
    static public function mdlListarLeidas($tabla, $usuario_id) {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT n.*, t.nombre AS tipo_evento_nombre, t.descripcion AS tipo_evento_descripcion, t.tipo_notificacion, t.prioridad FROM $tabla n INNER JOIN tipos_evento_notificacion t ON n.id_tipo_evento = t.id_tipo_evento WHERE id_usuario = :id_usuario AND leida = 1 ORDER BY fecha_creacion DESC");
        $stmt->bindParam(":id_usuario", $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*=============================================
    MARCAR NOTIFICACION COMO LEIDA
    =============================================*/
    static public function mdlMarcarNotificacionLeida($tabla, $id_notificacion, $usuario_id) {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("UPDATE $tabla SET leida = 1, fecha_leida = NOW() WHERE id_notificaciones = :id_notificaciones AND id_usuario = :id_usuario");
        $stmt->bindParam(":id_notificaciones", $id_notificacion, PDO::PARAM_INT);
        $stmt->bindParam(":id_usuario", $usuario_id, PDO::PARAM_INT);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
    }

    /*=============================================
    LISTAR TODAS LAS NOTIFICACIONES 
    =============================================*/
    static public function mdlListarTodas($tabla, $usuario_id) {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT n.*, t.nombre AS tipo_evento_nombre, t.descripcion AS tipo_evento_descripcion, t.tipo_notificacion, t.prioridad FROM $tabla n INNER JOIN tipos_evento_notificacion t ON n.id_tipo_evento = t.id_tipo_evento WHERE n.id_usuario = :usuario_id ORDER BY n.fecha_creacion DESC");
        $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*=============================================
    MARCAR TODAS LAS NOTIFICACIONES COMO LEIDAS
    =============================================*/
        static public function mdlMarcarTodasComoLeidas($tabla, $usuario_id) {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("UPDATE $tabla SET leida = 1 WHERE id_usuario = :usuario_id AND leida = 0");
        $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    

    /*=============================================
    OBTENER DETALLES DE UNA NOTIFICACION
    =============================================*/
    static public function mdlObtenerDetallesNotificacion($tabla, $id_notificacion) {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT n.*, t.nombre AS tipo_evento_nombre, t.descripcion AS tipo_evento_descripcion, t.tipo_notificacion, t.prioridad FROM $tabla n INNER JOIN tipos_evento_notificacion t ON n.id_tipo_evento = t.id_tipo_evento WHERE id_notificaciones = :id_notificaciones");
        $stmt->bindParam(":id_notificaciones", $id_notificacion, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*=============================================
    ELIMINAR NOTIFICACION
    =============================================*/
    static public function mdlEliminarNotificacion($tabla, $id_notificacion){
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("DELETE FROM $tabla WHERE id_notificaciones = :id_notificaciones");
        $stmt->bindParam(":id_notificaciones", $id_notificacion, PDO::PARAM_INT);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
    }
}
