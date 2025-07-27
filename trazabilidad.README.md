# Trazabilidad de equipos

Este archivo _README_ contiene los triggers a ejecutar para la trazabilidad de los equipos. Ejecutar uno por uno en su respectiva bd local:

## TRIGGER 1:

```sql
CREATE TRIGGER `TRAZABILIDAD_after_insert_equipo_1` AFTER INSERT ON `equipos`
 FOR EACH ROW BEGIN
    DECLARE v_responsable_nombre VARCHAR(255);
    DECLARE v_ubicacion_nombre VARCHAR(255);
    DECLARE v_descripcion_html TEXT;
    DECLARE v_titulo_trazabilidad VARCHAR(255);
    DECLARE v_icono_html TEXT;

    -- Obtener el nombre del cuentadante (responsable)
    -- Asumiendo que tienes una tabla 'usuarios' con 'id_usuario' y 'nombre'
    SELECT CONCAT(nombre, ' ', apellido) INTO v_responsable_nombre
    FROM usuarios
    WHERE id_usuario = NEW.cuentadante_id;

    -- Obtener el nombre de la ubicación
    -- Asumiendo que tienes una tabla 'ubicaciones' con 'id_ubicacion' y 'nombre_ubicacion'
    SELECT nombre INTO v_ubicacion_nombre
    FROM ubicaciones
    WHERE ubicacion_id = NEW.ubicacion_id;

    -- Construir la descripción HTML
    SET v_descripcion_html = CONCAT(
        '<div class="timeline-body">',
        '<strong>Equipo:</strong> ', NEW.descripcion, '<br>', -- Asumo que NEW.descripcion es el nombre del equipo
        '<strong>Etiqueta:</strong> ', NEW.etiqueta, '<br>',
        '<strong>Ubicación:</strong> ', v_ubicacion_nombre, '<br>',
        '<strong>Responsable:</strong> ', v_responsable_nombre,
        '</div>'
    );

    -- Definir el título y el icono
    SET v_titulo_trazabilidad = 'Se agregó como nuevo equipo';
    SET v_icono_html = '<i class="fas fa-laptop-medical bg-blue"></i>';

    -- Insertar en la tabla trazabilidad_equipos
    INSERT INTO trazabilidad_equipos (equipo_id, descripcion, icono, fecha_accion, titulo)
    VALUES (NEW.equipo_id, v_descripcion_html, v_icono_html, NOW(), v_titulo_trazabilidad);

END
```
## TRIGGER 2:

