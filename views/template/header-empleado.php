<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StarHotelHub - Panel de Empleado</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo RUTA_PRINCIPAL . 'assets/img/Logo.png'; ?>">

    <!-- Estilos principales -->
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/plugins/simplebar/css/simplebar.css'; ?>" rel="stylesheet" />
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/plugins/metismenu/css/metisMenu.min.css'; ?>"
        rel="stylesheet" />
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/css/pace.min.css'; ?>" rel="stylesheet" />
    <script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/js/pace.min.js'; ?>"></script>
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/css/bootstrap-extended.css'; ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/css/app.css'; ?>" rel="stylesheet">
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/css/icons.css'; ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Estilos de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/Logo.png'; ?>" class="logo-icon" alt="logo">
                </div>
                <div>
                    <h4 class="logo-text">StarHotelHub</h4>
                </div>
            </div>
            <!-- Menú de Navegación del Empleado -->
            <ul class="metismenu" id="menu">
                <a href="<?php echo RUTA_PRINCIPAL . ''; ?>">
                    <div class="parent-icon"><i class='bx bx-arrow-back'></i></div>
                    <div class="menu-title">Volver al sitio</div>
                </a>
                <li class="mm-active">
                    <a href="<?php echo RUTA_PRINCIPAL . 'empleado/dashboard'; ?>">
                        <div class="parent-icon"><i class='bx bx-home-alt'></i></div>
                        <div class="menu-title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo RUTA_PRINCIPAL . 'empleado/reservas'; ?>">
                        <div class="parent-icon"><i class='bx bx-calendar'></i></div>
                        <div class="menu-title">Reservas</div>
                    </a>
                </li>
            </ul>
            <!-- Fin Menú de Navegación -->

            <!-- Bloque de Perfil de Usuario -->
            <div class="user-profile-section dropdown">
                <a class="d-flex align-items-center nav-link dropdown-toggle" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/logo.png'; ?>" class="user-img" alt="avatar">
                    <div class="user-info ps-3">
                        <p class="user-name mb-0"><?php echo $_SESSION['usuario']['nombre'] ?? 'Empleado'; ?></p>
                        <p class="designattion mb-0">Ver Perfil</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="bx bx-user"></i><span>Mi Perfil</span></a></li>
                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li>
                    <li><a class="dropdown-item" href="<?php echo RUTA_PRINCIPAL; ?>logout"><i
                                class='bx bx-log-out-circle'></i><span>Cerrar Sesión</span></a></li>
                </ul>
            </div>
        </div>
        <!-- Fin Sidebar -->

        <!-- Encabezado superior -->
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i></div>
                </nav>
            </div>
        </header>
        <!-- Fin encabezado -->

        <!-- Contenedor principal de contenido -->
        <div class="page-wrapper">
            <div class="page-content">