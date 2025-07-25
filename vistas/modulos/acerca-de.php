<div class="content-wrapper">
    <!-- Encabezado -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Acerca del Proyecto Hermes</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Contenido principal -->
    <section class="content">
        <div class="container-fluid">
            <!-- Sobre el proyecto -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>¿Qué es HERMES?</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="callout callout-success">
                                <p><strong>HERMES</strong> (Herramientas y Equipos Reservables para el Manejo Estratégico de Servicios) es un sistema interno diseñado para apoyar la formación en el <strong>SENA</strong>, facilitando el acceso organizado y responsable a los recursos necesarios en las prácticas formativas.</p>
                            </div>

                            <div class="callout callout-success">
                                <p>Permite gestionar el préstamo de herramientas, equipos y materiales utilizados en el desarrollo de actividades académicas, mostrando su disponibilidad, estado de préstamo y las normas de uso establecidas.</p>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-users mr-2"></i>¿Quiénes pueden usarlo?</h3>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"><i class="fas fa-user-tie mr-2"></i>Instructores y aprendices activos del SENA</li>
                                                <li class="list-group-item"><i class="fas fa-user-shield mr-2"></i>Personal autorizado de cada área formativa</li>
                                                <li class="list-group-item"><i class="fas fa-user-cog mr-2"></i>Coordinadores de ambiente y logística</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-exclamation-circle mr-2"></i>Recomendaciones importantes</h3>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"><i class="fas fa-check-circle text-success mr-2"></i>Revisa el estado del equipo antes de llevártelo</li>
                                                <li class="list-group-item"><i class="fas fa-check-circle text-success mr-2"></i>Entrega el material en la fecha y hora acordadas</li>
                                                <li class="list-group-item"><i class="fas fa-check-circle text-success mr-2"></i>Reporta cualquier daño o novedad al instructor o coordinador</li>
                                                <li class="list-group-item"><i class="fas fa-check-circle text-success mr-2"></i>El uso adecuado garantiza que más aprendices puedan beneficiarse</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info mt-4">
                                <h5><i class="icon fas fa-clock mr-2"></i>Horarios de atención de soporte de software</h5>
                                <p class="mb-0">Lunes a viernes: 7:00 a.m. – 12:00 m. | 1:00 p.m. – 5:00 p.m.</p>
                                <p class="mb-0">Oficina Mesa de Ayuda - Siempre dispuestos a mejorar con el apoyo de nuevos talentos técnicos.</p>
                                <p class="mb-0" style="text-decoration: underline;">*Promovemos el fortalecimiento del equipo técnico mediante la integración de aprendices SENA en procesos clave de soporte*</p>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de Desarrolladores -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-users-cog mr-2"></i>Equipo de Desarrollo</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php
                                $desarrolladores = [
                                    ["nombre" => "German Ramirez Ramirez", "rol" => "Product Owner", "foto" => "vistas/img/desarrolladores/grr.jpg", "github" => "https://github.com/GermanRz", "instagram" => "https://www.instagram.com/germanrzrz?igsh=MW56cngyNjNvNWw1NQ== "],
                                    ["nombre" => "Cristian Camilo Gomez Gonzalez", "rol" => "Líder del módulo de Devoluciones", "foto" => "vistas/img/desarrolladores/ccgg.jpg", "github" => "https://github.com/PatoTaactico", "instagram" => "https://www.instagram.com/criz._.ggku/"],
                                    ["nombre" => "Jhoan David Sinisterra Valencia", "rol" => "Líder del módulo de Equipos", "foto" => "vistas/img/desarrolladores/jdsv.jpg", "github" => "https://github.com/Davidjdsv", "instagram" => "https://www.instagram.com/davidjdsv_2509/"],
                                    ["nombre" => "Juan Diego Millán Arango", "rol" => "Líder del módulo de Usuarios", "foto" => "vistas/img/desarrolladores/jdma.jpg", "github" => "https://github.com/JUANDMILLAN", "instagram" => "https://www.instagram.com/arango_juan11?igsh=MXV4ZnR1ZDMxb2JnNQ%3D%3D&utm_source=qr"],
                                    ["nombre" => "Brayan Camilo Ospina Gonzalez", "rol" => "Líder del módulo de Autorizaciones", "foto" => "vistas/img/desarrolladores/bcog.jpg", "github" => "https://github.com/Br4nnnn", "instagram" => "https://www.instagram.com/bra.n_/"],
                                    ["nombre" => "Alonso Arboleda Obando", "rol" => "Líder del módulo de Solicitudes", "foto" => "vistas/img/desarrolladores/aao.jpg", "github" => "https://github.com/alojoarboleda2003", "instagram" => "https://www.instagram.com/alonsoarboledaobando?igsh=ZWNxcmV6YWVwZzY3"],
                                    ["nombre" => "Jack Esteban Ortiz Vásquez", "rol" => "Módulo de Autorizaciones", "foto" => "vistas/img/desarrolladores/jeov.jpg", "github" => "https://github.com/Estebjack-2004", "instagram" => "https://www.instagram.com/jack_raccoon?igsh=NnR2c2kzYjJqbjE= "],
                                    ["nombre" => "Nicolás Manzano Muriel", "rol" => "Módulo de Autorizaciones", "foto" => "vistas/img/desarrolladores/nmm.jpg", "github" => "https://github.com/Toizomo", "instagram" => "https://www.instagram.com/nic_romance/"],
                                    ["nombre" => "Alejandro Lozada Vera", "rol" => "Módulo de Usuarios", "foto" => "vistas/img/desarrolladores/alv.jpg", "github" => "https://github.com/alejandrovera14", "instagram" => "https://www.instagram.com/alejo.vera2?igsh=d2dma2lqMXBudHZq&utm_source=qr"],
                                    ["nombre" => "Santiago Franco Flórez", "rol" => "Módulo de Solicitudes", "foto" => "vistas/img/desarrolladores/sff.jpg", "github" => "https://github.com/sanfranco2002", "instagram" => "https://www.instagram.com/santi_franco2002?igsh=aWloejBlNTNoMjEw "],
                                    ["nombre" => "David Satizábal", "rol" => "Módulo de Equipos", "foto" => "vistas/img/desarrolladores/ds.jpg", "github" => "https://github.com/Davidsatizabal", "instagram" => "https://www.instagram.com/david.satizabal?igsh=ZGtjbGFudmFjamwx "],
                                    ["nombre" => "Juan Sebastián Velásquez Ortiz", "rol" => "Módulo de Salidas", "foto" => "vistas/img/desarrolladores/jsvo.jpg", "github" => "https://github.com/ortiz-000", "instagram" => ""],
                                    ["nombre" => "Jensen Ballén Banguera", "rol" => "Módulo de Solicitudes", "foto" => "vistas/img/desarrolladores/jbb.jpg", "github" => "https://github.com/jensen-ballen", "instagram" => "https://www.instagram.com/jensenballen?igsh=MTRpcHBua2luMWd0cw=="],
                                    ["nombre" => "Juan Pablo Montaño Pérez", "rol" => "Módulo de Equipos", "foto" => "vistas/img/desarrolladores/jpmp.jpg", "github" => "https://github.com/JuanPablo-mp", "instagram" => "https://www.instagram.com/juanpa_13mp?igsh=bWZodG1xcm1rZzVx"],
                                    ["nombre" => "Jhon Edison Díaz Ruiz", "rol" => "Módulo de Mantenimiento", "foto" => "vistas/img/desarrolladores/jedr.jpg", "github" => "https://github.com/Jediaz23", "instagram" => "https://www.instagram.com/jhoon_dxz00?igsh=bW9sc2JqYThkNWE5"],
                                    ["nombre" => "Cristian Camilo Restrepo Muriel", "rol" => "Módulo de Equipos", "foto" => "vistas/img/desarrolladores/ccrm.jpg", "github" => "https://github.com/CamiloRestre", "instagram" => "https://www.instagram.com/camilo_restre?igsh=MWZkbTQ0bnRqeXVqeg=="],
                                    ["nombre" => "Karen Vanessa Valencia Grueso", "rol" => "Módulo de Salidas", "foto" => "vistas/img/desarrolladores/kvvg.jpg", "github" => "https://github.com/KARENVALENC", "instagram" => "https://www.instagram.com/karen_valenciakv?igsh=ZXRhNzd1cWNzZGUy "]
                                ];

                                foreach ($desarrolladores as $dev) {
                                    // Verificamos si la imagen existe físicamente en el servidor
                                    $rutaRelativa = $dev["foto"];
                                    $rutaAbsoluta = $_SERVER["DOCUMENT_ROOT"] . "/hermesbeta/" . $dev["foto"];
                                    $foto = file_exists($rutaAbsoluta) ? $rutaRelativa : "vistas/img/usuarios/default/anonymous.jpg";

                                    $githubLink = isset($dev["github"]) ? $dev["github"] : "#";
                                    $instagramLink = isset($dev["instagram"]) ? $dev["instagram"] : "#";

                                    echo '
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <div class="user-avatar mb-3">
                                                <img src="' . $foto . '" class="img-circle elevation-2" alt="User Image" style="width: 100px; height: 100px; object-fit: cover;">
                                            </div>
                                            <h4 class="mb-1">' . $dev["nombre"] . '</h4>
                                            <p class="text-muted small mb-3">' . $dev["rol"] . '</p>
                                            <div class="d-flex justify-content-center">
                                                <a href="' . $githubLink . '" target="_blank" class="btn btn-sm btn-outline-dark mr-2">
                                                    <i class="fab fa-github"></i>
                                                </a>
                                                <a href="' . $instagramLink . '" target="_blank" class="btn btn-sm btn-outline-danger">
                                                    <i class="fab fa-instagram"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>