```sql
CREATE TRIGGER `TRAZABILIDAD_cambioCuent_edicionEquipo_cambioUb_2` AFTER UPDATE ON `equipos`
 FOR EACH ROW BEGIN
    DECLARE v_responsable_nombre_nuevo VARCHAR(100);
    DECLARE v_responsable_nombre_antiguo VARCHAR(100);
    DECLARE v_ubicacion_actual_nombre VARCHAR(100);   -- Para la ubicación actual del equipo (NEW)
    DECLARE v_ubicacion_anterior_nombre VARCHAR(100); -- Para la ubicación antigua del equipo (OLD)
    DECLARE v_ubicacion_nueva_nombre VARCHAR(100);    -- Para la nueva ubicación del equipo (NEW)
    DECLARE v_descripcion_html TEXT;
    DECLARE v_responsable_antiguo_rol VARCHAR(50);
    DECLARE v_responsable_nuevo_rol VARCHAR(50);
    DECLARE v_titulo_trazabilidad VARCHAR(100);
    DECLARE v_icono_html TEXT;

    -- 1. Lógica para el CAMBIO DE CUENTADANTE (tiene la máxima prioridad)
    IF NEW.cuentadante_id <> OLD.cuentadante_id THEN

        -- Obtener el nombre completo del NUEVO cuentadante (responsable)
        SELECT CONCAT(nombre, ' ', apellido) INTO v_responsable_nombre_nuevo
        FROM usuarios
        WHERE id_usuario = NEW.cuentadante_id;

        -- Obtener el nombre completo del ANTIGUO cuentadante (responsable)
        SELECT CONCAT(nombre, ' ', apellido) INTO v_responsable_nombre_antiguo
        FROM usuarios
        WHERE id_usuario = OLD.cuentadante_id;

        -- Obtener el rol del ANTIGUO cuentadante
        SELECT r.nombre_rol INTO v_responsable_antiguo_rol
        FROM usuarios u
        JOIN usuario_rol ur ON u.id_usuario = ur.id_usuario
        JOIN roles r ON ur.id_rol = r.id_rol
        WHERE u.id_usuario = OLD.cuentadante_id;

        -- Obtener el rol del NUEVO cuentadante
        SELECT r.nombre_rol INTO v_responsable_nuevo_rol
        FROM usuarios u
        JOIN usuario_rol ur ON u.id_usuario = ur.id_usuario
        JOIN roles r ON ur.id_rol = r.id_rol
        WHERE u.id_usuario = NEW.cuentadante_id;

        -- Obtener el nombre de la ubicación actual del equipo para la descripción del traspaso
        SELECT nombre INTO v_ubicacion_actual_nombre
        FROM ubicaciones
        WHERE ubicacion_id = NEW.ubicacion_id;

        -- Construir la descripción HTML detallando el traspaso, incluyendo los roles
        SET v_descripcion_html = CONCAT(
            '<div class="timeline-body">',
            '<strong>Cuentadante anterior:</strong> ', IFNULL(v_responsable_nombre_antiguo, 'N/A'), ' (Rol: ', IFNULL(v_responsable_antiguo_rol, 'N/A'), ')<br>',
            '<strong>Cuentadante nuevo:</strong> ', IFNULL(v_responsable_nombre_nuevo, 'N/A'), ' (Rol: ', IFNULL(v_responsable_nuevo_rol, 'N/A'), ')',
            '</div>'
        );

        -- Definir el título y el icono para el traspaso de cuentadante
        SET v_titulo_trazabilidad = CONCAT('Se traspasó el equipo a un nuevo cuentadante: ', NEW.descripcion);
        SET v_icono_html = '<i class="fas fa-user-edit bg-purple"></i>';

        -- Insertar el registro de trazabilidad para el traspaso
        INSERT INTO trazabilidad_equipos (equipo_id, descripcion, icono, fecha_accion, titulo)
        VALUES (NEW.equipo_id, v_descripcion_html, v_icono_html, NOW(), v_titulo_trazabilidad);

    -- 2. Lógica para el CAMBIO DE UBICACIÓN (segunda prioridad)
    -- Se ejecuta si el cuentadante_id NO cambió, pero la ubicacion_id SÍ
    ELSEIF NEW.ubicacion_id <> OLD.ubicacion_id THEN

        -- OBTENIENDO LA UBICACIÓN VIEJA (OPTIMIZADO)
        SELECT nombre INTO v_ubicacion_anterior_nombre
        FROM ubicaciones
        WHERE ubicacion_id = OLD.ubicacion_id;

        -- OBTENIENDO LA UBICACIÓN NUEVA (OPTIMIZADO)
        SELECT nombre INTO v_ubicacion_nueva_nombre
        FROM ubicaciones
        WHERE ubicacion_id = NEW.ubicacion_id;

        -- Construir la descripción HTML mostrando solo las ubicaciones
        SET v_descripcion_html = CONCAT(
            '<div class="timeline-body">',
            '<strong>Anterior ubicación:</strong> ', IFNULL(v_ubicacion_anterior_nombre, 'N/A'), '<br>',
            '<strong>Nueva ubicación:</strong> ', IFNULL(v_ubicacion_nueva_nombre, 'N/A'),
            '</div>'
        );

        -- Definir el título y el icono para la actualización de la ubicación
        SET v_titulo_trazabilidad = CONCAT('Se actualizó la ubicación del equipo: ', NEW.descripcion);
        SET v_icono_html = '<i class="fas fa-exchange-alt bg-cyan"></i>';

        -- Insertar el registro de trazabilidad para el cambio de ubicación
        INSERT INTO trazabilidad_equipos (equipo_id, descripcion, icono, fecha_accion, titulo)
        VALUES (NEW.equipo_id, v_descripcion_html, v_icono_html, NOW(), v_titulo_trazabilidad);

    -- 3. Lógica para ACTUALIZACIONES GENERALES (tercera prioridad)
    -- Se ejecuta si NO hubo cambio de cuentadante NI de ubicación, pero otros campos sí
    ELSEIF NEW.descripcion <> OLD.descripcion OR
           NEW.etiqueta <> OLD.etiqueta OR
           NEW.categoria_id <> OLD.categoria_id THEN

        -- Obtener el nombre del responsable y la ubicación actual para la descripción general
        SELECT CONCAT(nombre, ' ', apellido) INTO v_responsable_nombre_nuevo
        FROM usuarios
        WHERE id_usuario = NEW.cuentadante_id;

        SELECT nombre INTO v_ubicacion_actual_nombre
        FROM ubicaciones
        WHERE ubicacion_id = NEW.ubicacion_id;

        -- Construir la descripción HTML para la actualización general
        SET v_descripcion_html = CONCAT(
            '<div class="timeline-body">',
            '<strong>Equipo:</strong> ', NEW.descripcion, '<br>',
            '<strong>Etiqueta:</strong> ', NEW.etiqueta, '<br>',
            '<strong>Ubicación:</strong> ', IFNULL(v_ubicacion_actual_nombre, 'N/A'), '<br>',
            '<strong>Responsable:</strong> ', IFNULL(v_responsable_nombre_nuevo, 'N/A'),
            '</div>'
        );

        -- Definir el título y el icono para la actualización general
        SET v_titulo_trazabilidad = CONCAT('Se actualizaron los datos del equipo: ', NEW.descripcion);
        SET v_icono_html = '<i class="fas fa-edit bg-yellow"></i>';

        -- Insertar el registro de trazabilidad para la actualización general
        INSERT INTO trazabilidad_equipos (equipo_id, descripcion, icono, fecha_accion, titulo)
        VALUES (NEW.equipo_id, v_descripcion_html, v_icono_html, NOW(), v_titulo_trazabilidad);

    END IF; -- Fin del IF principal

END
```
## TRIGGER 3:

