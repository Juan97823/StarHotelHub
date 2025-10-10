<?php include_once 'views/template/header-cliente.php'; ?>

<div class="container py-5">
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
            <h4 class="fw-bold mb-0"><i class='bx bx-calendar-edit me-2'></i>Gestionar Mis Reservas</h4>
            <a href="<?php echo RUTA_PRINCIPAL; ?>habitaciones" class="btn btn-light fw-bold">+ Nueva Reserva</a>
        </div>
        <div class="card-body p-4">
            <?php if (empty($data['reservas'])) : ?>
                <div class="text-center py-5">
                    <i class="bx bx-calendar-x bx-lg text-muted mb-3"></i>
                    <h5 class="mb-3">Aún no tienes reservas.</h5>
                    <p class="text-muted">¡Anímate a explorar nuestras habitaciones y encuentra tu estancia perfecta!</p>
                </div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Habitación</th>
                                <th>Fechas</th>
                                <th>Monto Total</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['reservas'] as $reserva) : ?>
                                <tr id="reserva-<?php echo $reserva['id']; ?>">
                                    <td class="fw-semibold"><?php echo $reserva['tipo']; ?></td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            <i class="bx bx-calendar-check me-1"></i>
                                            <?php echo date("d/m/y", strtotime($reserva['fecha_ingreso'])); ?>
                                        </span>
                                        <i class="bx bx-right-arrow-alt mx-1"></i>
                                        <span class="badge bg-light text-dark">
                                            <i class="bx bx-calendar-x me-1"></i>
                                            <?php echo date("d/m/y", strtotime($reserva['fecha_salida'])); ?>
                                        </span>
                                    </td>
                                    <td class="fw-bold">$<?php echo number_format($reserva['monto_total'], 2); ?></td>
                                    <td class="text-center">
                                        <?php
                                        $estado = ['texto' => 'Cancelada', 'clase' => 'danger', 'icono' => 'x-circle'];
                                        if ($reserva['estado'] == 1) $estado = ['texto' => 'Pendiente', 'clase' => 'warning', 'icono' => 'clock'];
                                        if ($reserva['estado'] == 2) $estado = ['texto' => 'Completada', 'clase' => 'success', 'icono' => 'check-circle'];
                                        ?>
                                        <span class="badge bg-<?php echo $estado['clase']; ?>-soft text-<?php echo $estado['clase']; ?> p-2">
                                            <i class="bx bxs-<?php echo $estado['icono']; ?> me-1"></i><?php echo $estado['texto']; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($reserva['estado'] == 1) : //  1 es PENDIENTE ?>
                                            <a href="<?php echo RUTA_PRINCIPAL . 'pago/reserva/' . $reserva['id']; ?>" class="btn btn-success btn-sm me-1">
                                                <i class="bx bx-credit-card me-1"></i>Pagar ahora
                                            </a>
                                            <button class="btn btn-danger btn-sm btn-cancelar" data-id="<?php echo $reserva['id']; ?>">
                                                <i class="bx bx-x-circle me-1"></i>Cancelar
                                            </button>
                                        <?php else: ?>
                                            <a href="#" class="btn btn-info btn-sm">
                                                <i class="bx bx-info-circle me-1"></i>Ver Detalle
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once 'views/template/footer-cliente.php'; ?>