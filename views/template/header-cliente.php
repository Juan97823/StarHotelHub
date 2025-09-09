<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StarHotelHub - Panel de Cliente</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo RUTA_PRINCIPAL . 'assets/img/Logo.png'; ?>">

    <!-- CSS base -->
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/plugins/simplebar/css/simplebar.css'; ?>" rel="stylesheet" />
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/plugins/metismenu/css/metisMenu.min.css'; ?>" rel="stylesheet" />
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/css/app.css'; ?>" rel="stylesheet">
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/css/icons.css'; ?>" rel="stylesheet">

    <!-- CSS personalizado -->
    <link href="<?php echo RUTA_PRINCIPAL . 'assets/admin/css/cliente-dashboard.css'; ?>" rel="stylesheet">
</head>

<body>
<div class="wrapper">
    <!-- Sidebar cliente -->
    <div class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div>
                <h4 class="logo-text">StarHotelHub</h4>
            </div>
        </div>

        <!-- Menú de cliente -->
        <ul class="metismenu" id="menu">
            <li class="mm-active">
                <a href="<?php echo RUTA_PRINCIPAL . 'dashboard'; ?>">
                    <div class="parent-icon"><i class='bx bx-home-alt'></i></div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            <li>
                <a href="<?php echo RUTA_PRINCIPAL . 'cliente/reservas'; ?>">
                    <div class="parent-icon"><i class='bx bx-calendar'></i></div>
                    <div class="menu-title">Mis Reservas</div>
                </a>
            </li>
            <li>
                <a href="<?php echo RUTA_PRINCIPAL . 'cliente/perfil'; ?>">
                    <div class="parent-icon"><i class='bx bx-user'></i></div>
                    <div class="menu-title">Mi Perfil</div>
                </a>
            </li>
        </ul>

        <!-- Perfil de usuario sin imagen -->
        <div class="user-profile-section dropdown">
            <a class="d-flex align-items-center nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-info ps-3">
                    <p class="user-name mb-0"><?php echo $_SESSION['usuario']['nombre'] ?? 'Cliente'; ?></p>
                    <p class="designattion mb-0">Panel cliente</p>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="<?php echo RUTA_PRINCIPAL; ?>logout"><i class='bx bx-log-out-circle'></i><span>Cerrar Sesión</span></a></li>
            </ul>
        </div>
    </div>
    <!-- Fin Sidebar -->
    
    <!-- Topbar cliente -->
    <header>
        <div class="topbar d-flex align-items-center">
            <nav class="navbar navbar-expand">
                <div class="mobile-toggle-menu"><i class='bx bx-menu'></i></div>
            </nav>
        </div>
    </header>
    <!-- Fin Topbar -->