```sql
CREATE TRIGGER `TRAZABILIDAD_equipo_estado_disponible_3` AFTER UPDATE ON `equipos`
 FOR EACH ROW BEGIN
    DECLARE v_responsable_nombre VARCHAR(255);
    DECLARE v_ubicacion_nombre VARCHAR(255);
    DECLARE v_estado_anterior VARCHAR(45);
    DECLARE v_descripcion_html TEXT;
    DECLARE v_titulo_trazabilidad VARCHAR(255);
    DECLARE v_icono_html TEXT;

    -- Verificar si el estado cambió hacia "Disponible"
    IF OLD.id_estado <> NEW.id_estado AND 
       (SELECT estado FROM estados WHERE id_estado = NEW.id_estado) = 'Disponible' THEN

        -- Obtener el nombre del estado anterior
        SELECT estado INTO v_estado_anterior
        FROM estados 
        WHERE id_estado = OLD.id_estado;

        -- Obtener el nombre del cuentadante actual
        SELECT CONCAT(nombre, ' ', apellido) INTO v_responsable_nombre
        FROM usuarios
        WHERE id_usuario = NEW.cuentadante_id;

        -- Obtener el nombre de la ubicación actual
        SELECT nombre INTO v_ubicacion_nombre
        FROM ubicaciones
        WHERE ubicacion_id = NEW.ubicacion_id;

        -- Construir la descripción HTML
        SET v_descripcion_html = CONCAT(
            '<div class="timeline-body">',
            '<strong>Equipo:</strong> ', NEW.descripcion, '<br>',
            '<strong>Etiqueta:</strong> ', IFNULL(NEW.etiqueta, 'N/A'), '<br>',
            '<strong>Estado anterior:</strong> ', IFNULL(v_estado_anterior, 'N/A'), '<br>',
            '<strong>Estado actual:</strong> Disponible<br>',
            '<strong>Ubicación:</strong> ', IFNULL(v_ubicacion_nombre, 'N/A'), '<br>',
            '<strong>Responsable:</strong> ', IFNULL(v_responsable_nombre, 'N/A'),
            '</div>'
        );

        -- Definir el título y el icono
        SET v_titulo_trazabilidad = CONCAT('Equipo disponible: ', NEW.descripcion);
        SET v_icono_html = '<i class="fas fa-check-circle bg-success"></i>';

        -- Insertar en la tabla trazabilidad_equipos
        INSERT INTO trazabilidad_equipos (equipo_id, descripcion, icono, fecha_accion, titulo)
        VALUES (NEW.equipo_id, v_descripcion_html, v_icono_html, NOW(), v_titulo_trazabilidad);

    END IF;
END
```
## TRIGGER 4:

