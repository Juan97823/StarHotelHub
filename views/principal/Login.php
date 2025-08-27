<?php include 'views/template/header-principal.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Acceso StarHotelHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <section class="user-area-all-style log-in-area ptb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7 col-md-9">
                    <div class="contact-form-action shadow-lg p-5 rounded bg-white position-relative">
                        <div class="form-heading text-center mb-4">
                            <h3 class="form-title">Inicia sesión en StarHotelHub</h3>
                            <p class="form-desc">Autenticación segura y moderna</p>
                        </div>

                        <form id="formulario" autocomplete="off">

                            <div class="row g-3 justify-content-center">

                                <!-- Google login -->
                                <div class="col-12">
                                    <button class="default-btn w-100 py-3 fs-5" type="button" disabled>
                                        <i class="fab fa-google me-2 fs-4"></i> Iniciar sesión con Google (Próximamente)
                                    </button>
                                </div>

                                <!-- Usuario o correo -->
                                <div class="col-12">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input class="form-control form-control-lg" type="text" name="usuario" placeholder="Correo">
                                    </div>
                                </div>
                                <!-- Contraseña -->
                                <div class="col-12">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                         <input class="form-control form-control-lg" type="password" name="clave" id="password" placeholder="Password">
                                        <button type="button" class="btn btn-outline-secondary show-password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Recordarme y recuperar -->
                                <div class="col-lg-6 col-sm-6 form-condition">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                        <label class="form-check-label" for="remember">Recordarme</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 text-end">
                                    <a class="forget" href="#">¿Olvidaste tu contraseña?</a>
                                </div>

                                <!-- Botón login -->
                                <div class="col-12">
                                    <button class="default-btn btn-two w-100" type="submit">
                                        <i class="fas fa-fingerprint me-2"></i> Iniciar sesión ahora
                                    </button>
                                </div>

                                <!-- Alternativas -->
                                <div class="col-12 text-center mt-4 alternative-auth">
                                    <p>Próximamente podrás acceder con:</p>
                                    <div class="auth-methods d-flex justify-content-center gap-3">
                                        <button type="button" class="btn btn-outline-dark" disabled><i class="fas fa-fingerprint"></i></button>
                                        <button type="button" class="btn btn-outline-dark" disabled><i class="fas fa-microphone"></i></button>
                                        <button type="button" class="btn btn-outline-dark" disabled><i class="fas fa-mobile-alt"></i></button>
                                    </div>
                                </div>

                                <!-- Registro -->
                                <div class="col-12 text-center mt-3">
                                    <p class="account-desc">¿No tienes cuenta? <a href="<?php echo RUTA_PRINCIPAL . 'registro'; ?>">Regístrate aquí</a></p>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include_once 'views/template/footer-login.php'; ?>
    <script src="<?php echo RUTA_PRINCIPAL . 'assets/principal/js/pages/login.js'; ?>"></script>
</body>

</html>