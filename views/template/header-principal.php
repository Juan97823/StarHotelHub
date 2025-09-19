<!doctype html>
<html lang="zxx">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Habitaciones CSS -->
    <link rel="stylesheet" href="<?= RUTA_PRINCIPAL ?>assets/principal/css/habitaciones-home.css">
    <!-- Bootstrap Min CSS -->
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/css/bootstrap.min.css">
    <!-- Owl Theme Default Min CSS -->
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/css/owl.theme.default.min.css">
    <!-- Owl Carousel Min CSS -->
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/css/owl.carousel.min.css">
    <!-- Boxicons Min CSS -->
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/css/boxicons.min.css">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/css/flaticon.css">
    <!-- Meanmenu Min CSS -->
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/css/meanmenu.min.css">
    <!-- Animate Min CSS -->
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/css/animate.min.css">
    <!-- Nice Select Min CSS -->
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/css/nice-select.min.css">
    <!-- Odometer Min CSS -->
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/css/odometer.min.css">
    <!-- Date Picker CSS-->
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/css/date-picker.min.css">
    <!-- Magnific Popup Min CSS -->
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/css/magnific-popup.min.css">
    <!-- Beautiful Fonts CSS -->
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/css/beautiful-fonts.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/css/style.css">
    <!-- Dark CSS -->
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/css/dark.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/css/responsive.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <!-- Cargar estilos específicos de la página -->
    <?php if (isset($data['style']) && !empty($data['style'])): ?>
        <link rel="stylesheet" href="<?php echo RUTA_PRINCIPAL . 'assets/principal/css/' . $data['style']; ?>">
    <?php endif; ?>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo RUTA_PRINCIPAL . 'assets'; ?>/img/Logo.png">

    <!-- TITLE -->
    <title><?php echo TITLE . ' | ' . $data['title']; ?></title>
</head>

<body>
    <!-- Start Preloader Area -->
    <div class="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- End Preloader Area -->

    <!-- Start Ecorik Navbar Area -->
    <div class="eorik-nav-style fixed-top">
        <div class="navbar-area">
            <!-- Menu For Mobile Device -->
            <div class="mobile-nav">
                <a href=<?php echo RUTA_PRINCIPAL; ?> class="Logo">
                    <img src="<?php echo RUTA_PRINCIPAL . 'assets'; ?>/img/Logo.png" alt="Logo">
                </a>
            </div>
            <!-- Menu For Desktop Device -->
            <div class="main-nav">
                <nav class="navbar navbar-expand-md navbar-light">
                    <div class="container">
                        <a class="navbar-brand" href="<?php echo RUTA_PRINCIPAL; ?>">
                            <img src="<?php echo RUTA_PRINCIPAL . 'assets'; ?>/img/Logo.png" alt="Logo">
                        </a>
                        <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                            <ul class="navbar-nav m-auto">
                                <li class="nav-item">
                                    <a href="<?php echo RUTA_PRINCIPAL . 'Habitaciones'; ?>" class="nav-link active">
                                        Habitaciones
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?php echo RUTA_PRINCIPAL . 'Blog'; ?>" class="nav-link">
                                        Blog
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo RUTA_PRINCIPAL . 'Contacto'; ?>" class="nav-link">
                                        Contactos
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo RUTA_PRINCIPAL . 'Login'; ?>" class="nav-link">
                                        Login
                                    </a>
                                </li>
                            </ul>
                            <!-- Start Other Option -->
                            <div class="others-option">
                                <a class="call-us" href="tel:+57-319-587-8776">
                                    <i class="bx bx-phone-call bx-tada"></i>
                                    +57-319-587-8776
                                </a>
                            </div>
                            <!-- End Other Option -->
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- End Ecorik Navbar Area -->