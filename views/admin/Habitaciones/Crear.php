<?php include_once 'views/template/header-admin.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0"><?php echo $data['title']; ?></h4>
                </div>
                <div class="card-body">
                    <!-- Corregido: La acción del formulario apunta al método 'guardar' -->
                    <form action="<?php echo RUTA_PRINCIPAL . 'admin/habitaciones/guardar'; ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value=""> <!-- Campo oculto para la edición -->

                        <div class="mb-3">
                            <label for="estilo" class="form-label">Estilo de Habitación</label>
                            <input id="estilo" class="form-control" type="text" name="estilo" placeholder="Ej: Suite, Doble, Individual" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="capacidad" class="form-label">Capacidad</label>
                                <input id="capacidad" class="form-control" type="number" name="capacidad" placeholder="Nº de personas" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="precio" class="form-label">Precio por Noche</label>
                                <input id="precio" class="form-control" type="text" name="precio" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea id="descripcion" class="form-control" name="descripcion" rows="3" placeholder="Describe la habitación" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="servicios" class="form-label">Servicios</label>
                            <textarea id="servicios" class="form-control" name="servicios" rows="3" placeholder="Ej: Wifi, TV Cable, Baño privado" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Imagen Principal</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?php echo RUTA_PRINCIPAL . 'admin/habitaciones'; ?>" class="btn btn-secondary">Cancelar</a>
                            <button class="btn btn-primary" type="submit">Guardar Habitación</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/template/footer-admin.php'; ?>
