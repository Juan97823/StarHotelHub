<?php require_once 'views/template/header-cliente.php'; ?>

<div class="page-wrapper">
    <div class="page-content">

        <!-- Encabezado -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Cliente</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="<?php echo RUTA_PRINCIPAL . 'index.php?url=cliente/dashboard'; ?>"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Mis Reservas</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Card principal -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Mis Reservas</h5>
            </div>
            <div class="card-body">

                <!-- Tabla de reservas -->
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Habitación</th>
                                <th>Fecha Entrada</th>
                                <th>Fecha Salida</th>
                                <th>Precio</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($data['reservas'])): ?>
                            <?php foreach ($data['reservas'] as $index => $reserva): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo $reserva['habitacion']; ?></td>
                                    <td><?php echo $reserva['fecha_entrada']; ?></td>
                                    <td><?php echo $reserva['fecha_salida']; ?></td>
                                    <td>$<?php echo number_format($reserva['precio'], 0, ',', '.'); ?></td>
                                    <td>
                                        <?php if ($reserva['estado'] === 'Confirmada'): ?>
                                            <span class="badge bg-success">Confirmada</span>
                                        <?php elseif ($reserva['estado'] === 'Pendiente'): ?>
                                            <span class="badge bg-warning text-dark">Pendiente</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Cancelada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo RUTA_PRINCIPAL . 'index.php?url=cliente/reservaDetalle&id=' . $reserva['id']; ?>" class="btn btn-sm btn-primary">
                                            <i class="bx bx-show"></i> Ver
                                        </a>
                                        <?php if ($reserva['estado'] === 'Confirmada' || $reserva['estado'] === 'Pendiente'): ?>
                                            <a href="<?php echo RUTA_PRINCIPAL . 'index.php?url=cliente/cancelarReserva&id=' . $reserva['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas cancelar esta reserva?')">
                                                <i class="bx bx-x-circle"></i> Cancelar
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No tienes reservas registradas.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

<?php require_once 'views/template/footer-cliente.php'; ?>
