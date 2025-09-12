// dashboard.js (Vanilla JS)
document.addEventListener("DOMContentLoaded", function () {
    const reservasHoyEl = document.getElementById("reservasHoy");
    const habitacionesDisponiblesEl = document.getElementById("habitacionesDisponibles");
    const ingresosMesEl = document.getElementById("ingresosMes");
    const totalClientesEl = document.getElementById("totalClientes");
    const ultimasReservasEl = document.getElementById("ultimasReservas");
    const graficoCtx = document.getElementById("graficoReservas").getContext("2d");
    let grafico;

    async function cargarDatosDashboard() {
        try {
            const response = await fetch(`${base_url}admin/dashboard/getData`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const data = await response.json();

            // Actualizar indicadores
            reservasHoyEl.textContent = data.reservasHoy ?? 0;
            habitacionesDisponiblesEl.textContent = data.habitacionesDisponibles ?? 0;
            ingresosMesEl.textContent = `$${data.ingresosMes ?? 0}`;
            totalClientesEl.textContent = data.totalClientes ?? 0;

            // Actualizar gráfico
            if (grafico) grafico.destroy();
            grafico = new Chart(graficoCtx, {
                type: "bar",
                data: {
                    labels: data.grafico.etiquetas,
                    datasets: [{
                        label: "Reservas",
                        data: data.grafico.valores,
                        backgroundColor: "rgba(54, 162, 235, 0.7)",
                        borderColor: "rgba(54, 162, 235, 1)",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { mode: 'index', intersect: false }
                    },
                    scales: {
                        y: { beginAtZero: true, precision: 0 }
                    }
                }
            });

            // Actualizar últimas reservas
            ultimasReservasEl.innerHTML = "";
            data.ultimasReservas.forEach(reserva => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${reserva.cliente}</td>
                    <td>${reserva.habitacion}</td>
                    <td>${reserva.fecha_reserva}</td>
                    <td>${reserva.estado}</td>
                `;
                ultimasReservasEl.appendChild(tr);
            });

        } catch (error) {
            console.error("Error al cargar el dashboard:", error);
            alert("Error al cargar el dashboard. Revisa la consola para más detalles.");
        }
    }

    // Cargar datos al iniciar
    cargarDatosDashboard();

    // Recarga automática cada 30 segundos
    setInterval(cargarDatosDashboard, 30000);
});
