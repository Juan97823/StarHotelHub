<?php include_once 'views/template/header-admin.php'; ?>

<div class="container py-4">
  <h2 class="mb-4">Panel de Administración</h2>

  <!-- Indicadores -->
  <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
    <div class="col">
      <div class="card radius-10 border-start border-0 border-3 border-info">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div>
              <p class="mb-0 text-secondary">Total Reservas Hoy</p>
              <h4 class="my-1 text-info" id="reservasHoy">0</h4>
              <p class="mb-0 font-13">+2.5% desde la semana pasada</p>
            </div>
            <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i class='bx bxs-bed'></i></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card radius-10 border-start border-0 border-3 border-success">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div>
              <p class="mb-0 text-secondary">Habitaciones Disponibles</p>
              <h4 class="my-1 text-success" id="habitacionesDisponibles">0</h4>
              <p class="mb-0 font-13">+3.2% desde la semana pasada</p>
            </div>
            <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class='bx bxs-hotel'></i></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card radius-10 border-start border-0 border-3 border-warning">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div>
              <p class="mb-0 text-secondary">Ingresos del Mes</p>
              <h4 class="my-1 text-warning" id="ingresosMes">$0</h4>
              <p class="mb-0 font-13">+5.4% desde la semana pasada</p>
            </div>
            <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto"><i class='bx bxs-wallet'></i></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card radius-10 border-start border-0 border-3 border-info">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div>
              <p class="mb-0 text-secondary">Total Clientes</p>
              <h4 class="my-1 text-info" id="totalClientes">0</h4>
              <p class="mb-0 font-13">+8.4% desde la semana pasada</p>
            </div>
            <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i class='bx bxs-group'></i></div>
          </div>
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

<?php include_once 'views/template/footer-admin.php'; ?>