```sql
CREATE TRIGGER `TRAZABILIDAD_prestamo_equipo_4` AFTER INSERT ON `detalle_prestamo`
 FOR EACH ROW BEGIN
    DECLARE v_usuario_nombre VARCHAR(100);
    DECLARE v_tipo_prestamo ENUM('Inmediato','Reservado');
    DECLARE v_fecha_inicio DATETIME;
    DECLARE v_fecha_fin DATETIME;
    DECLARE v_motivo VARCHAR(200);
    DECLARE v_equipo_descripcion VARCHAR(100);
    DECLARE v_ubicacion_nombre VARCHAR(100);
    DECLARE v_descripcion_html TEXT;
    DECLARE v_titulo_trazabilidad VARCHAR(100);
    DECLARE v_icono_html TEXT;

    -- Obtener información del préstamo y usuario
    SELECT 
        p.tipo_prestamo,
        p.fecha_inicio,
        p.fecha_fin,
        p.motivo,
        CONCAT(u.nombre, ' ', u.apellido)
    INTO 
        v_tipo_prestamo,
        v_fecha_inicio,
        v_fecha_fin,
        v_motivo,
        v_usuario_nombre
    FROM prestamos p
    JOIN usuarios u ON p.usuario_id = u.id_usuario
    WHERE p.id_prestamo = NEW.id_prestamo;

    -- Obtener información del equipo y ubicación
    SELECT 
        e.descripcion,
        ub.nombre
    INTO 
        v_equipo_descripcion,
        v_ubicacion_nombre
    FROM equipos e
    LEFT JOIN ubicaciones ub ON e.ubicacion_id = ub.ubicacion_id
    WHERE e.equipo_id = NEW.equipo_id;

    -- Determinar título e ícono según el tipo de préstamo
    IF v_tipo_prestamo = 'Inmediato' THEN
        SET v_titulo_trazabilidad = CONCAT('Préstamo inmediato: ', v_equipo_descripcion);
        SET v_icono_html = '<i class="fas fa-handshake bg-green"></i>';
        
        -- Descripción para préstamo inmediato (dentro de la sede)
        SET v_descripcion_html = CONCAT(
            '<div class="timeline-body">',
            '<strong>Tipo de préstamo:</strong> Inmediato (Dentro de la sede)<br>',
            '<strong>Usuario:</strong> ', IFNULL(v_usuario_nombre, 'N/A'), '<br>',
            '<strong>Ubicación:</strong> ', IFNULL(v_ubicacion_nombre, 'N/A'), '<br>',
            '<strong>Fecha inicio:</strong> ', DATE_FORMAT(v_fecha_inicio, '%d/%m/%Y'), '<br>',
            '<strong>Fecha fin:</strong> ', DATE_FORMAT(v_fecha_fin, '%d/%m/%Y'), '<br>',
            '<strong>Motivo:</strong> ', IFNULL(v_motivo, 'N/A'),
            '</div>'
        );
        
    ELSEIF v_tipo_prestamo = 'Reservado' THEN
        SET v_titulo_trazabilidad = CONCAT('Préstamo reservado - Salida: ', v_equipo_descripcion);
        SET v_icono_html = '<i class="fas fa-sign-out-alt bg-orange"></i>';
        
        -- Descripción para préstamo reservado (salida de la sede)
        SET v_descripcion_html = CONCAT(
            '<div class="timeline-body">',
            '<strong>Tipo de préstamo:</strong> Reservado (Salida de la sede)<br>',
            '<strong>Usuario:</strong> ', IFNULL(v_usuario_nombre, 'N/A'), '<br>',
            '<strong>Ubicación origen:</strong> ', IFNULL(v_ubicacion_nombre, 'N/A'), '<br>',
            '<strong>Fecha inicio:</strong> ', DATE_FORMAT(v_fecha_inicio, '%d/%m/%Y'), '<br>',
            '<strong>Fecha fin:</strong> ', DATE_FORMAT(v_fecha_fin, '%d/%m/%Y'), '<br>',
            '<strong>Motivo:</strong> ', IFNULL(v_motivo, 'N/A'),
            '</div>'
        );
    END IF;

    -- Insertar en trazabilidad_equipos
    INSERT INTO trazabilidad_equipos (
        equipo_id, 
        titulo, 
        descripcion, 
        icono, 
        fecha_accion
    ) VALUES (
        NEW.equipo_id, 
        v_titulo_trazabilidad, 
        v_descripcion_html, 
        v_icono_html, 
        NOW()
    );

END

```
## TRIGGER 5:

