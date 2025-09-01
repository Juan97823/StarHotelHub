<?php include_once 'views/template/header-admin.php'; ?>

<div class="container py-4">
    <h2 class="welcome-text">Dashboard</h2>
    <p class="text-secondary">Welcome back, <?php echo $_SESSION['usuario']['nombre'] ?? 'Sarah'; ?>! Here's a summary of your hotel's activity.</p>

    <!-- Tarjetas de Resumen -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3">
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Reservations</p>
                            <h4 class="my-1"><?php echo $data['total_reservas']; ?></h4>
                        </div>
                        <div class="widgets-icons-2 bg-light-yellow text-white ms-auto"><i class='bx bxs-purchase-tag'></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Revenue</p>
                            <h4 class="my-1">$<?php echo $data['ingresos_totales']; ?></h4>
                        </div>
                        <div class="widgets-icons-2 bg-light-green text-white ms-auto"><i class='bx bxs-wallet'></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Active Customers</p>
                            <h4 class="my-1"><?php echo $data['total_clientes']; ?></h4>
                        </div>
                        <div class="widgets-icons-2 bg-light-blue text-white ms-auto"><i class='bx bxs-group'></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end row-->

    <h4 class="mb-0 mt-4">Reservations Overview</h4>

    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card radius-10">
                <div class="card-body">
                    <h6 class="mb-0">Monthly Reservations</h6>
                    <div class="chart-container-1 mt-4" style="height: 300px;">
                        <canvas id="reservationsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card radius-10">
                <div class="card-body">
                    <h6 class="mb-0">Reservations Status</h6>
                    <div class="chart-container-2 mt-4" style="height: 300px;">
                        <canvas id="realTimeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end row-->
</div>

<?php include_once 'views/template/footer-admin.php'; ?>

<!-- Script para los Gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- GRÁFICO DE LÍNEAS (Reservas Mensuales) ---
        var ctxLine = document.getElementById('reservationsChart').getContext('2d');
        var reservationsChart = new Chart(ctxLine, {
            type: 'line', // Cambiado a gráfico de líneas
            data: {
                labels: <?php echo $data['chart_labels']; ?>,
                datasets: [{
                    label: 'Monthly Reservations',
                    data: <?php echo $data['chart_values']; ?>,
                    backgroundColor: 'rgba(255, 189, 51, 0.2)', // Relleno amarillo claro
                    borderColor: '#ffbd33', // Línea dorada
                    tension: 0.4, // Líneas curvas
                    fill: true
                }]
            },
            options: {
                scales: { y: { beginAtZero: true } },
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });

        // --- GRÁFICO DE DONA (Métricas en Tiempo Real) ---
        var ctxDoughnut = document.getElementById('realTimeChart').getContext('2d');
        var realTimeChart = new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: ['Pendientes', 'Completadas', 'Canceladas'],
                datasets: [{
                    label: 'Estado de Reservas',
                    data: [0, 0, 0], // Iniciar en cero
                    backgroundColor: [
                        '#ffab00', // Amarillo
                        '#4caf50', // Verde
                        '#f44336'  // Rojo
                    ],
                    borderColor: '#ffffff',
                    borderWidth: 2
                }]
            },
            options: { 
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });

        // --- LÓGICA DE ACTUALIZACIÓN EN TIEMPO REAL ---
        async function actualizarMetricas() {
            try {
                const response = await fetch('<?php echo RUTA_PRINCIPAL; ?>admin/metricasEnTiempoReal');
                if (!response.ok) throw new Error('Network response was not ok.');
                const metricas = await response.json();
                
                realTimeChart.data.datasets[0].data = [
                    metricas.pendientes,
                    metricas.completadas,
                    metricas.canceladas
                ];
                realTimeChart.update();

            } catch (error) {
                console.error('Fetch error:', error);
            }
        }

        actualizarMetricas();
        setInterval(actualizarMetricas, 10000);
    });
</script>
