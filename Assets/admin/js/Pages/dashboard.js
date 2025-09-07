document.addEventListener('DOMContentLoaded', function () {
    // URL base de tu proyecto
    const rutaPrincipal = 'http://localhost/Starhotelhub/'; 

    // Endpoint correcto en el controlador Admin.php
    const dataUrl = `${rutaPrincipal}admin/getData`;

    let graficoReservas;

    async function cargarDatosDashboard() {
        try {
            const response = await fetch(dataUrl);
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            const datos = await response.json();

            actualizarTarjetas(datos);
            crearGrafico(datos.grafico);
            llenarTabla(datos.ultimasReservas);

        } catch (error) {
            console.error('Error fatal al cargar datos para el dashboard:', error);
            mostrarError();
        }
    }

    function actualizarTarjetas(datos) {
        document.getElementById('reservasHoy').textContent = datos.reservasHoy || 0;
        document.getElementById('habitacionesDisponibles').textContent = datos.habitacionesDisponibles || 0;
        const ingresos = parseFloat(datos.ingresosMes || 0);
        document.getElementById('ingresosMes').textContent = `$${ingresos.toLocaleString('es-CO')}`;
        document.getElementById('totalClientes').textContent = datos.totalClientes || 0;
    }

    function crearGrafico(graficoData) {
        const ctx = document.getElementById('graficoReservas').getContext('2d');
        
        if (graficoReservas) {
            graficoReservas.destroy();
        }

        graficoReservas = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: graficoData.etiquetas,
                datasets: [{
                    label: 'Reservas en la Última Semana',
                    data: graficoData.valores,
                    backgroundColor: 'rgba(90, 158, 249, 0.5)',
                    borderColor: 'rgba(90, 158, 249, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    }

    function llenarTabla(reservas) {
        const tablaBody = document.getElementById('ultimasReservas');
        tablaBody.innerHTML = '';

        if (!reservas || reservas.length === 0) {
            tablaBody.innerHTML = '<tr><td colspan="4" class="text-center">No hay reservas recientes.</td></tr>';
            return;
        }

        reservas.forEach(reserva => {
            const fecha = new Date(reserva.fecha_reserva).toLocaleDateString('es-ES', { day: '2-digit', month: 'short', year: 'numeric' });
            
            let estadoBadge;
            switch (parseInt(reserva.estado, 10)) {
                case 1: estadoBadge = '<span class="badge bg-success">Confirmada</span>'; break;
                case 2: estadoBadge = '<span class="badge bg-warning text-dark">Pendiente</span>'; break;
                case 0: estadoBadge = '<span class="badge bg-danger">Cancelada</span>'; break;
                default: estadoBadge = '<span class="badge bg-secondary">Desconocido</span>';
            }

            const fila = `<tr>
                            <td>${reserva.cliente}</td>
                            <td>${reserva.habitacion}</td>
                            <td>${fecha}</td>
                            <td>${estadoBadge}</td>
                          </tr>`;
            tablaBody.innerHTML += fila;
        });
    }

    function mostrarError() {
        const container = document.querySelector('.container.py-4');
        if (container) {
            container.innerHTML = '<div class="alert alert-danger" role="alert">' +
                                  '<strong>Error de Conexión:</strong> No se pudo cargar la información del dashboard. ' +
                                  'Asegúrese de que el servidor está en marcha y la ruta del controlador es correcta (admin/getData).' +
                                  '</div>';
        }
    }

    cargarDatosDashboard();
});