```sql
CREATE TRIGGER `TRAZABILIDAD_mantenimiento_equipo_5` AFTER INSERT ON `mantenimiento`
 FOR EACH ROW BEGIN
    DECLARE v_equipo_descripcion VARCHAR(100);
    DECLARE v_equipo_etiqueta VARCHAR(50);
    DECLARE v_ubicacion_nombre VARCHAR(100);
    DECLARE v_responsable_nombre VARCHAR(255);
    DECLARE v_detalles_mantenimiento TEXT;
    DECLARE v_gravedad_mantenimiento VARCHAR(50);
    DECLARE v_tipo_mantenimiento VARCHAR(50);
    DECLARE v_descripcion_html TEXT;
    DECLARE v_titulo_trazabilidad VARCHAR(255);
    DECLARE v_icono_html TEXT;

    -- 1. Obtener detalles del equipo afectado por el mantenimiento
    SELECT
        e.descripcion,
        e.etiqueta,
        u.nombre,        -- Nombre de la ubicación
        CONCAT(usr.nombre, ' ', usr.apellido) -- Nombre completo del cuentadante
    INTO
        v_equipo_descripcion,
        v_equipo_etiqueta,
        v_ubicacion_nombre,
        v_responsable_nombre
    FROM
        equipos e
    JOIN
        ubicaciones u ON e.ubicacion_id = u.ubicacion_id
    JOIN
        usuarios usr ON e.cuentadante_id = usr.id_usuario
    WHERE
        e.equipo_id = NEW.equipo_id;

    -- 2. Obtener detalles específicos del mantenimiento del registro recién insertado
    SET v_detalles_mantenimiento = NEW.detalles;
    SET v_gravedad_mantenimiento = NEW.gravedad;
    -- 3. Construir la descripción HTML para la trazabilidad
    SET v_descripcion_html = CONCAT(
        '<div class="timeline-body">',
        '<strong>Equipo:</strong> ', IFNULL(v_equipo_descripcion, 'N/A'), '<br>',
        '<strong>Etiqueta:</strong> ', IFNULL(v_equipo_etiqueta, 'N/A'), '<br>',
        '<strong>Ubicación actual:</strong> ', IFNULL(v_ubicacion_nombre, 'N/A'), '<br>',
        '<strong>Cuentadante actual:</strong> ', IFNULL(v_responsable_nombre, 'N/A'), '<br>',
        '<strong>Detalles de mantenimiento:</strong> ', IFNULL(v_detalles_mantenimiento, 'N/A'), '<br>',
        '<strong>Gravedad:</strong> ', IFNULL(v_gravedad_mantenimiento, 'N/A'),
        '</div>'
    );

    -- 4. Definir el título y el icono para el evento de mantenimiento
    SET v_titulo_trazabilidad = CONCAT('Equipo en Mantenimiento: ', IFNULL(v_equipo_descripcion, 'N/A'));
    SET v_icono_html = '<i class="fas fa-tools bg-orange"></i>';

    -- 5. Insertar el registro en la tabla trazabilidad_equipos
    INSERT INTO trazabilidad_equipos (equipo_id, descripcion, icono, fecha_accion, titulo)
    VALUES (NEW.equipo_id, v_descripcion_html, v_icono_html, NOW(), v_titulo_trazabilidad);

END
```

## TRIGGER 6:

