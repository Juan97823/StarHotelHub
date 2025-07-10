<?php include_once 'views/layout/headerDashboard.php'; ?>

<div class="container py-4">
  <h2 class="mb-4">Panel de Administración</h2>

  <!-- Indicadores -->
  <div class="row text-white">
    <div class="col-md-3 mb-3">
      <div class="card bg-primary shadow">
        <div class="card-body">
          <h5>Total Reservas Hoy</h5>
          <h3 id="reservasHoy">0</h3>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card bg-success shadow">
        <div class="card-body">
          <h5>Habitaciones Disponibles</h5>
          <h3 id="habitacionesDisponibles">0</h3>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card bg-warning shadow">
        <div class="card-body">
          <h5>Ingresos del Mes</h5>
          <h3 id="ingresosMes">$0</h3>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card bg-info shadow">
        <div class="card-body">
          <h5>Total Clientes</h5>
          <h3 id="totalClientes">0</h3>
        </div>
      </div>
    </div>
  </div>

  <!-- Gráfico -->
  <div class="card mb-4">
    <div class="card-header">Reservas por Mes</div>
    <div class="card-body">
      <canvas id="graficoReservas"></canvas>
    </div>
  </div>

  <!-- Últimas Reservas -->
  <div class="card">
    <div class="card-header">Últimas 5 Reservas</div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped mb-0">
          <thead class="table-dark">
            <tr>
              <th>Cliente</th>
              <th>Habitación</th>
              <th>Fecha</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody id="ultimasReservas">
            <!-- Contenido dinámico -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="assets/principal/js/pages/dashboard.js"></script>
<?php include_once 'views/layout/footerDashboard.php'; ?>

