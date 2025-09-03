<?php include_once 'views/template/header-admin.php'; ?>

<div class="container-fluid">
    <!-- Formulario Principal de Edición -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Editar Habitación</h5>
            
            <form action="<?php echo RUTA_PRINCIPAL; ?>admin/habitaciones/registrar" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $data['habitacion']['id']; ?>">
                <input type="hidden" name="foto_actual" value="<?php echo $data['habitacion']['foto']; ?>">

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label for="estilo">Estilo</label>
                            <input type="text" class="form-control" id="estilo" name="estilo" value="<?php echo $data['habitacion']['estilo']; ?>" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="capacidad">Capacidad</label>
                                    <input type="number" class="form-control" id="capacidad" name="capacidad" value="<?php echo $data['habitacion']['capacidad']; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="precio">Precio por Noche</label>
                                    <input type="text" class="form-control" id="precio" name="precio" value="<?php echo $data['habitacion']['precio']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo $data['habitacion']['descripcion']; ?></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="servicios">Servicios (separados por comas)</label>
                            <input type="text" class="form-control" id="servicios" name="servicios" value="<?php echo $data['habitacion']['servicios']; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="foto">Foto Principal</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>
                        <?php if (!empty($data['habitacion']['foto'])) : ?>
                            <div class="mt-3">
                                <p>Foto Actual:</p>
                                <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/habitaciones/' . $data['habitacion']['foto']; ?>" class="img-fluid rounded">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="<?php echo RUTA_PRINCIPAL; ?>admin/habitaciones" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Habitación</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sección de Galería de Imágenes -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Galería de Imágenes</h5>

            <!-- Formulario para subir nuevas imágenes -->
            <form action="<?php echo RUTA_PRINCIPAL; ?>admin/habitaciones/subirFotos" method="POST" enctype="multipart/form-data" class="mb-4">
                <input type="hidden" name="id_habitacion" value="<?php echo $data['habitacion']['id']; ?>">
                <div class="form-group">
                    <label for="imagenes">Añadir nuevas imágenes a la galería</label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="imagenes" name="imagenes[]" multiple required>
                        <button class="btn btn-outline-primary" type="submit">Subir Imágenes</button>
                    </div>
                </div>
            </form>

            <!-- Galería actual -->
            <div id="galeria-container" class="row">
                <?php if (!empty($data['galeria'])) : ?>
                    <?php foreach ($data['galeria'] as $foto) : ?>
                        <div class="col-md-3 mb-3" id="foto-<?php echo $foto['id']; ?>">
                            <div class="card">
                                <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/habitaciones/' . $foto['imagen']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                                <div class="card-body p-2 text-center">
                                    <button class="btn btn-danger btn-sm" onclick="eliminarFoto(<?php echo $foto['id']; ?>)">Eliminar</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p class="text-muted">Esta habitación aún no tiene imágenes en su galería.</p>
                <?php endif; ?>
            </div>

        </div>
    </div>

</div>

<?php include_once 'views/template/footer-admin.php'; ?>

<script>
function eliminarFoto(id_foto) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Esta acción no se puede revertir!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, ¡eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Usamos el objeto URL para construir la ruta dinámicamente
            const url = new URL('admin/habitaciones/eliminarFoto/' + id_foto, '<?php echo RUTA_PRINCIPAL; ?>');

            fetch(url, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(res => {
                Swal.fire('Aviso', res.msg, res.icono);
                if (res.icono == 'success') {
                    // Eliminar el elemento de la vista
                    document.getElementById('foto-' + id_foto).remove();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un problema al eliminar la foto', 'error');
            });
        }
    });
}
</script>