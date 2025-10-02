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

                <!-- Categoría -->
                <div class="mb-3">
                    <label for="categorias" class="form-label fw-bold">Categoría</label>
                    <select name="id_categorias" id="categorias" class="form-select" required>
                        <option value="">Selecciona una categoría</option>
                        <?php foreach ($data['categorias'] as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo $cat['id'] == $data['entrada']['id_categorias'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Debes seleccionar una categoría.</div>
                </div>

                <!-- Imagen actual -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Imagen actual</label>
                    <div>
                        <?php if ($data['entrada']['foto']): ?>
                            <img src="<?php echo RUTA_PRINCIPAL; ?>uploads/blog/<?php echo $data['entrada']['foto']; ?>"
                                class="img-thumbnail shadow-sm" width="150" id="imgPreviewActual">
                        <?php else: ?>
                            <p class="text-muted fst-italic">No hay imagen cargada.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Cambiar imagen -->
                <div class="mb-3">
                    <label for="imagen" class="form-label fw-bold">Cambiar imagen</label>
                    <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*"
                        onchange="mostrarPreview(event)">
                    <div class="mt-2">
                        <img id="previewImg" src="" alt="Vista previa" class="img-thumbnail shadow-sm d-none"
                            width="150">
                    </div>
                    <small class="text-muted">Si no seleccionas una nueva imagen, se mantendrá la actual.</small>
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