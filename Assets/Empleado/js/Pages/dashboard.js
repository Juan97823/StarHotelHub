// Assets/empleado/js/pages/dashboard.js
document.addEventListener("DOMContentLoaded", function () {
    const reservasHoyEl = document.getElementById("reservasHoy");
    const habitacionesDisponiblesEl = document.getElementById("habitacionesDisponibles");
    const totalClientesEl = document.getElementById("totalClientes");
    const ultimasReservasEl = document.getElementById("ultimasReservas");
    const graficoCtx = document.getElementById("graficoReservas").getContext("2d");
    let grafico;

    async function cargarDatosDashboard() {
        try {
            const response = await fetch(`${base_url}empleado/dashboard/getData`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const data = await response.json();

            reservasHoyEl.textContent = data.reservasHoy ?? 0;
            habitacionesDisponiblesEl.textContent = data.habitacionesDisponibles ?? 0;
            totalClientesEl.textContent = data.totalClientes ?? 0;

            // Gráfico
            if (grafico) grafico.destroy();
            grafico = new Chart(graficoCtx, {
                type: "bar",
                data: {
                    labels: data.grafico.etiquetas,
                    datasets: [{
                        label: "Mis Reservas",
                        data: data.grafico.valores,
                        backgroundColor: "rgba(54, 162, 235, 0.7)",
                        borderColor: "rgba(54, 162, 235, 1)",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false }, tooltip: { mode: 'index', intersect: false } },
                    scales: { y: { beginAtZero: true, precision: 0 } }
                }
            });

            // Últimas reservas
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
            console.error("Error al cargar el dashboard del empleado:", error);
            alert("Error al cargar el dashboard. Revisa la consola para más detalles.");
        }
    }

    cargarDatosDashboard();
    setInterval(cargarDatosDashboard, 30000);
});
