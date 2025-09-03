<?php include_once 'views/template/header-admin.php'; ?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Nueva Habitación</h5>
            
            <form id="formHabitacion" action="<?php echo RUTA_PRINCIPAL; ?>admin/habitaciones/registrar" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="estilo">Estilo</label>
                        <input type="text" class="form-control" id="estilo" name="estilo" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="capacidad">Capacidad</label>
                        <input type="number" class="form-control" id="capacidad" name="capacidad" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="precio">Precio por Noche</label>
                        <input type="text" class="form-control" id="precio" name="precio" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="servicios">Servicios (separados por comas)</label>
                        <input type="text" class="form-control" id="servicios" name="servicios">
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto Principal</label>
                        <input type="file" class="form-control" id="foto" name="foto">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo RUTA_PRINCIPAL; ?>admin/habitaciones" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php include_once 'views/template/footer-admin.php'; ?>