```sql
CREATE TRIGGER `TRAZABILIDAD_mantenimiento_finalizado_trazabilidad_6` AFTER UPDATE ON `mantenimiento`
 FOR EACH ROW BEGIN
    DECLARE v_equipo_descripcion VARCHAR(100);
    DECLARE v_descripcion_html TEXT;
    DECLARE v_titulo_trazabilidad VARCHAR(100);
    DECLARE v_icono_html TEXT;

    -- Solo actuamos si la fecha_fin ha sido establecida (el mantenimiento ha terminado)
    -- y si antes no estaba establecida (para evitar múltiples registros por la misma finalización)
    IF NEW.fecha_fin IS NOT NULL AND OLD.fecha_fin IS NULL THEN

        -- Obtener la descripción del equipo afectado para usarla en la trazabilidad
        SELECT descripcion INTO v_equipo_descripcion
        FROM equipos
        WHERE equipo_id = NEW.equipo_id;

        -- Lógica para la gravedad 'ninguno'
        IF NEW.gravedad = 'ninguno' THEN
            SET v_descripcion_html = CONCAT(
                '<div class="timeline-body">',
                '<strong>Mantenimiento finalizado sin problemas.</strong><br>',
                '<strong>Detalles del mantenimiento:</strong> ', NEW.detalles,
                '</div>'
            );
            SET v_titulo_trazabilidad = CONCAT('Mantenimiento completado (Sin Problemas): ', v_equipo_descripcion);
            SET v_icono_html = '<i class="fas fa-check-circle bg-green"></i>'; -- Icono para éxito/sin problemas

            -- Insertar el registro de trazabilidad
            INSERT INTO trazabilidad_equipos (equipo_id, descripcion, icono, fecha_accion, titulo)
            VALUES (NEW.equipo_id, v_descripcion_html, v_icono_html, NOW(), v_titulo_trazabilidad);

        -- Lógica para la gravedad 'leve'
        ELSEIF NEW.gravedad = 'leve' THEN
            SET v_descripcion_html = CONCAT(
                '<div class="timeline-body">',
                '<strong>Mantenimiento finalizado con observaciones leves.</strong><br>',
                '<strong>Detalles del mantenimiento:</strong> ', NEW.detalles,
                '</div>'
            );
            SET v_titulo_trazabilidad = CONCAT('Mantenimiento completado (Leve): ', v_equipo_descripcion);
            SET v_icono_html = '<i class="fas fa-exclamation-triangle bg-orange"></i>'; -- Icono para advertencia/leve

            -- Insertar el registro de trazabilidad
            INSERT INTO trazabilidad_equipos (equipo_id, descripcion, icono, fecha_accion, titulo)
            VALUES (NEW.equipo_id, v_descripcion_html, v_icono_html, NOW(), v_titulo_trazabilidad);

        -- Lógica para la gravedad 'grave'
        ELSEIF NEW.gravedad = 'grave' THEN
            SET v_descripcion_html = CONCAT(
                '<div class="timeline-body">',
                '<strong>Mantenimiento finalizado con problemas graves.</strong><br>',
                '<strong>Detalles del mantenimiento:</strong> ', NEW.detalles,
                '</div>'
            );
            SET v_titulo_trazabilidad = CONCAT('Mantenimiento completado (Grave): ', v_equipo_descripcion);
            SET v_icono_html = '<i class="fas fa-exclamation-circle bg-red"></i>'; -- Icono para grave

            -- Insertar el registro de trazabilidad
            INSERT INTO trazabilidad_equipos (equipo_id, descripcion, icono, fecha_accion, titulo)
            VALUES (NEW.equipo_id, v_descripcion_html, v_icono_html, NOW(), v_titulo_trazabilidad);

        -- Lógica para la gravedad 'inrecuperable'
        ELSEIF NEW.gravedad = 'inrecuperable' THEN
            SET v_descripcion_html = CONCAT(
                '<div class="timeline-body">',
                '<strong>Equipo declarado inrecuperable después del mantenimiento.</strong><br>',
                '<strong>Detalles del mantenimiento:</strong> ', NEW.detalles,
                '</div>'
            );
            SET v_titulo_trazabilidad = CONCAT('Equipo Inrecuperable (Mantenimiento): ', v_equipo_descripcion);
            SET v_icono_html = '<i class="fas fa-times-circle bg-dark"></i>'; -- Icono para inrecuperable

            -- Insertar el registro de trazabilidad
            INSERT INTO trazabilidad_equipos (equipo_id, descripcion, icono, fecha_accion, titulo)
            VALUES (NEW.equipo_id, v_descripcion_html, v_icono_html, NOW(), v_titulo_trazabilidad);

        END IF; -- Fin del IF para NEW.gravedad

    END IF; -- Fin del IF para NEW.fecha_fin
END
```

