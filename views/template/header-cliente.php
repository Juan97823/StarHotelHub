<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StarHotelHub - Panel del Cliente</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo RUTA_PRINCIPAL . 'assets'; ?>/img/Logo.png">

    <!-- Estilos principales -->
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/plugins/simplebar/css/simplebar.css'; ?>" rel="stylesheet" />
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/plugins/metismenu/css/metisMenu.min.css'; ?>" rel="stylesheet" />
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/css/pace.min.css'; ?>" rel="stylesheet" />
    <script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/js/pace.min.js'; ?>"></script>
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/css/bootstrap-extended.css'; ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/css/app.css'; ?>" rel="stylesheet">
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/css/icons.css'; ?>" rel="stylesheet">

    <!-- Temas -->
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/admin/css/dark-theme.css'; ?>" />
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/admin/css/semi-dark.css'; ?>" />
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/admin/css/header-colors.css'; ?>" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/logo.png'; ?>" class="logo-icon" alt="logo">
                </div>
                <div>
                    <h4 class="logo-text">StarHotelHub</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i></div>
            </div>
            <ul class="metismenu" id="menu">
                <li>
                    <a href="<?php echo RUTA_PRINCIPAL; ?>cliente/inicio">
                        <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                        <div class="menu-title">Inicio</div>
                    </a>
                </li>

                <li>
                    <!-- has-arrow para indicar que tiene submenú -->
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-calendar'></i></div>
                        <div class="menu-title">Mis Reservas</div>
                    </a>
                    <ul>
                        <li>
                            <a href="<?php echo RUTA_PRINCIPAL; ?>cliente/reservas">
                                <i class="bx bx-right-arrow-alt"></i> Ver todas
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo RUTA_PRINCIPAL; ?>reserva/pendiente">
                                <i class="bx bx-right-arrow-alt"></i> Pendiente
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="<?php echo RUTA_PRINCIPAL; ?>cliente/perfil">
                        <div class="parent-icon"><i class='bx bx-user'></i></div>
                        <div class="menu-title">Mi Perfil</div>
                    </a>
                </li>

                <li>
                    <a href="<?php echo RUTA_PRINCIPAL; ?>cliente/soporte">
                        <div class="parent-icon"><i class='bx bx-help-circle'></i></div>
                        <div class="menu-title">Soporte</div>
                    </a>
                </li>
            </ul>

        </div>
        <!-- Fin Sidebar -->

        <!-- Encabezado superior -->
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i></div>
                    <div class="flex-grow-1"></div>
                    <div class="user-box dropdown">
                        <?php
                        $nombreCliente = $_SESSION['usuario']['nombre'] ?? 'Cliente';
                        ?>
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/logo.png'; ?>" class="user-img" alt="avatar">
                            <div class="user-info ps-3">
                                <p class="user-name mb-0"><?php echo $nombreCliente; ?></p>
                                <p class="designattion mb-0">Cliente</p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo RUTA_PRINCIPAL; ?>cliente/perfil"><i class="bx bx-user"></i><span>Mi Perfil</span></a></li>
                            <li><a class="dropdown-item" href="<?php echo RUTA_PRINCIPAL; ?>cliente/reservas"><i class="bx bx-calendar"></i><span>Mis Reservas</span></a></li>
                            <li>
                                <div class="dropdown-divider mb-0"></div>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;" onclick="cerrarSesion()"><i class='bx bx-log-out-circle'></i><span>Cerrar Sesión</span></a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!-- Fin encabezado -->

        <!-- Contenedor principal de contenido -->
        <div class="page-wrapper">
            <div class="page-content"></div>