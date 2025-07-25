<?php

require_once "conexion.php";

class ModeloTrazabilidadEquipos{

    static public function mdlMTrazabilidadObtenerEquipo($tabla, $item, $valor){
    try {
        if($item != null){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY fecha_accion ASC");
            $stmt->bindParam(":".$item, $valor, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fecha_accion ASC");
            $stmt->execute();
            return $stmt->fetchAll();
        }
    } catch (Exception $e) {
        return array('error' => $e->getMessage());
    }
}
}
