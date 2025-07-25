<?php
require_once "../modelos/mantenimiento.modelo.php";

if (isset($_POST["idMantenimiento"]) && isset($_POST["gravedad"]) && isset($_POST["detalles"])) {
    $idMantenimiento = $_POST["idMantenimiento"];
    $gravedad = $_POST["gravedad"];
    $detalles = $_POST["detalles"];

    $respuesta = ModeloMantenimiento::mdlFinalizarMantenimiento($idMantenimiento, $gravedad, $detalles);

    echo $respuesta;
}