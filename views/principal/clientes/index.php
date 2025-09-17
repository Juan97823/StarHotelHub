<?php include_once 'views/template/header-cliente.php'; ?>

<div class="container py-4">

    <!-- Encabezado de Perfil -->
    <div class="card border-0 shadow-lg rounded-4 mb-4">
        <div class="card-body p-4 d-flex flex-column flex-md-row align-items-center bg-gradient" 
             style="background: linear-gradient(135deg, #4e73df, #1cc88a); color: #fff;">
            <div class="me-md-4 mb-3 mb-md-0 text-center">
                <img src="https://i.pravatar.cc/100?u=<?php echo $_SESSION['usuario']['id']; ?>" 
                     alt="Avatar" 
                     class="rounded-circle border border-3 border-light shadow" 
                     style="width: 90px; height: 90px; object-fit: cover;">
            </div>
            <div class="text-center text-md-start">
                <h2 class="fw-bold mb-1">¡Bienvenido, 
                    <span class="text-warning"><?php echo $_SESSION['usuario']['nombre'] ?? 'Cliente'; ?></span>!
                </h2>
                <p class="mb-0 opacity-75">Tu espacio personal para gestionar todas tus reservas en <b>StarHotel Hub</b>.</p>
            </div>
        </div>
    </div>

    <!-- Tarjetas de Resumen -->
    <div class="row g-4">
        <div class="col-12 col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 me-3" style="background: #fff3cd; color:#f6c23e;">
                        <i class='bx bxs-purchase-tag fs-4'></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted">Reservas Totales</p>
                        <h4 class="fw-bold mb-0"><?php echo $data['total_reservas']; ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 me-3" style="background: #e0f2ff; color:#36b9cc;">
                        <i class='bx bxs-time-five fs-4'></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted">Pendientes</p>
                        <h4 class="fw-bold mb-0"><?php echo $data['reservas_pendientes']; ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 me-3" style="background: #e6f8ed; color:#1cc88a;">
                        <i class='bx bxs-check-circle fs-4'></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted">Completadas</p>
                        <h4 class="fw-bold mb-0"><?php echo $data['reservas_completadas']; ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Historial de Reservas -->
    <div class="card mt-5 border-0 shadow-sm rounded-4">
        <div class="card-body">
            <h5 class="fw-bold mb-4 d-flex align-items-center">
                <i class='bx bx-history fs-5 me-2 text-primary'></i> Historial de Reservas
            </h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr class="text-uppercase small text-muted">
                            <th>#</th>
                            <th><i class='bx bxs-hotel me-1'></i>Habitación</th>
                            <th><i class='bx bxs-calendar me-1'></i>Ingreso</th>
                            <th><i class='bx bxs-calendar-check me-1'></i>Salida</th>
                            <th><i class='bx bxs-wallet me-1'></i>Monto</th>
                            <th><i class='bx bxs-info-circle me-1'></i>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data['reservas'])) : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class='bx bx-info-circle fs-2 text-primary'></i>
                                    <h5 class="mt-2 fw-bold">Aún no tienes reservas.</h5>
                                    <p class="text-muted">¿Listo para planear tu próxima estadía?</p>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($data['reservas'] as $key => $reserva) : ?>
                                <tr>
                                    <td class="fw-semibold"><?php echo $key + 1; ?></td>
                                    <td><?php echo $reserva['tipo']; ?></td>
                                    <td><?php echo date("d M, Y", strtotime($reserva['fecha_ingreso'])); ?></td>
                                    <td><?php echo date("d M, Y", strtotime($reserva['fecha_salida'])); ?></td>
                                    <td class="fw-bold text-success">$<?php echo number_format($reserva['monto_total'], 2); ?></td>
                                    <td>
                                        <?php
                                        $estadoNum = $reserva['estado'];
                                        $estadoInfo = ['texto' => 'Desconocido', 'clase' => 'bg-secondary', 'icono' => 'bx-question-mark'];

                                        if ($estadoNum == 1) {
                                            $estadoInfo = ['texto' => 'Pendiente', 'clase' => 'bg-warning text-dark', 'icono' => 'bx-time-five'];
                                        } elseif ($estadoNum == 2) {
                                            $estadoInfo = ['texto' => 'Completada', 'clase' => 'bg-success', 'icono' => 'bx-check-circle'];
                                        } elseif ($estadoNum == 0) {
                                            $estadoInfo = ['texto' => 'Cancelada', 'clase' => 'bg-danger', 'icono' => 'bx-x-circle'];
                                        }
                                        ?>
                                        <span class="badge px-3 py-2 rounded-pill d-inline-flex align-items-center <?php echo $estadoInfo['clase']; ?>">
                                            <i class="bx <?php echo $estadoInfo['icono']; ?> me-1"></i>
                                            <?php echo $estadoInfo['texto']; ?>
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
