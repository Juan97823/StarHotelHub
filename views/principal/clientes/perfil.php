<?php include_once 'views/template/header-cliente.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h4 class="fw-bold mb-0"><i class='bx bxs-user-circle me-2'></i>Mi Perfil</h4>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_SESSION['alerta'])) : ?>
                        <div class="alert alert-<?php echo $_SESSION['alerta']['tipo']; ?> alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['alerta']['mensaje']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['alerta']); ?>
                    <?php endif; ?>

                    <form action="<?php echo RUTA_PRINCIPAL; ?>perfil/guardar" method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $data['usuario']['nombre']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $data['usuario']['correo']; ?>" required>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="password_actual" class="form-label">Contraseña Actual</label>
                            <input type="password" class="form-control" id="password_actual" name="password_actual" required>
                        </div>
                        <p class="text-muted">Dejar en blanco si no quieres cambiar la contraseña.</p>
                        <div class="mb-3">
                            <label for="password_nueva" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="password_nueva" name="password_nueva">
                        </div>
                        <div class="mb-3">
                            <label for="confirmar_password" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="confirmar_password" name="confirmar_password">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-bold">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/template/footer-cliente.php'; ?>