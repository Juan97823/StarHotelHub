<?php include_once 'views/template/header-admin.php'; ?>

<div class="container py-5">
  <h2 class="mb-5 fw-bold text-dark">Panel de Administración</h2>

  <!-- Indicadores -->
  <div class="row g-4 row-cols-1 row-cols-md-2 row-cols-xl-4">
    <!-- Reservas Hoy -->
    <div class="col">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body d-flex align-items-center">
          <div>
            <p class="text-muted mb-1">Reservas Hoy</p>
            <h3 class="fw-bold text-primary" id="reservasHoy">0</h3>
            <small class="text-success">+2.5% desde la semana pasada</small>
          </div>
          <div class="ms-auto bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
            style="width:60px; height:60px;">
            <i class='bx bxs-bed fs-3'></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Habitaciones Disponibles -->
    <div class="col">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body d-flex align-items-center">
          <div>
            <p class="text-muted mb-1">Habitaciones Disponibles</p>
            <h3 class="fw-bold text-success" id="habitacionesDisponibles">0</h3>
            <small class="text-success">+3.2% desde la semana pasada</small>
          </div>
          <div class="ms-auto bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
            style="width:60px; height:60px;">
            <i class='bx bxs-hotel fs-3'></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Ingresos del Mes -->
    <div class="col">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body d-flex align-items-center">
          <div>
            <p class="text-muted mb-1">Ingresos del Mes</p>
            <h3 class="fw-bold text-warning" id="ingresosMes">$0</h3>
            <small class="text-success">+5.4% desde la semana pasada</small>
          </div>
          <div class="ms-auto bg-warning text-white rounded-circle d-flex align-items-center justify-content-center"
            style="width:60px; height:60px;">
            <i class='bx bxs-wallet fs-3'></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Clientes -->
    <div class="col">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body d-flex align-items-center">
          <div>
            <p class="text-muted mb-1">Total Clientes</p>
            <h3 class="fw-bold text-info" id="totalClientes">0</h3>
            <small class="text-success">+8.4% desde la semana pasada</small>
          </div>
          <div class="ms-auto bg-info text-white rounded-circle d-flex align-items-center justify-content-center"
            style="width:60px; height:60px;">
            <i class='bx bxs-group fs-3'></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Gráfico Reservas -->
  <div class="card shadow-sm mt-5">
    <div class="card-header bg-light fw-bold">Reservas Última Semana</div>
    <div class="card-body">
      <canvas id="graficoReservas" height="120"></canvas>
    </div>
  </div>

  <!-- Últimas Reservas -->
  <div class="card shadow-sm mt-4">
    <div class="card-header bg-light fw-bold">Últimas 5 Reservas</div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
          <thead class="table-dark">
            <tr>
              <th>Cliente</th>
              <th>Habitación</th>
              <th>Fecha</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody id="ultimasReservas">
            <!-- Contenido cargado dinámicamente -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?php echo RUTA_PRINCIPAL; ?>assets/admin/js/dashboard.js"></script>

<?php include_once 'views/template/footer-admin.php'; ?>