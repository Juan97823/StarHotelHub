<?php
// Variables para mejorar la legibilidad y seguridad
$nombreUsuario = $_SESSION['usuario']['nombre'] ?? 'Cliente';
$urlBase = RUTA_PRINCIPAL;

// Sanitizar el nombre de usuario para evitar XSS
$nombreUsuario = htmlspecialchars($nombreUsuario, ENT_QUOTES, 'UTF-8');

// URL base para el panel de cliente para simplificar los enlaces
$urlCliente = $urlBase . 'cliente/';
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StarHotelHub - Panel de Cliente</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo $urlBase . 'assets/img/Logo.png'; ?>">

    <!-- CSS base -->
    <link href="<?php echo $urlBase . 'assets/admin/plugins/simplebar/css/simplebar.css'; ?>" rel="stylesheet" />
    <link href="<?php echo $urlBase . 'assets/admin/plugins/metismenu/css/metisMenu.min.css'; ?>" rel="stylesheet" />
    <link href="<?php echo $urlBase . 'assets/admin/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo $urlBase . 'assets/admin/css/app.css'; ?>" rel="stylesheet">
    <link href="<?php echo $urlBase . 'assets/admin/css/icons.css'; ?>" rel="stylesheet">

    <!-- CSS personalizado -->
    <link href="<?php echo $urlBase . 'assets/admin/css/cliente-dashboard.css'; ?>" rel="stylesheet">

    <!-- Definir RUTA_PRINCIPAL para JavaScript -->
    <script>
        const RUTA_PRINCIPAL = "<?php echo RUTA_PRINCIPAL; ?>";
    </script>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar cliente -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <a href="<?php echo $urlBase; ?>" class="d-flex align-items-center">
                    <img src="<?php echo $urlBase . 'assets/img/Logo.png'; ?>" class="logo-icon" alt="StarHotelHub Logo"
                        style="width: 40px; height: auto;">
                    <h4 class="logo-text ms-2">StarHotelHub</h4>
                </a>
            </div>

            <!-- Menú de cliente -->
            <ul class="metismenu" id="menu">
                <li>
                    <a href="<?php echo $urlCliente . 'dashboard'; ?>">
                        <div class="parent-icon"><i class='bx bx-home-alt'></i></div>
                        <div class="menu-title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $urlCliente . 'reservas'; ?>">
                        <div class="parent-icon"><i class='bx bx-calendar'></i></div>
                        <div class="menu-title">Mis Reservas</div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $urlBase . 'perfil'; ?>">
                        <div class="parent-icon"><i class='bx bx-user'></i></div>
                        <div class="menu-title">Mi Perfil</div>
                    </a>
                </li>
            </ul>

            <!-- Perfil de usuario -->
            <div class="user-profile-section dropdown">
                <a class="d-flex align-items-center nav-link dropdown-toggle" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo $urlBase . 'assets/img/default.png'; ?>" class="user-img" alt="user avatar"
                        style="width: 40px; height: 40px; border-radius: 50%;">
                    <div class="user-info ps-3">
                        <p class="user-name mb-0"><?php echo $nombreUsuario; ?></p>
                        <p class="designattion mb-0">Panel de Cliente</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="<?php echo $urlBase . 'perfil'; ?>"><i
                                class='bx bx-user-circle'></i><span>Mi Perfil</span></a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="<?php echo $urlBase . 'logout'; ?>"><i
                                class='bx bx-log-out-circle'></i><span>Cerrar Sesión</span></a></li>
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

        <div class="page-wrapper">
            <div class="page-content">