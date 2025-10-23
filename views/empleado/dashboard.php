<?php include_once 'views/template/header-empleado.php'; ?>

<div class="container-fluid py-4">

  <!-- Encabezado de Perfil de Empleado -->
  <div class="card border-0 shadow-lg rounded-4 mb-4" style="background: linear-gradient(135deg, #6f42c1, #20c997);">
    <div class="card-body p-4 d-flex flex-column flex-md-row align-items-center text-white">
      <div class="me-md-4 mb-3 mb-md-0 text-center">
        <i class="bx bxs-user-circle fs-1"></i>
      </div>
      <div class="text-center text-md-start">
        <h2 class="fw-bold mb-1">¡Hola, <?php echo $_SESSION['usuario']['nombre'] ?? 'Empleado'; ?>!</h2>
        <p class="mb-0 opacity-75">Este es tu centro de control para la gestión diaria del hotel.</p>
      </div>
    </div>
  </div>

  <!-- Tarjetas de Resumen Operativo -->
  <div class="row g-4">
    <div class="col-12 col-md-4">
      <div class="card h-100 border-0 shadow-sm rounded-4">
        <div class="card-body d-flex align-items-center">
          <div class="rounded-circle p-3 me-3 bg-light-primary text-primary">
            <i class='bx bx-log-in fs-4'></i>
          </div>
          <div>
            <p class="mb-1 text-muted">Check-Ins para Hoy</p>
            <h4 class="fw-bold mb-0"><?php echo $data['checkins_hoy'] ?? 0; ?></h4>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="card h-100 border-0 shadow-sm rounded-4">
        <div class="card-body d-flex align-items-center">
          <div class="rounded-circle p-3 me-3 bg-light-warning text-warning">
            <i class='bx bx-log-out fs-4'></i>
          </div>
          <div>
            <p class="mb-1 text-muted">Check-Outs para Hoy</p>
            <h4 class="fw-bold mb-0"><?php echo $data['checkouts_hoy'] ?? 0; ?></h4>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="card h-100 border-0 shadow-sm rounded-4">
        <div class="card-body d-flex align-items-center">
          <div class="rounded-circle p-3 me-3 bg-light-success text-success">
            <i class='bx bxs-bed fs-4'></i>
          </div>
          <div>
            <p class="mb-1 text-muted">Habitaciones Ocupadas</p>
            <h4 class="fw-bold mb-0"><?php echo $data['habitaciones_ocupadas'] ?? 0; ?></h4>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Actividad del Día (Llegadas y Salidas) -->
  <div class="card mt-5 border-0 shadow-sm rounded-4">
    <div class="card-body">
      <h5 class="fw-bold mb-4 d-flex align-items-center">
        <i class='bx bx-calendar-event fs-5 me-2 text-primary'></i> Actividad del Día
      </h5>
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr class="text-uppercase small text-muted">
              <th>Cliente</th>
              <th><i class='bx bxs-hotel me-1'></i>Habitación</th>
              <th><i class='bx bxs-info-circle me-1'></i>Tipo</th>
              <th><i class='bx bxs-time me-1'></i>Hora</th>
              <th><i class='bx bx-key me-1'></i>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($data['actividad_dia'])) : ?>
              <tr>
                <td colspan="5" class="text-center py-5">
                  <i class='bx bx-wind fs-2 text-primary'></i>
                  <h5 class="mt-2 fw-bold">No hay llegadas ni salidas para hoy.</h5>
                  <p class="text-muted">Todo tranquilo por ahora.</p>
                </td>
              </tr>
            <?php else : ?>
              <?php foreach ($data['actividad_dia'] as $actividad) : ?>
                <tr>
                  <td class="fw-semibold"><?php echo $actividad['nombre_cliente']; ?></td>
                  <td><?php echo $actividad['nombre_habitacion']; ?></td>
                  <td>
                    <?php
                    $esLlegada = ($actividad['tipo'] == 'llegada');
                    $claseBadge = $esLlegada ? 'bg-light-success text-success' : 'bg-light-warning text-warning';
                    $icono = $esLlegada ? 'bx-log-in' : 'bx-log-out';
                    $texto = $esLlegada ? 'Llegada' : 'Salida';
                    ?>
                    <span class="badge fs-6 rounded-pill <?php echo $claseBadge; ?> d-inline-flex align-items-center">
                      <i class="bx <?php echo $icono; ?> me-1"></i>
                      <?php echo $texto; ?>
                    </span>
                  </td>
                  <td><?php echo date("h:i A", strtotime($esLlegada ? $actividad['fecha_ingreso'] : $actividad['fecha_salida'])); ?></td>
                  <td>
                    <a href="#" class="btn btn-sm btn-outline-primary me-1 btn-view-reserva" data-id="<?php echo $actividad['id']; ?>" title="Ver Reserva"><i class="fas fa-eye"></i></a>
                    <?php if ($esLlegada && $actividad['estado'] == 1) : // 1 es Confirmada ?>
                      <a href="#" class="btn btn-sm btn-primary btn-checkin" data-id="<?php echo $actividad['id']; ?>" title="Hacer Check-In">Check-In</a>
                    <?php endif; ?>
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

<?php include_once 'views/template/footer-empleado.php'; ?>
