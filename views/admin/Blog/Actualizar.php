<?php require_once 'views/template/header-admin.php'; ?>

<div class="card">
    <div class="card-body">
        <h4 class="mb-3">Editar entrada del blog</h4>

        <form action="<?php echo RUTA_PRINCIPAL ?>admin/blog/editar/<?php echo $entrada['id']; ?>" method="POST" enctype="multipart/form-data">
            
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" 
                       value="<?php echo htmlspecialchars($entrada['titulo']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="contenido" class="form-label">Contenido</label>
                <textarea class="form-control" id="contenido" name="contenido" rows="6" required><?php echo htmlspecialchars($entrada['contenido']); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Imagen actual</label><br>
                <?php if (!empty($entrada['imagen'])) { ?>
                    <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/blog/' . $entrada['imagen']; ?>" 
                         alt="Imagen actual" width="180" class="mb-2 rounded">
                <?php } else { ?>
                    <p>No hay imagen cargada</p>
                <?php } ?>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Cambiar imagen</label>
                <input type="file" class="form-control" id="imagen" name="imagen">
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">Slug (URL amigable)</label>
                <input type="text" class="form-control" id="slug" name="slug" 
                       value="<?php echo htmlspecialchars($entrada['slug']); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="<?php echo RUTA_PRINCIPAL ?>admin/blog" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php require_once 'views/template/footer-admin.php'; ?>
