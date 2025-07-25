<?php

require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/sedes.controlador.php";
require_once "controladores/fichas.controlador.php";
require_once "controladores/roles.controlador.php";
require_once "controladores/permisos.controlador.php";
require_once "controladores/trazabilidad_equipos.controlador.php";
require_once "controladores/modulos.controlador.php";
require_once "controladores/autorizaciones.controlador.php";
require_once "controladores/equipos.controlador.php";
require_once "controladores/reportes_equipos.controlador.php";
require_once "controladores/solicitudes.controlador.php";
require_once "controladores/devoluciones.controlador.php";
require_once "controladores/mantenimiento.controlador.php";
require_once "controladores/ubicaciones.controlador.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/estados.controlador.php";
require_once "controladores/salidas.controlador.php";
require_once "controladores/notificaciones.controlador.php";
require_once 'controladores/inicio.controlador.php';



require_once "controladores/validacion.controlador.php";

require_once "modelos/usuarios.modelo.php";
require_once "modelos/sedes.modelo.php";
require_once "modelos/fichas.modelo.php";
require_once "modelos/roles.modelo.php";
require_once "modelos/permisos.modelo.php";
require_once "modelos/modulos.modelo.php";
require_once "modelos/autorizaciones.modelo.php";
require_once "modelos/equipos.modelo.php";
require_once "modelos/reportes_equipos.modelo.php";
require_once "modelos/trazabilidad_equipos.modelo.php";
require_once "modelos/solicitudes.modelo.php";
require_once "modelos/devoluciones.modelo.php";
require_once "modelos/mantenimiento.modelo.php";
require_once "modelos/ubicaciones.modelo.php";
require_once "modelos/categorias.modelo.php";
require_once "modelos/estados.modelo.php";
require_once "modelos/salidas.modelo.php";
require_once "modelos/notificaciones.modelo.php";
require_once 'modelos/inicio.modelo.php';






$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();