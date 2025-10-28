<?php
include_once 'views/template/header-principal.php';
?>
<section class="pt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h2>Registro completado</h2>
                <p>Hemos enviado un correo de confirmación a tu dirección. Por favor revisa tu bandeja de entrada y sigue el enlace para activar tu cuenta.</p>
                <p>Si no recibes el correo en unos minutos, revisa tu carpeta de spam o <a href="<?php echo RUTA_PRINCIPAL . 'Contacto'; ?>">contáctanos</a>.</p>
                <a href="<?php echo RUTA_PRINCIPAL . 'login'; ?>" class="btn btn-primary">Ir al login</a>
            </div>
        </div>
    </div>
</section>
<?php include_once 'views/template/footer-principal.php'; ?>
