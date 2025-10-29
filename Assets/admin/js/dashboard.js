document.addEventListener("DOMContentLoaded", function () {
  const url = base_url + "admin/dashboard/getData";

  // --- GRÁFICO DE RESERVAS ---
  const ctx = document.getElementById("graficoReservas").getContext("2d");
  const graficoReservas = new Chart(ctx, {
    type: "bar",
    data: {
      labels: [],
      datasets: [
        {
          label: "Reservas por Día",
          data: [],
          backgroundColor: "rgba(54, 162, 235, 0.5)",
          borderColor: "rgba(54, 162, 235, 1)",
          borderWidth: 1,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
    },
  });

  // --- FUNCIONES DE ACTUALIZACIÓN ---
  function actualizarIndicadores(data) {
    document.getElementById("reservasHoy").textContent =
      data.reservasHoy ?? "0";
    document.getElementById("habitacionesDisponibles").textContent =
      data.habitacionesDisponibles ?? "0";
    document.getElementById("ingresosMes").textContent = `$${Number(
      data.ingresosMes ?? 0
    ).toLocaleString("es-ES")}`;
    document.getElementById("totalClientes").textContent =
      data.totalClientes ?? "0";
  }

  function actualizarGrafico(graficoData) {
    if (!graficoData) return;
    graficoReservas.data.labels = graficoData.etiquetas;
    graficoReservas.data.datasets[0].data = graficoData.valores;
    graficoReservas.update();
  }

  function actualizarUltimasReservas(ultimasReservas) {
    const tbody = document.getElementById("ultimasReservas");
    tbody.innerHTML = "";

    if (!ultimasReservas || ultimasReservas.length === 0) {
      tbody.innerHTML =
        '<tr><td colspan="5" class="text-center">No hay reservas recientes.</td></tr>';
      return;
    }

    ultimasReservas.forEach((reserva) => {
      let estadoBadge;
      switch (reserva.estado) {
        case 1:
          estadoBadge = '<span class="badge bg-warning">Pendiente</span>';
          break;
        case 2:
          estadoBadge = '<span class="badge bg-success">Confirmada</span>';
          break;
        case 3:
          estadoBadge = '<span class="badge bg-danger">Cancelada</span>';
          break;
        default:
          estadoBadge = '<span class="badge bg-secondary">Desconocido</span>';
      }

      tbody.innerHTML += `
        <tr>
            <td>${reserva.cliente ?? "-"}</td>
            <td>${reserva.habitacion ?? "-"}</td>
            <td>${reserva.fecha_reserva ?? "-"}</td>
            <td>${estadoBadge}</td>
            <td class="text-center">
                <button class="btn btn-sm btn-primary" onclick="imprimirFactura(${reserva.id})" title="Imprimir Factura">
                    <i class="bx bx-printer"></i> Factura
                </button>
            </td>
        </tr>
    `;
    });
  }

  // Función para imprimir factura
  window.imprimirFactura = function(idReserva) {
    const url = base_url + "reserva/factura/" + idReserva;
    window.open(url, '_blank', 'width=900,height=700');
  };

  // --- CARGA DE DATOS ---
  function cargarDatosDashboard() {
    fetch(url)
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then((data) => {
        // Los datos se pasan directamente a las funciones, asumiendo una estructura plana.
        actualizarIndicadores(data);
        actualizarGrafico(data.grafico); // El controlador original usaba la clave 'grafico'
        actualizarUltimasReservas(data.ultimasReservas);
      })
      .catch((error) => {
        console.error("Error al cargar los datos del dashboard:", error);
        const dashboardContainer = document.querySelector(".container.py-5");
        if (dashboardContainer) {
          dashboardContainer.innerHTML =
            '<div class="alert alert-danger">No se pudieron cargar los datos del dashboard. Por favor, intente más tarde.</div>';
        }
      });
  }

  cargarDatosDashboard();
});
