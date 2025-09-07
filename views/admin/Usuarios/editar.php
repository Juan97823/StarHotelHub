<?php include_once 'views/template/header-admin.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-4"><?php echo $data['title']; ?></h3>
                </div>
                <div class="card-body">
                    <form id="frmActualizar" onsubmit="actualizarUsuario(event);">
                        <input type="hidden" id="id" name="id" value="<?php echo $data['usuario']['id']; ?>">
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo htmlspecialchars($data['usuario']['nombre']); ?>" placeholder="Introduce el nombre" />
                                    <label for="nombre">Nombre Completo</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <input class="form-control" id="correo" name="correo" type="email" value="<?php echo htmlspecialchars($data['usuario']['correo']); ?>" placeholder="name@example.com" />
                            <label for="correo">Correo Electrónico</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" id="rol" name="rol">
                                <option value="1" <?php if($data['usuario']['rol'] == 1) echo 'selected'; ?>>Administrador</option>
                                <option value="2" <?php if($data['usuario']['rol'] == 2) echo 'selected'; ?>>Empleado</option>
                                <option value="3" <?php if($data['usuario']['rol'] == 3) echo 'selected'; ?>>Cliente</option>
                            </select>
                            <label for="rol">Rol</label>
                        </div>
                        
                        <div class="mt-4 mb-0">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="<?php echo RUTA_ADMIN . 'usuarios'; ?>" class="btn btn-secondary">Volver</a>
                                <button class="btn btn-primary" type="submit">Guardar Cambios</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/template/footer-admin.php'; ?>

<!-- CORRECCIÓN DEFINITIVA: Se carga el script usando RUTA_PRINCIPAL -->
<script src="<?php echo RUTA_PRINCIPAL; ?>assets/admin/js/pages/usuario_editar.js"></script>