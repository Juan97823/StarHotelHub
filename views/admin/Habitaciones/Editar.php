<?php 
include_once 'views/template/header-admin.php'; 
$habitacion = $data['habitacion'];
// La galería se cargará desde el controlador
$galeria = $data['galeria'] ?? [];
?>

<div class="container">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-warning">
                    <h4 class="card-title text-white mb-0"><?php echo $data['title']; ?></h4>
                </div>
                <div class="card-body">
                    <!-- Formulario Principal para Editar Habitación -->
                    <form action="<?php echo RUTA_PRINCIPAL . 'admin/habitaciones/guardar'; ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $habitacion['id']; ?>">
                        <input type="hidden" name="foto_actual" value="<?php echo $habitacion['foto']; ?>">

                        <div class="row">
                            <!-- Columna de Datos -->
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="estilo" class="form-label">Estilo de Habitación</label>
                                    <input id="estilo" class="form-control" type="text" name="estilo" value="<?php echo $habitacion['estilo']; ?>" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="capacidad" class="form-label">Capacidad</label>
                                        <input id="capacidad" class="form-control" type="number" name="capacidad" value="<?php echo $habitacion['capacidad']; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="precio" class="form-label">Precio por Noche</label>
                                        <!-- Corregido: 'precio' en lugar de 'precio_noche' -->
                                        <input id="precio" class="form-control" type="text" name="precio" value="<?php echo $habitacion['precio']; ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea id="descripcion" class="form-control" name="descripcion" rows="4" required><?php echo $habitacion['descripcion']; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="servicios" class="form-label">Servicios</label>
                                    <textarea id="servicios" class="form-control" name="servicios" rows="4" required><?php echo $habitacion['servicios']; ?></textarea>
                                </div>
                            </div>
                            <!-- Columna de Imagen Principal -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Imagen Principal</label>
                                    <div class="mb-2">
                                        <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/habitaciones/' . $habitacion['foto']; ?>" alt="Imagen Principal" class="img-thumbnail">
                                    </div>
                                    <label for="foto" class="form-label">Cambiar imagen</label>
                                    <input type="file" class="form-control" id="foto" name="foto">
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?php echo RUTA_PRINCIPAL . 'admin/habitaciones'; ?>" class="btn btn-secondary">Cancelar</a>
                            <button class="btn btn-warning" type="submit">Actualizar Habitación</button>
                        </div>
                    </form>
                </div>
                
                <hr>

                <!-- Sección de Galería de Fotos -->
                <div class="card-body">
                    <h5 class="card-title">Galería de Imágenes</h5>
                    <form action="<?php echo RUTA_PRINCIPAL . 'admin/habitaciones/subirFotos'; ?>" method="post" enctype="multipart/form-data" class="mb-4">
                        <input type="hidden" name="id_habitacion" value="<?php echo $habitacion['id']; ?>">
                        <div class="mb-3">
                            <label for="imagenes" class="form-label">Añadir nuevas imágenes a la galería</label>
                            <div class="input-group">
                                <input type="file" class="form-control" id="imagenes" name="imagenes[]" multiple>
                                <button type="submit" class="btn btn-info">Subir Imágenes</button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="row">
                        <?php if (empty($galeria)): ?>
                            <p class="text-muted">No hay imágenes en la galería.</p>
                        <?php else: ?>
                            <?php foreach ($galeria as $foto) : ?>
                                <div class="col-md-3 mb-3" id="foto-<?php echo $foto['id']; ?>">
                                    <div class="card position-relative">
                                        <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/habitaciones/' . $foto['imagen']; ?>" class="card-img-top" alt="Foto de galería" style="height: 150px; object-fit: cover;">
                                        <button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1" onclick="eliminarFoto(<?php echo $foto['id']; ?>)" style="--bs-btn-padding-y: .2rem; --bs-btn-padding-x: .4rem; --bs-btn-font-size: .7rem;"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/template/footer-admin.php'; ?>

<script>
function eliminarFoto(id_foto) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará la imagen de la galería.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, ¡eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = `<?php echo RUTA_PRINCIPAL; ?>admin/habitaciones/eliminarFoto/${id_foto}`;
            fetch(url, { method: 'GET' })
                .then(response => response.json())
                .then(res => {
                    if (res.icono === 'success') {
                        Swal.fire('¡Eliminada!', res.msg, 'success');
                        document.getElementById('foto-' + id_foto).remove();
                    } else {
                        Swal.fire('Error', res.msg, 'error');
                    }
                });
        }
    });
}
</script>
