<?php include_once 'views/template/header-admin.php'; ?>

<div class="container-fluid">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold">
                <i class="fas fa-edit me-2"></i> Editar entradas del Blog
            </h5>
            <a href="<?php echo RUTA_PRINCIPAL; ?>admin/blog" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card-body">
            <form id="formBlog"
                action="<?php echo RUTA_PRINCIPAL; ?>admin/blog/actualizar/<?php echo $data['entrada']['id']; ?>"
                method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>

                <!-- Título -->
                <div class="mb-3">
                    <label for="titulo" class="form-label fw-bold">Título</label>
                    <input type="text" name="titulo" id="titulo" class="form-control"
                        value="<?php echo htmlspecialchars($data['entrada']['titulo']); ?>"
                        placeholder="Ej: Oferta especial en restaurante" required>
                    <div class="invalid-feedback">El título es obligatorio.</div>
                </div>

                <!-- Contenido -->
                <div class="mb-3">
                    <label for="contenido" class="form-label fw-bold">Contenido</label>
                    <textarea name="contenido" id="contenido" class="form-control" rows="6"
                        placeholder="Escribe el contenido aquí..."
                        required><?php echo htmlspecialchars($data['entrada']['descripcion']); ?></textarea>
                    <div class="invalid-feedback">El contenido es obligatorio.</div>
                </div>

                <!-- Botón Guardar -->
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                        <i class="fas fa-save me-2"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once 'views/template/footer-admin.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formBlog');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Validar formulario
        if (!form.checkValidity()) {
            e.stopPropagation();
            form.classList.add('was-validated');
            return;
        }

        // Mostrar confirmación
        Swal.fire({
            title: '¿Guardar cambios?',
            text: "Se actualizará la entrada del blog.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-success me-2',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar por AJAX
                const formData = new FormData(form);
                const url = form.action;

                fetch(url, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: '¡Éxito!',
                            text: 'La entrada ha sido actualizada correctamente.',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            window.location.href = '<?php echo RUTA_PRINCIPAL; ?>admin/blog';
                        });
                    } else {
                        Swal.fire('Error', data.mensaje || 'No se pudo guardar', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'No se pudo comunicar con el servidor', 'error');
                });
            }
        });
    });
});
</script>