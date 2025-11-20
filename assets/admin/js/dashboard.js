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
  function actualizarIndicadores(indicadores) {
    if (!indicadores) return;
    document.getElementById("reservasHoy").textContent =
      indicadores.reservasHoy ?? "0";
    document.getElementById("habitacionesDisponibles").textContent =
      indicadores.habitacionesDisponibles ?? "0";
    document.getElementById("ingresosMes").textContent = `$${
      indicadores.ingresosMes ?? "0"
    }`;
    document.getElementById("totalClientes").textContent =
      indicadores.totalClientes ?? "0";
  }

  function actualizarGrafico(graficoData) {
    if (!graficoData) return;
    graficoReservas.data.labels = graficoData.labels ?? [];
    graficoReservas.data.datasets[0].data = graficoData.data ?? [];
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
        case 0:
          estadoBadge = '<span class="badge bg-warning">Pendiente</span>';
          break;
        case 1:
          estadoBadge = '<span class="badge bg-success">Confirmada</span>';
          break;
        case 2:
          estadoBadge = '<span class="badge bg-info">Completada</span>';
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
        // Actualizar cada sección con los datos correctos
        actualizarIndicadores(data.indicadores);
        actualizarGrafico(data.graficoReservas);
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
