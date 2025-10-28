<?php
include_once 'views/template/header-principal.php';
include_once 'views/template/portada.php';
$csrf_token = generarCsrfToken();
?>

<section class="user-area-all-style sign-up-area ptb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <div class="contact-form-action shadow-lg p-5 rounded bg-white">
                    <div class="form-heading text-center">
                        <h3 class="form-title">Crear una cuenta</h3>
                        <p class="form-desc">Solo necesitas tu correo y contraseña.</p>
                    </div>
                    <form id="formulario" autocomplete="off">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

                        <!-- Botón Google -->
                        <div class="mb-4">
                            <button class="default-btn w-100 py-3 fs-5" type="button" disabled>
                                <i class="bx bxl-google me-2 fs-4"></i> Registro con Google (Próximamente)
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <input class="form-control" type="text" name="nombre" placeholder="Nombre completo" required>
                            </div>
                            <div class="col-12 mb-3">
                                <input class="form-control" type="email" name="correo" placeholder="Correo electrónico" required>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <input class="form-control" type="password" name="clave" placeholder="Contraseña" required >
                            </div>
                            <div class="col-12 mb-3">
                                <input class="form-control" type="password" name="confirmar" placeholder="Confirmar contraseña" required>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-condition">
                                <div class="agree-label">
                                    <input type ="checkbox" id="chb2" name="chb2" required>
                                    <label for="chb2">Acepto los <a href="<?php echo RUTA_PRINCIPAL . 'terminos'; ?>">Términos y Condiciones</a>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="default-btn btn-two w-100" type="submit">
                                    Registrar Cuenta <i class="flaticon-right ms-2"></i>
                                </button>
                            </div>
                            <div class="col-12 text-center mt-3">
                                <p class="account-desc">
                                    ¿Ya tienes una cuenta? 
                                    <a href="<?php echo RUTA_PRINCIPAL . 'Login'; ?>">Iniciar sesión</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once 'views/template/footer-principal.php'; ?>
<script src="<?php echo RUTA_PRINCIPAL . 'assets/principal/js/pages/registro.js'; ?>"></script>
