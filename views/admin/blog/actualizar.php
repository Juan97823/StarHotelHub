<?php require_once 'views/template/header-admin.php'; ?>

<div class="card">
    <div class="card-body">
        <h4 class="mb-3">Editar entrada del blog</h4>

        <form action="<?php echo RUTA_PRINCIPAL ?>admin/blog/Actualizar" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?php echo $entrada['id']; ?>">
            <input type="hidden" name="imagen_actual" value="<?php echo $entrada['foto'] ?? ''; ?>">

            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo"
                    value="<?php echo htmlspecialchars($entrada['titulo']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Contenido</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="6"
                    required><?php echo htmlspecialchars($entrada['descripcion']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="id_categorias" class="form-label">Categoría</label>
                <select class="form-control" id="id_categorias" name="id_categorias" required>
                    <option value="">Seleccione categoría</option>
                    <?php foreach ($categorias as $cat) { ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo ($entrada['id_categorias'] == $cat['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['nombre']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Imagen actual</label><br>
                <?php if (!empty($entrada['foto'])) { ?>
                    <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/blog/' . $entrada['foto']; ?>" alt="Imagen actual"
                        width="180" class="mb-2 rounded">
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