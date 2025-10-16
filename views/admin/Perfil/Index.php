<?php require_once 'views/template/header-admin.php'; ?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3>Mi Perfil</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <i class="fas fa-user-circle fa-8x text-primary mb-3"></i>
                    <h4><?php echo htmlspecialchars($data['usuario']['nombre']); ?></h4>
                    <p class="text-muted"><?php echo htmlspecialchars($data['usuario']['rol']); ?></p>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Información de Contacto</h5>
                            <hr>
                            <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($data['usuario']['correo']); ?></p>
                            
                            <hr>
                            <h5 class="card-title">Acciones</h5>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">Editar Perfil</button>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Cambiar Contraseña</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Perfil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Editar Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm">
                    <div class="mb-3">
                        <label for="profileNombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="profileNombre" name="nombre" value="<?php echo htmlspecialchars($data['usuario']['nombre']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="profileCorreo" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="profileCorreo" name="correo" value="<?php echo htmlspecialchars($data['usuario']['correo']); ?>" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Cambiar Contraseña -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Cambiar Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm">
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Contraseña Actual</label>
                        <input type="password" class="form-control" id="currentPassword" name="current_clave" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control" id="newPassword" name="clave" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirm_clave" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require_once 'views/template/footer-admin.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const editProfileForm = document.getElementById('editProfileForm');
    if (editProfileForm) {
        editProfileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const url = base_url + 'admin/perfil/editar';
            const data = new FormData(editProfileForm);

            fetch(url, { method: 'POST', body: data })
            .then(response => response.json())
            .then(res => {
                if (res.tipo === 'success') {
                    Swal.fire('¡Éxito!', res.msg, 'success').then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('¡Error!', res.msg, 'error');
                }
            }).catch(err => {
                Swal.fire('¡Error!', 'No se pudo comunicar con el servidor.', 'error');
            });
        });
    }

    const changePasswordForm = document.getElementById('changePasswordForm');
    if (changePasswordForm) {
        changePasswordForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (newPassword !== confirmPassword) {
                Swal.fire('¡Error!', 'Las contraseñas no coinciden.', 'error');
                return;
            }

            const url = base_url + 'admin/perfil/cambiarClave';
            const data = new FormData(changePasswordForm);

            fetch(url, { method: 'POST', body: data })
            .then(response => response.json())
            .then(res => {
                if (res.tipo === 'success') {
                    Swal.fire('¡Éxito!', res.msg, 'success').then(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
                        modal.hide();
                        changePasswordForm.reset();
                    });
                } else {
                    Swal.fire('¡Error!', res.msg, 'error');
                }
            }).catch(err => {
                Swal.fire('¡Error!', 'No se pudo comunicar con el servidor.', 'error');
            });
        });
    }
});
</script>
