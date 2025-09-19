<?php include_once 'views/template/header-admin.php'; ?>

<div class="container-fluid">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold mb-0">
                <i class="fas fa-blog me-2"></i>Nueva Entrada del Blog
            </h5>
            <a href="<?php echo RUTA_ADMIN; ?>blog" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
        </div>

        <div class="card-body">
            <form action="<?php echo RUTA_ADMIN; ?>blog/guardar" method="POST" enctype="multipart/form-data" autocomplete="off">
                
                <!-- Título -->
                <div class="mb-3">
                    <label for="titulo" class="form-label fw-semibold">Título <span class="text-danger">*</span></label>
                    <input type="text" 
                           name="titulo" 
                           id="titulo" 
                           class="form-control" 
                           placeholder="Ej: Oferta especial en el restaurante del hotel" 
                           minlength="5" 
                           maxlength="150" 
                           required>
                </div>

                <!-- Contenido -->
                <div class="mb-3">
                    <label for="contenido" class="form-label fw-semibold">Contenido / Descripción <span class="text-danger">*</span></label>
                    <textarea name="contenido" 
                              id="contenido" 
                              rows="6" 
                              class="form-control" 
                              placeholder="Escribe aquí la descripción completa de la entrada..." 
                              minlength="20" 
                              required></textarea>
                </div>
                <!-- Imagen -->
                <div class="mb-3">
                    <label for="imagen" class="form-label fw-semibold">Imagen destacada</label>
                    <input type="file" 
                           name="imagen" 
                           id="imagen" 
                           class="form-control" 
                           accept="image/*"
                           onchange="mostrarPreview(event)">
                    <small class="text-muted">Opcional. Si no subes imagen, se usará una por defecto.</small>

                    <!-- Preview -->
                    <div class="mt-3">
                        <img id="previewImg" src="" alt="Vista previa" class="img-thumbnail d-none" width="200">
                    </div>
                </div>

                <!-- Botón Guardar -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i> Guardar Entrada
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include_once 'views/template/footer-admin.php'; ?>
