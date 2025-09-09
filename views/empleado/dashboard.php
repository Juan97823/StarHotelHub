<?php include_once 'views/template/header-empleado.php'; ?>

<div class="container-fluid px-4">
  <h1 class="mt-4">Panel de Empleado</h1>
  <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item"><a href="<?php echo RUTA_PRINCIPAL; ?>empleado">Inicio</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
  </ol>

  <p class="mb-4">Bienvenido, <strong><?php echo $data['nombre_usuario']; ?></strong>. Aquí podrás gestionar tus tareas diarias de manera rápida y sencilla.</p>

  <!-- Resumen rápido -->
  <div class="row">
      <div class="col-xl-3 col-md-6">
          <div class="card bg-primary text-white mb-4">
              <div class="card-body">
                  Reservas Atendidas
                  <h3><?php echo $data['reservas_atendidas'] ?? 0; ?></h3>
              </div>
          </div>
      </div>
      <div class="col-xl-3 col-md-6">
          <div class="card bg-success text-white mb-4">
              <div class="card-body">
                  Próximas Reservas
                  <h3><?php echo $data['proximas_reservas'] ?? 0; ?></h3>
              </div>
          </div>
      </div>
      <div class="col-xl-3 col-md-6">
          <div class="card bg-warning text-white mb-4">
              <div class="card-body">
                  Clientes Nuevos
                  <h3><?php echo $data['clientes_nuevos'] ?? 0; ?></h3>
              </div>
          </div>
      </div>
      <div class="col-xl-3 col-md-6">
          <div class="card bg-danger text-white mb-4">
              <div class="card-body">
                  Incidencias
                  <h3><?php echo $data['incidencias'] ?? 0; ?></h3>
              </div>
          </div>
      </div>
  </div>

  <!-- Acciones rápidas -->
  <div class="row">
      <div class="col-md-4 mb-3">
          <a href="<?php echo RUTA_PRINCIPAL; ?>empleado/reservas" class="btn btn-outline-primary w-100">
              📅 Ver Reservas
          </a>
      </div>
      <div class="col-md-4 mb-3">
          <a href="<?php echo RUTA_PRINCIPAL; ?>empleado/clientes" class="btn btn-outline-success w-100">
              👤 Registrar Cliente
          </a>
      </div>
      <div class="col-md-4 mb-3">
          <a href="<?php echo RUTA_PRINCIPAL; ?>empleado/incidencias" class="btn btn-outline-danger w-100">
              ⚠️ Reportar Incidencia
          </a>
      </div>
  </div>

  <!-- Estadísticas con Chart.js -->
  <div class="card mb-4">
      <div class="card-header">
          <i class="fas fa-chart-area me-1"></i>
          Estadísticas de Reservas
      </div>
      <div class="card-body"><canvas id="chartReservas" width="100%" height="30"></canvas></div>
  </div>
</div>

<!-- Script de inactividad -->
<script src="<?php echo RUTA_PRINCIPAL; ?>assets/principal/js/page/inactivity.js"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById("chartReservas");
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"],
                datasets: [{
                    label: "Reservas Atendidas",
                    data: [12, 19, 3, 5, 2], // puedes traer datos dinámicos de PHP
                    borderColor: "rgba(75, 192, 192, 1)",
                    fill: false,
                    tension: 0.1
                }]
            }
        });
    }
});
</script>

<?php include_once 'views/template/footer-empleado.php'; ?>
