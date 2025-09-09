<?php include_once 'views/template/header-cliente.php'; ?>

<div class="container py-4">

    <!-- Encabezado de Perfil y Bienvenida -->
    <div class="card profile-header mb-4 shadow-sm">
        <div class="card-body p-4 d-flex flex-column flex-md-row align-items-center">
            <div class="me-md-4 mb-3 mb-md-0 text-center">
                <img src="https://i.pravatar.cc/100?u=<?php echo $_SESSION['usuario']['id']; ?>" alt="Avatar" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            </div>
            <div class="text-center text-md-start">
                <h2 class="mb-0">Welcome back, <span class="fw-bold text-primary"><?php echo $_SESSION['usuario']['nombre'] ?? 'Customer'; ?>!</span></h2>
                <p class="mb-0 text-secondary">Your personal space to manage all your bookings with StarHotel Hub.</p>
            </div>
        </div>
    </div>

    <!-- Tarjetas de Resumen -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
        <div class="col">
            <div class="card radius-10 h-100 shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="widgets-icons-2 bg-light-yellow rounded-circle me-3"><i class='bx bxs-purchase-tag'></i></div>
                    <div>
                        <p class="mb-1 text-secondary">Total Reservations</p>
                        <h4 class="my-0 fw-bold"><?php echo $data['total_reservas']; ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 h-100 shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="widgets-icons-2 bg-light-blue rounded-circle me-3"><i class='bx bxs-time-five'></i></div>
                    <div>
                        <p class="mb-1 text-secondary">Pending</p>
                        <h4 class="my-0 fw-bold"><?php echo $data['reservas_pendientes']; ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 h-100 shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="widgets-icons-2 bg-light-green rounded-circle me-3"><i class='bx bxs-check-circle'></i></div>
                    <div>
                        <p class="mb-1 text-secondary">Completed</p>
                        <h4 class="my-0 fw-bold"><?php echo $data['reservas_completadas']; ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end row-->

    <!-- Tabla de Historial de Reservas -->
    <div class="card radius-10 mt-4 shadow-sm border-0">
        <div class="card-body">
            <h5 class="card-title mb-4 fw-bold"><i class='bx bx-history me-2'></i>Reservation History</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="reservasTable">
                    <thead class="table-light">
                        <tr class="text-uppercase">
                            <th>#</th>
                            <th><i class='bx bxs-hotel me-1'></i>Room</th>
                            <th><i class='bx bxs-calendar me-1'></i>Check-in</th>
                            <th><i class='bx bxs-calendar-check me-1'></i>Check-out</th>
                            <th><i class='bx bxs-wallet me-1'></i>Amount</th>
                            <th><i class='bx bxs-info-circle me-1'></i>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data['reservas'])) : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class='bx bx-info-circle fs-2 text-primary'></i>
                                    <h5 class="mt-2">You have no reservations yet.</h5>
                                    <p class="text-secondary">Ready to book your next stay?</p>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($data['reservas'] as $key => $reserva) : ?>
                                <tr>
                                    <td class="fw-bold"><?php echo $key + 1; ?></td>
                                    <td><?php echo $reserva['tipo']; ?></td>
                                    <td><?php echo date("d M, Y", strtotime($reserva['fecha_ingreso'])); ?></td>
                                    <td><?php echo date("d M, Y", strtotime($reserva['fecha_salida'])); ?></td>
                                    <td>$<?php echo number_format($reserva['monto_total'], 2); ?></td>
                                    <td>
                                        <?php
                                        $estadoNum = $reserva['estado'];
                                        $estadoInfo = ['texto' => 'Desconocido', 'clase' => 'bg-secondary', 'icono' => 'bx-question-mark'];

                                        if ($estadoNum == 1) { // Pendiente
                                            $estadoInfo = ['texto' => 'Pendiente', 'clase' => 'bg-warning text-dark', 'icono' => 'bx-time-five'];
                                        } elseif ($estadoNum == 2) { // Completada
                                            $estadoInfo = ['texto' => 'Completada', 'clase' => 'bg-success', 'icono' => 'bx-check-circle'];
                                        } elseif ($estadoNum == 0) { // Cancelada (suponiendo 0 para cancelada)
                                            $estadoInfo = ['texto' => 'Cancelada', 'clase' => 'bg-danger', 'icono' => 'bx-x-circle'];
                                        }
                                        ?>
                                        <span class="badge rounded-pill d-inline-flex align-items-center <?php echo $estadoInfo['clase']; ?>">
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
