<?php
// Variables para facilitar la lectura y el mantenimiento
$nombreUsuario = $_SESSION['usuario']['nombre'] ?? 'Usuario';
$urlBase = RUTA_PRINCIPAL;
$urlAdmin = RUTA_ADMIN;

// Sanitizar el nombre de usuario para evitar XSS
$nombreUsuario = htmlspecialchars($nombreUsuario, ENT_QUOTES, 'UTF-8');

?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StarHotelHub - Panel de Administración</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo $urlBase . 'assets/img/logo.png'; ?>">

    <!-- Fuentes -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Estilos de Plugins -->
    <link href="<?php echo $urlBase . 'assets/admin/plugins/simplebar/css/simplebar.css'; ?>" rel="stylesheet" />
    <link href="<?php echo $urlBase . 'assets/admin/plugins/metismenu/css/metisMenu.min.css'; ?>" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

    <!-- Estilos Principales de la Plantilla -->
    <link href="<?php echo $urlBase . 'assets/admin/css/pace.min.css'; ?>" rel="stylesheet" />
    <link href="<?php echo $urlBase . 'assets/admin/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo $urlBase . 'assets/admin/css/bootstrap-extended.css'; ?>" rel="stylesheet">
    <link href="<?php echo $urlBase . 'assets/admin/css/app.css'; ?>" rel="stylesheet">
    <link href="<?php echo $urlBase . 'assets/admin/css/icons.css'; ?>" rel="stylesheet">

    <!-- Estilos Personalizados -->
    <link rel="stylesheet" href="<?php echo $urlBase . 'assets/admin/css/custom-dashboard.css'; ?>" />
    <link rel="stylesheet" href="<?php echo $urlBase . 'assets/admin/css/mobile-menu.css'; ?>" />

    <script src="<?php echo $urlBase . 'assets/admin/js/pace.min.js'; ?>"></script>

</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <a href="<?php echo $urlAdmin . 'dashboard'; ?>" class="d-flex align-items-center">
                    <img src="<?php echo $urlBase . 'assets/img/logo.png'; ?>" class="logo-icon"
                        alt="StarHotelHub Logo">
                    <h4 class="logo-text ms-2">StarHotelHub</h4>
                </a>
            </div>

            <!-- Menú de Navegación -->
            <ul class="metismenu" id="menu">
                <li>
                    <a href="<?php echo $urlBase; ?>">
                        <div class="parent-icon"><i class='bx bx-arrow-back'></i></div>
                        <div class="menu-title">Volver al Sitio</div>
                    </a>
                </li>
                <li class="menu-label">Panel de Administración</li>
                <li>
                    <a href="<?php echo $urlAdmin . 'dashboard'; ?>">
                        <div class="parent-icon"><i class='bx bx-home-alt'></i></div>
                        <div class="menu-title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $urlAdmin . 'reservas'; ?>">
                        <div class="parent-icon"><i class='bx bx-calendar-check'></i></div>
                        <div class="menu-title">Reservas</div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $urlAdmin . 'usuarios'; ?>">
                        <div class="parent-icon"><i class='bx bx-group'></i></div>
                        <div class="menu-title">Usuarios</div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $urlAdmin . 'habitaciones'; ?>">
                        <div class="parent-icon"><i class='bx bx-bed'></i></div>
                        <div class="menu-title">Habitaciones</div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $urlAdmin . 'Blog'; ?>">
                        <div class="parent-icon"><i class='bx bx-news'></i></div>
                        <div class="menu-title">Blog</div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $urlAdmin . 'contacto'; ?>">
                        <div class="parent-icon"><i class='bx bx-envelope'></i></div>
                        <div class="menu-title">Mensajes de Contacto</div>
                    </a>
                </li>
            </ul>
            <!-- Fin Menú de Navegación -->

            <!-- Perfil de Usuario -->
            <div class="user-profile-section dropdown">
                <a class="d-flex align-items-center nav-link dropdown-toggle" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo $urlBase . 'assets/img/logo.png'; ?>" class="user-img" alt="Avatar de Usuario">
                    <div class="user-info ps-3">
                        <p class="user-name mb-0"><?php echo $nombreUsuario; ?></p>
                        <p class="designattion mb-0">Ver Perfil</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="<?php echo $urlAdmin . 'perfil'; ?>">
                            <i class="bx bx-user"></i><span>Mi Perfil</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?php echo $urlBase . 'logout'; ?>">
                            <i class='bx bx-log-out-circle'></i><span>Cerrar Sesión</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Fin Sidebar -->

        <!-- Encabezado Principal -->
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand w-100">
                    <div class="mobile-toggle-menu" id="mobileMenuToggle">
                        <i class='bx bx-menu'></i>
                    </div>
                </nav>
            </div>
        </header>
        <!-- Fin Encabezado -->

        <!-- Overlay para cerrar menú móvil -->
        <div class="overlay"></div>

        <!-- Contenedor de la Página -->
        <div class="page-wrapper">
            <div class="page-content">