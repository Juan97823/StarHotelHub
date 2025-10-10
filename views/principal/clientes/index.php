<?php include_once 'views/template/header-cliente.php'; ?>

<div class="container py-5">

    <!-- Perfil del Cliente y Resumen -->
    <div class="row align-items-center mb-5">
        <div class="col-md-3 text-center mb-4 mb-md-0">
            <img src="https://i.pravatar.cc/150?u=<?php echo $_SESSION['usuario']['id']; ?>" alt="Avatar"
                class="rounded-circle border border-4 border-primary shadow-lg mx-auto d-block"
                style="width: 120px; height: 120px;">
        </div>
        <div class="col-md-9">
            <div class="bg-white p-4 rounded-4 shadow-sm">
                <h1 class="fw-bolder mb-2">¡Hola, <?php echo $_SESSION['usuario']['nombre'] ?? 'Cliente'; ?>!</h1>
                <p class="text-muted fs-5">Bienvenido a tu centro de control en <b>StarHotel Hub</b>.</p>
            </div>
        </div>
    </div>

    <!-- Indicadores Clave -->
    <div class="row g-4 mb-5">
        <div class="col-lg-4">
            <div class="card h-100 text-white rounded-4 shadow"
                style="background: linear-gradient(45deg, #007bff, #0056b3);">
                <div class="card-body text-center">
                    <i class='bx bxs-box fs-1 mb-2'></i>
                    <h3 class="display-4 fw-bold"><?php echo $data['total_reservas']; ?></h3>
                    <p class="fs-5 mb-0">Reservas Totales</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100 text-white rounded-4 shadow"
                style="background: linear-gradient(45deg, #ffc107, #d39e00);">
                <div class="card-body text-center">
                    <i class='bx bxs-time fs-1 mb-2'></i>
                    <h3 class="display-4 fw-bold"><?php echo $data['reservas_pendientes']; ?></h3>
                    <p class="fs-5 mb-0">Pendientes</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100 text-white rounded-4 shadow"
                style="background: linear-gradient(45deg, #28a745, #1e7e34);">
                <div class="card-body text-center">
                    <i class='bx bxs-check-square fs-1 mb-2'></i>
                    <h3 class="display-4 fw-bold"><?php echo $data['reservas_completadas']; ?></h3>
                    <p class="fs-5 mb-0">Completadas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Historial de Reservas Recientes -->
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
            <h4 class="fw-bold mb-0"><i class='bx bx-history me-2'></i>Historial de Reservas</h4>
            <a href="<?php echo RUTA_PRINCIPAL; ?>habitaciones" class="btn btn-light fw-bold">+ Nueva Reserva</a>
        </div>
        <div class="card-body p-4">
            <div class="input-group mb-4">
                <span class="input-group-text"><i class='bx bx-search'></i></span>
                <input type="text" class="form-control" placeholder="Buscar por habitación, fecha o estado...">
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-borderless align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Habitación</th>
                            <th>Ingreso</th>
                            <th>Salida</th>
                            <th>Monto</th>
                            <th class="text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data['reservas'])): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <h5>No se encontraron reservas.</h5>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($data['reservas'] as $reserva): ?>
                                <tr>
                                    <td class="fw-semibold"><?php echo $reserva['tipo']; ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($reserva['fecha_ingreso'])); ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($reserva['fecha_salida'])); ?></td>
                                    <td>$<?php echo number_format($reserva['monto_total'], 2); ?></td>
                                    <td class="text-center">
                                        <?php
                                        $estado = ['texto' => 'Cancelada', 'clase' => 'danger', 'icono' => 'x-circle'];
                                        if ($reserva['estado'] == 1)
                                            $estado = ['texto' => 'Pendiente', 'clase' => 'warning', 'icono' => 'clock'];
                                        if ($reserva['estado'] == 2)
                                            $estado = ['texto' => 'Completada', 'clase' => 'success', 'icono' => 'check-circle'];
                                        ?>
                                        <span class="badge bg-<?php echo $estado['clase']; ?>">
                                            <i
                                                class="bx bxs-<?php echo $estado['icono']; ?> me-1"></i><?php echo $estado['texto']; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/template/footer-cliente.php'; ?>