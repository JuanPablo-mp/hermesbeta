<?php

require_once "conexion.php";

class ModeloPermisos
{

    static public function mdlActualizarPermisos($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_rol = :id_rol WHERE id_permiso = :id_permiso");

        $stmt->bindParam(":id_rol", $datos["id_rol"], PDO::PARAM_INT);
        $stmt->bindParam(":id_permiso", $datos["id_permiso"], PDO::PARAM_INT);

        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
        $stmt = null;
    }


    /*=============================================
    MOSTRAR PERMISOS
    =============================================*/
    static public function mdlMostrarPermisos($item, $valor){

        $stmt = Conexion::conectar()->prepare("SELECT 
                                                    r.id_rol,
                                                    r.nombre_rol AS nombre_rol,
                                                    r.descripcion AS descripcion_rol,
                                                    m.nombre AS modulo,
                                                    p.nombre AS permiso,
                                                    p.id_permiso,
                                                    p.descripcion AS descripcion_permiso
                                                FROM 
                                                    roles r
                                                    JOIN rol_permiso rp ON r.id_rol = rp.id_rol
                                                    JOIN permisos p ON rp.id_permiso = p.id_permiso
                                                    JOIN modulos m ON p.id_modulo = m.id_modulo
                                                WHERE 
                                                    r.id_rol = :id_rol");
  

        $stmt->bindParam(":id_rol", $valor, PDO::PARAM_INT);

        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
        $stmt = null;
    }

    static public function mdlTraerPermisos($tabla){

        $stmt = Conexion::conectar()->prepare("SELECT   p.id_permiso, p.nombre AS nombre_permiso, 
                                                        p.descripcion AS descripcion_permiso,  m.nombre AS nombre_modulo,
                                                        m.id_modulo
                                                        FROM permisos p
                                                        JOIN modulos m ON p.id_modulo = m.id_modulo 
                                                        WHERE p.id_permiso != 29
                                                        ORDER BY m.id_modulo");        

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
        $stmt = null;
    }

    static public function mdlEliminarPermisos($tabla, $idRol)
    {
        try {
            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_rol = :id_rol");
            $stmt->bindParam(":id_rol", $idRol, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "ok";
            } else {
                return "error";
            }
        } catch (PDOException $e) {
            return "error: " . $e->getMessage();
        } finally {
            $stmt->closeCursor();
            $stmt = null;
        }
    }

    static public function mdlAgregarPermiso($tabla, $idRol, $idPermiso)
    {
        try {
            $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_rol, id_permiso) VALUES (:id_rol, :id_permiso)");
            $stmt->bindParam(":id_rol", $idRol, PDO::PARAM_INT);
            $stmt->bindParam(":id_permiso", $idPermiso, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "ok";
            } else {
                return "error";
            }
        } catch (PDOException $e) {
            return "error: " . $e->getMessage();
        } finally {
            $stmt->closeCursor();
            $stmt = null;
        }
    }
}