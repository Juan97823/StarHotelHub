<?php 
include_once 'views/template/header-principal.php'; 
include_once 'views/template/portada.php';
?>

<section class="user-area-all-style sign-up-area ptb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <div class="contact-form-action shadow-lg p-5 rounded bg-white text-center">
                    <div class="mb-4">
                        <i class="bx bx-error-circle" style="font-size: 80px; color: #dc3545;"></i>
                    </div>
                    
                    <h3 class="mb-3">Enlace Inválido o Expirado</h3>
                    
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error ?? 'El enlace de restablecimiento es inválido o ha expirado.'); ?>
                    </div>

                    <p class="mb-4">
                        Los enlaces de restablecimiento de contraseña son válidos por <strong>1 hora</strong> 
                        por razones de seguridad.
                    </p>

                    <div class="d-grid gap-2">
                        <a href="<?php echo RUTA_PRINCIPAL . 'olvidecontrasena'; ?>" class="default-btn btn-two">
                            <i class="bx bx-refresh me-2"></i> Solicitar Nuevo Enlace
                        </a>
                        
                        <a href="<?php echo RUTA_PRINCIPAL . 'login'; ?>" class="btn btn-outline-secondary">
                            <i class="bx bx-log-in me-2"></i> Volver al Login
                        </a>
                    </div>

                    <div class="alert alert-info mt-4" role="alert">
                        <strong>¿Necesitas ayuda?</strong><br>
                        Si continúas teniendo problemas para acceder a tu cuenta, 
                        contacta con nuestro equipo de soporte.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once 'views/template/footer-principal.php'; ?>

