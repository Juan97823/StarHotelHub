document.addEventListener("DOMContentLoaded", () => {
    if (typeof window.empleadoData === "undefined") {
        console.warn("No se encontraron datos para el empleado.");
        return;
    }

    const ctx = document.getElementById("chartReservas");
    if (!ctx) {
        console.warn("No se encontró el canvas de estadísticas.");
        return;
    }

    const data = {
        labels: [
            "Reservas Atendidas",
            "Próximas Reservas",
            "Clientes Nuevos",
            "Incidencias"
        ],
        datasets: [{
            label: "Estadísticas del empleado",
            data: [
                window.empleadoData.reservasAtendidas,
                window.empleadoData.proximasReservas,
                window.empleadoData.clientesNuevos,
                window.empleadoData.incidencias
            ],
            backgroundColor: [
                "rgba(13, 110, 253, 0.7)",
                "rgba(25, 135, 84, 0.7)",
                "rgba(255, 193, 7, 0.7)",
                "rgba(220, 53, 69, 0.7)"
            ],
            borderColor: [
                "rgb(13, 110, 253)",
                "rgb(25, 135, 84)",
                "rgb(255, 193, 7)",
                "rgb(220, 53, 69)"
            ],
            borderWidth: 1
        }]
    };

    const options = {
        responsive: true,
        plugins: {
            legend: {
                position: "bottom",
                labels: { font: { size: 14 } }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ": " + context.formattedValue;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { precision: 0 }
            }
        }
    };

    new Chart(ctx, {
        type: "bar",
        data: data,
        options: options
    });
});
