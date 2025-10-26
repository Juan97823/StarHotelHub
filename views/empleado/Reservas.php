<?php require_once 'views/template/header-empleado.php'; ?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
        <h4 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Gestión de Reservas</h4>
        <button class="btn btn-light btn-sm fw-semibold" type="button" onclick="btnNuevaReserva()">
            <i class="fas fa-plus"></i> Nueva Reserva
        </button>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="tableReservas">
                <thead class="table-light text-center">
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

<!-- Modal: Crear/Editar Reserva -->
<div class="modal fade" id="reservaModal" tabindex="-1" aria-labelledby="reservaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm">
            <form id="reservaForm" autocomplete="off">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="reservaModalLabel"><i class="fas fa-calendar-plus me-2"></i>Nueva Reserva</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="idReserva" name="idReserva">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="habitacion" class="form-label fw-semibold">Habitación</label>
                            <select class="form-select" id="habitacion" name="habitacion" required>
                                <option value="">Seleccionar habitación...</option>
                                <?php foreach ($data['habitaciones'] as $habitacion): ?>
                                    <option value="<?php echo $habitacion['id']; ?>" data-precio="<?php echo $habitacion['precio']; ?>">
                                        <?php echo $habitacion['estilo']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="cliente" class="form-label fw-semibold">Cliente</label>
                            <select class="form-select" id="cliente" name="cliente" required>
                                <option value="">Seleccionar cliente...</option>
                                <?php foreach ($data['clientes'] as $cliente): ?>
                                    <option value="<?php echo $cliente['id']; ?>"><?php echo $cliente['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="fecha_ingreso" class="form-label fw-semibold">Fecha Ingreso</label>
                            <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
                        </div>

                        <div class="col-md-6">
                            <label for="fecha_salida" class="form-label fw-semibold">Fecha Salida</label>
                            <input type="date" class="form-control" id="fecha_salida" name="fecha_salida" required>
                        </div>

                        <div class="col-md-12">
                            <label for="monto" class="form-label fw-semibold">Monto Total</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">$</span>
                                <input type="number" step="0.01" class="form-control" id="monto" name="monto" readonly required>
                            </div>
                            <small class="text-muted">Se calcula automáticamente: días × precio por noche</small>
                        </div>

                        <div class="col-md-12">
                            <div id="disponibilidad-mensaje" class="mt-2 small"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'views/template/footer-empleado.php'; ?>

<!-- Script de gestión de reservas -->
<script src="<?php echo RUTA_PRINCIPAL; ?>assets/empleado/js/pages/reservas.js"></script>
