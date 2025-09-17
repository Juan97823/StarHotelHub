<?php require_once 'views/template/header-admin.php'; ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div><h4 class="mb-0">Reservas</h4></div>
            <div class="ms-auto">
                <button class="btn btn-primary" type="button" onclick="btnNuevaReserva()">
                    <i class="fas fa-plus"></i> Nueva Reserva
                </button>
            </div>
        </div>
        <hr/>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="tableReservas">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Habitación</th>
                        <th>Cliente</th>
                        <th>Fecha Entrada</th>
                        <th>Fecha Salida</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="reservaModal" tabindex="-1" aria-labelledby="reservaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="reservaForm">
        <div class="modal-header">
            <h5 class="modal-title" id="reservaModalLabel">Nueva Reserva</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idReserva" name="idReserva">

            <div class="mb-3">
                <label for="habitacion" class="form-label">Habitación</label>
                <select class="form-control" id="habitacion" name="habitacion" required>
                    <option value="">Seleccionar Habitación</option>
                    <?php foreach ($data['habitaciones'] as $habitacion): ?>
                        <option value="<?=$habitacion['id']?>"><?=$habitacion['estilo']?></option>
                    <?php endforeach;?>
                </select>
            </div>

            <div class="mb-3">
                <label for="cliente" class="form-label">Cliente</label>
                <select class="form-control" id="cliente" name="cliente" required>
                    <option value="">Seleccionar Cliente</option>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fecha_ingreso" class="form-label">Fecha Ingreso</label>
                    <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="fecha_salida" class="form-label">Fecha Salida</label>
                    <input type="date" class="form-control" id="fecha_salida" name="fecha_salida" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="monto" class="form-label">Monto</label>
                <input type="number" step="0.01" class="form-control" id="monto" name="monto" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once 'views/template/footer-admin.php'; ?>

<!-- Script externo de Reservas -->
<script src="<?php echo RUTA_PRINCIPAL; ?>assets/admin/js/pages/reservas.js"></script>