## TRIGGER 7:

```sql
CREATE TRIGGER `TRAZABILIDAD_equipo_estado_almacen_7` AFTER UPDATE ON `equipos`
 FOR EACH ROW BEGIN
    DECLARE v_responsable_nombre VARCHAR(255);
    DECLARE v_ubicacion_nombre VARCHAR(255);
    DECLARE v_estado_anterior VARCHAR(45);
    DECLARE v_descripcion_html TEXT;
    DECLARE v_titulo_trazabilidad VARCHAR(255);
    DECLARE v_icono_html TEXT;
    
    -- Verificar si el estado cambió hacia "Almacén"
    IF OLD.id_estado <> NEW.id_estado AND 
       (SELECT estado FROM estados WHERE id_estado = NEW.id_estado) = 'Almacén' THEN
        
        -- Obtener el nombre del estado anterior
        SELECT estado INTO v_estado_anterior
        FROM estados 
        WHERE id_estado = OLD.id_estado;
        
        -- Obtener el nombre del cuentadante actual
        SELECT CONCAT(nombre, ' ', apellido) INTO v_responsable_nombre
        FROM usuarios
        WHERE id_usuario = NEW.cuentadante_id;
        
        -- Obtener el nombre de la ubicación actual
        SELECT nombre INTO v_ubicacion_nombre
        FROM ubicaciones
        WHERE ubicacion_id = NEW.ubicacion_id;
        
        -- Construir la descripción HTML
        SET v_descripcion_html = CONCAT(
            '<div class="timeline-body">',
            '<strong>Equipo:</strong> ', NEW.descripcion, '<br>',
            '<strong>Etiqueta:</strong> ', IFNULL(NEW.etiqueta, 'N/A'), '<br>',
            '<strong>Estado anterior:</strong> ', IFNULL(v_estado_anterior, 'N/A'), '<br>',
            '<strong>Estado actual:</strong> Almacén<br>',
            '<strong>Ubicación:</strong> ', IFNULL(v_ubicacion_nombre, 'N/A'), '<br>',
            '<strong>Responsable:</strong> ', IFNULL(v_responsable_nombre, 'N/A'),
            '</div>'
        );
        
        -- Definir el título y el icono
        SET v_titulo_trazabilidad = CONCAT('Equipo enviado a Almacén: ', NEW.descripcion);
        SET v_icono_html = '<i class="fas fa-warehouse bg-secondary"></i>';
        
        -- Insertar en la tabla trazabilidad_equipos
        INSERT INTO trazabilidad_equipos (equipo_id, descripcion, icono, fecha_accion, titulo)
        VALUES (NEW.equipo_id, v_descripcion_html, v_icono_html, NOW(), v_titulo_trazabilidad);
        
    END IF;
END
```

## TRIGGER 8:

