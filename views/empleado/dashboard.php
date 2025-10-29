<?php include_once 'views/template/header-empleado.php'; ?>

<div class="container-fluid py-4">

  <!-- Encabezado de Bienvenida -->
  <div class="card border-0 shadow-lg rounded-4 mb-4"
    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="card-body p-4 d-flex flex-column flex-md-row align-items-center justify-content-between text-white">
      <div class="d-flex align-items-center mb-3 mb-md-0">
        <div class="me-3">
          <i class="bx bxs-user-circle fs-1"></i>
        </div>
        <div>
          <h2 class="fw-bold mb-1">¡Bienvenido, <?php echo $_SESSION['usuario']['nombre'] ?? 'Empleado'; ?>!</h2>
          <p class="mb-0 opacity-75">Hoy es <?php echo date('l, d \d\e F \d\e Y', time()); ?></p>
        </div>
      </div>
      <div class="text-end">
        <p class="mb-0 opacity-75">Hora actual: <span id="hora-actual" class="fw-bold">--:--</span></p>
      </div>
    </div>
  </div>

  <!-- Tarjetas de Resumen Operativo -->
  <div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body d-flex align-items-center">
          <div class="rounded-circle p-3 me-3" style="background-color: #e3f2fd;">
            <i class='bx bx-log-in fs-4' style="color: #1976d2;"></i>
          </div>
          <div>
            <p class="mb-1 text-muted small">Check-Ins Hoy</p>
            <h3 class="fw-bold mb-0"><?php echo $data['checkins_hoy'] ?? 0; ?></h3>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body d-flex align-items-center">
          <div class="rounded-circle p-3 me-3" style="background-color: #fff3e0;">
            <i class='bx bx-log-out fs-4' style="color: #f57c00;"></i>
          </div>
          <div>
            <p class="mb-1 text-muted small">Check-Outs Hoy</p>
            <h3 class="fw-bold mb-0"><?php echo $data['checkouts_hoy'] ?? 0; ?></h3>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body d-flex align-items-center">
          <div class="rounded-circle p-3 me-3" style="background-color: #e8f5e9;">
            <i class='bx bxs-bed fs-4' style="color: #388e3c;"></i>
          </div>
          <div>
            <p class="mb-1 text-muted small">Ocupadas</p>
            <h3 class="fw-bold mb-0"><?php echo $data['habitaciones_ocupadas'] ?? 0; ?></h3>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body d-flex align-items-center">
          <div class="rounded-circle p-3 me-3" style="background-color: #f3e5f5;">
            <i class='bx bxs-hotel fs-4' style="color: #7b1fa2;"></i>
          </div>
          <div>
            <p class="mb-1 text-muted small">Disponibles</p>
            <h3 class="fw-bold mb-0"><?php echo $data['habitaciones_disponibles'] ?? 0; ?></h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Sección de Actividad del Día -->
  <div class="row g-4">
    <!-- Llegadas Esperadas -->
    <div class="col-12 col-lg-6">
      <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-light border-0 p-4">
          <h5 class="fw-bold mb-0 d-flex align-items-center">
            <i class='bx bx-log-in fs-5 me-2' style="color: #1976d2;"></i> Llegadas Esperadas Hoy
          </h5>
        </div>
        <div class="card-body p-0">
          <?php if (empty($data['llegadas_hoy'])): ?>
            <div class="text-center py-5">
              <i class='bx bx-wind fs-2 text-muted'></i>
              <p class="text-muted mt-2">No hay llegadas programadas</p>
            </div>
          <?php else: ?>
            <div class="list-group list-group-flush">
              <?php foreach ($data['llegadas_hoy'] as $llegada): ?>
                <div class="list-group-item px-4 py-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-start">
                    <div>
                      <h6 class="fw-bold mb-1"><?php echo $llegada['nombre_cliente']; ?></h6>
                      <p class="mb-1 small text-muted">
                        <i class='bx bxs-hotel me-1'></i><?php echo $llegada['nombre_habitacion']; ?>
                      </p>
                      <p class="mb-0 small text-muted">
                        <i
                          class='bx bx-calendar me-1'></i><?php echo date("d/m/Y", strtotime($llegada['fecha_ingreso'])); ?>
                      </p>
                    </div>
                    <div class="d-flex gap-2 align-items-center">
                      <span class="badge bg-success">Confirmada</span>
                      <button class="btn btn-sm btn-primary" onclick="imprimirFactura(<?php echo $llegada['id_reserva']; ?>)" title="Imprimir Factura">
                        <i class='bx bx-printer'></i>
                      </button>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Salidas Esperadas -->
    <div class="col-12 col-lg-6">
      <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-light border-0 p-4">
          <h5 class="fw-bold mb-0 d-flex align-items-center">
            <i class='bx bx-log-out fs-5 me-2' style="color: #f57c00;"></i> Salidas Esperadas Hoy
          </h5>
        </div>
        <div class="card-body p-0">
          <?php if (empty($data['salidas_hoy'])): ?>
            <div class="text-center py-5">
              <i class='bx bx-wind fs-2 text-muted'></i>
              <p class="text-muted mt-2">No hay salidas programadas</p>
            </div>
          <?php else: ?>
            <div class="list-group list-group-flush">
              <?php foreach ($data['salidas_hoy'] as $salida): ?>
                <div class="list-group-item px-4 py-3 border-bottom">
                  <div class="d-flex justify-content-between align-items-start">
                    <div>
                      <h6 class="fw-bold mb-1"><?php echo $salida['nombre_cliente']; ?></h6>
                      <p class="mb-1 small text-muted">
                        <i class='bx bxs-hotel me-1'></i><?php echo $salida['nombre_habitacion']; ?>
                      </p>
                      <p class="mb-0 small text-muted">
                        <i class='bx bx-calendar me-1'></i><?php echo date("d/m/Y", strtotime($salida['fecha_salida'])); ?>
                      </p>
                    </div>
                    <div class="d-flex gap-2 align-items-center">
                      <span class="badge bg-warning">Activa</span>
                      <button class="btn btn-sm btn-primary" onclick="imprimirFactura(<?php echo $salida['id_reserva']; ?>)" title="Imprimir Factura">
                        <i class='bx bx-printer'></i>
                      </button>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Acciones Rápidas -->
  <div class="row g-4 mt-4">
    <div class="col-12">
      <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-light border-0 p-4">
          <h5 class="fw-bold mb-0 d-flex align-items-center">
            <i class='bx bx-lightning-bolt fs-5 me-2' style="color: #fbc02d;"></i> Acciones Rápidas
          </h5>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-12 col-sm-6 col-lg-3">
              <a href="<?php echo RUTA_PRINCIPAL; ?>empleado/reservas"
                class="btn btn-outline-primary w-100 py-3 rounded-4">
                <i class='bx bx-plus-circle me-2'></i> Nueva Reserva
              </a>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
              <a href="<?php echo RUTA_PRINCIPAL; ?>empleado/reservas"
                class="btn btn-outline-info w-100 py-3 rounded-4">
                <i class='bx bx-list-check me-2'></i> Gestionar Reservas
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <?php include_once 'views/template/footer-empleado.php'; ?>

  <script>
    // Actualizar hora en tiempo real
    function actualizarHora() {
      const ahora = new Date();
      const horas = String(ahora.getHours()).padStart(2, '0');
      const minutos = String(ahora.getMinutes()).padStart(2, '0');
      document.getElementById('hora-actual').textContent = horas + ':' + minutos;
    }

    actualizarHora();
    setInterval(actualizarHora, 1000);

    // Función para imprimir factura
    function imprimirFactura(idReserva) {
      const baseUrl = "<?php echo RUTA_PRINCIPAL; ?>";
      const url = baseUrl + "reserva/factura/" + idReserva;
      window.open(url, '_blank', 'width=900,height=700');
    }
  </script>