<?php
// Vista simple para mostrar resultado de la confirmación de cuenta
include_once 'views/template/header-principal.php';

$success = $data['success'] ?? false;
$msg = $data['msg'] ?? '';
?>
<section class="pt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h2><?php echo $success ? 'Cuenta confirmada' : 'Confirmación fallida'; ?></h2>
                <p><?php echo htmlspecialchars($msg); ?></p>
                <?php if ($success): ?>
                    <a href="<?php echo RUTA_PRINCIPAL . 'login'; ?>" class="btn btn-primary">Ir a iniciar sesión</a>
                <?php else: ?>
                    <a href="<?php echo RUTA_PRINCIPAL . 'registro'; ?>" class="btn btn-secondary">Registrarme</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include_once 'views/template/footer-principal.php'; ?>