```sql
CREATE TRIGGER `TRAZABILIDAD_equipo_estado_baja_8` AFTER UPDATE ON `equipos`
 FOR EACH ROW BEGIN
    DECLARE v_responsable_nombre VARCHAR(255);
    DECLARE v_ubicacion_nombre VARCHAR(255);
    DECLARE v_estado_anterior VARCHAR(45);
    DECLARE v_descripcion_html TEXT;
    DECLARE v_titulo_trazabilidad VARCHAR(255);
    DECLARE v_icono_html TEXT;
    
    -- Verificar si el estado cambió hacia "baja"
    IF OLD.id_estado <> NEW.id_estado AND 
       (SELECT estado FROM estados WHERE id_estado = NEW.id_estado) = 'baja' THEN
        
        -- Obtener el nombre del estado anterior
        SELECT estado INTO v_estado_anterior
        FROM estados 
        WHERE id_estado = OLD.id_estado;
        
        -- Obtener el nombre del cuentadante actual
        SELECT CONCAT(nombre, ' ', apellido) INTO v_responsable_nombre
        FROM usuarios
        WHERE id_usuario = NEW.cuentadante_id;
        
        -- Obtener el nombre de la ubicación actual
        SELECT nombre INTO v_ubicacion_nombre
        FROM ubicaciones
        WHERE ubicacion_id = NEW.ubicacion_id;
        
        -- Construir la descripción HTML
        SET v_descripcion_html = CONCAT(
            '<div class="timeline-body">',
            '<strong>Equipo:</strong> ', NEW.descripcion, '<br>',
            '<strong>Etiqueta:</strong> ', IFNULL(NEW.etiqueta, 'N/A'), '<br>',
            '<strong>Estado anterior:</strong> ', IFNULL(v_estado_anterior, 'N/A'), '<br>',
            '<strong>Estado actual:</strong> Baja<br>',
            '<strong>Última ubicación:</strong> ', IFNULL(v_ubicacion_nombre, 'N/A'), '<br>',
            '<strong>Último responsable:</strong> ', IFNULL(v_responsable_nombre, 'N/A'),
            '</div>'
        );
        
        -- Definir el título y el icono
        SET v_titulo_trazabilidad = CONCAT('Equipo dado de baja: ', NEW.descripcion);
        SET v_icono_html = '<i class="fas fa-times-circle bg-danger"></i>';
        
        -- Insertar en la tabla trazabilidad_equipos
        INSERT INTO trazabilidad_equipos (equipo_id, descripcion, icono, fecha_accion, titulo)
        VALUES (NEW.equipo_id, v_descripcion_html, v_icono_html, NOW(), v_titulo_trazabilidad);
        
    END IF;
END
```

## TRIGGER 9:

```sql
CREATE TRIGGER `TRAZABILIDAD_equipo_estado_formacion_9` AFTER UPDATE ON `equipos`
 FOR EACH ROW BEGIN
    DECLARE v_responsable_nombre VARCHAR(255);
    DECLARE v_ubicacion_nombre VARCHAR(255);
    DECLARE v_estado_anterior VARCHAR(45);
    DECLARE v_descripcion_html TEXT;
    DECLARE v_titulo_trazabilidad VARCHAR(255);
    DECLARE v_icono_html TEXT;
    
    -- Verificar si el estado cambió hacia "Formación"
    IF OLD.id_estado <> NEW.id_estado AND 
       (SELECT estado FROM estados WHERE id_estado = NEW.id_estado) = 'Formación' THEN
        
        -- Obtener el nombre del estado anterior
        SELECT estado INTO v_estado_anterior
        FROM estados 
        WHERE id_estado = OLD.id_estado;
        
        -- Obtener el nombre del cuentadante actual
        SELECT CONCAT(nombre, ' ', apellido) INTO v_responsable_nombre
        FROM usuarios
        WHERE id_usuario = NEW.cuentadante_id;
        
        -- Obtener el nombre de la ubicación actual
        SELECT nombre INTO v_ubicacion_nombre
        FROM ubicaciones
        WHERE ubicacion_id = NEW.ubicacion_id;
        
        -- Construir la descripción HTML
        SET v_descripcion_html = CONCAT(
            '<div class="timeline-body">',
            '<strong>Equipo:</strong> ', NEW.descripcion, '<br>',
            '<strong>Etiqueta:</strong> ', IFNULL(NEW.etiqueta, 'N/A'), '<br>',
            '<strong>Estado anterior:</strong> ', IFNULL(v_estado_anterior, 'N/A'), '<br>',
            '<strong>Estado actual:</strong> Formación<br>',
            '<strong>Ubicación:</strong> ', IFNULL(v_ubicacion_nombre, 'N/A'), '<br>',
            '<strong>Responsable:</strong> ', IFNULL(v_responsable_nombre, 'N/A'),
            '</div>'
        );
        
        -- Definir el título y el icono
        SET v_titulo_trazabilidad = CONCAT('Equipo asignado para Formación: ', NEW.descripcion);
        SET v_icono_html = '<i class="fas fa-chalkboard-teacher bg-info"></i>';
        
        -- Insertar en la tabla trazabilidad_equipos
        INSERT INTO trazabilidad_equipos (equipo_id, descripcion, icono, fecha_accion, titulo)
        VALUES (NEW.equipo_id, v_descripcion_html, v_icono_html, NOW(), v_titulo_trazabilidad);
        
    END IF;
END
```