<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?= asset('build/js/app.js') ?>"></script>
    <link rel="shortcut icon" href="<?= asset('images/cit.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">
    <title>Parcial</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark  bg-dark">

        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
                aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="/parcial_martinez/">
                <img src="<?= asset('./images/cit.png') ?>" width="35px'" alt="cit">
                PARCIAL
            </a>
            <div class="collapse navbar-collapse" id="navbarToggler">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin: 0;">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/parcial_martinez/"><i
                                class="bi bi-house-fill me-2"></i>Inicio</a>
                    </li>

                    <div class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-gear me-2"></i>MENU
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-dark " id="dropwdownRevision" style="margin: 0;">
                            <!-- <h6 class="dropdown-header">Información</h6> -->

                            <li>
                                <a class="dropdown-item nav-link text-white "
                                    href="/parcial_martinez/registroUsuario"><i
                                        class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>Registro</a>
                            </li>

                            <li>
                                <a class="dropdown-item nav-link text-white " href="/parcial_martinez/usuarios"><i
                                        class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>Usuarios</a>
                            </li>

                            <li>
                                <a class="dropdown-item nav-link text-white " href="/parcial_martinez/roles"><i
                                        class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>Roles</a>
                            </li>

                            <li>
                                <a class="dropdown-item nav-link text-white " href="/parcial_martinez/permisos"><i
                                        class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>Permisos</a>
                            </li>

                        </ul>
                    </div>
                    <div class="nav-item ">

                        <a class="dropdown-item nav-link text-white " href="/parcial_martinez/reporte1"><i
                                class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>Reporte1</a>
                    </div>

                    <div class="nav-item ">
                        <a class="dropdown-item nav-link text-white " href="/parcial_martinez/reporte2"><i
                                class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>Reporte2</a>

                    </div>

            </div>
            </ul>
            <div class="col-lg-1 d-grid mb-lg-0 mb-2">
                <!-- Ruta relativa desde el archivo donde se incluye menu.php -->
                <a href="/parcial_martinez/" class="btn btn-danger"><i class="bi bi-arrow-bar-left"></i>SALIR</a>
            </div>
        </div>
        </div>
    </nav>

    <div class="progress fixed-bottom" style="height: 6px;">
        <div class="progress-bar progress-bar-animated bg-danger" id="bar" role="progressbar" aria-valuemin="0"
            aria-valuemax="100"></div>
    </div>
    <div class="container-fluid pt-5 mb-4" style="min-height: 85vh">

        <?php echo $contenido; ?>
    </div>
    <div class="container-fluid ">
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <p style="font-size:xx-small; font-weight: bold;">
                    Comando de Informática y Tecnología,
                    <?= date('Y') ?> &copy;
                </p>
            </div>
        </div>
    </div>
</body>

</html>