<?php include_once 'views/template/header-principal.php'; ?>
<?php include_once 'views/template/portada.php'; ?>

<!-- Start Log In Area -->
<section class="user-area-all-style log-in-area ptb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="contact-form-action shadow-lg p-5 rounded bg-white">
                    <div class="form-heading text-center mb-4">
                        <h3 class="form-title">Inicia sesión en tu cuenta</h3>
                        <p class="form-desc">Accede con tu cuenta de Google o usa tus credenciales</p>
                    </div>

                    <form method="post">
                        <div class="row g-3 justify-content-center">

                            <!-- Botón Google amplio -->
                            <div class="col-12">
                                <button class="default-btn w-100 py-3 fs-5" type="submit">
                                    <i class="bx bxl-google me-2 fs-4"></i> Iniciar sesión con Google
                                </button>
                            </div>

                            <!-- Usuario -->
                            <div class="col-12">
                                <input class="form-control form-control-lg" type="text" name="name" placeholder="Usuario o Correo Electrónico">
                            </div>

                            <!-- Contraseña -->
                            <div class="col-12">
                                <input class="form-control form-control-lg" type="password" name="password" placeholder="Contraseña">
                            </div>

                            <!-- Recordar y recuperar -->
                            <div class="col-lg-6 col-sm-6 form-condition">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="chb1">
                                    <label class="form-check-label" for="chb1">Recordarme</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 text-end">
                                <a class="forget" href="recover-password.html">¿Olvidaste tu contraseña?</a>
                            </div>

                            <!-- Botón Login -->
                            <div class="col-12">
                                <button class="default-btn btn-two w-100" type="submit">
                                    Iniciar sesión ahora
                                    <i class="flaticon-right ms-2"></i>
                                </button>
                            </div>

                            <!-- Registro -->
                            <div class="col-12 text-center mt-3">
                                <p class="account-desc">
                                    ¿No tienes cuenta?
                                    <a href="registro.php">Regístrate aquí</a>
                                </p>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Log In Area -->

<?php include_once 'views/template/footer-principal.php'; ?>

<script src="<?php echo RUTA_PRINCIPAL . 'assets/principal/js/pages/login.js'; ?>"></script>
</body>

</html>