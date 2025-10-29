document.addEventListener("DOMContentLoaded", function () {
  fetch(base_url + "admin/dashboardData")
    .then((res) => res.json())
    .then((data) => {
      // Indicadores
      document.getElementById("reservasHoy").innerText = data.reservasHoy;
      document.getElementById("habitacionesDisponibles").innerText = data.habitacionesDisponibles;
      document.getElementById("ingresosMes").innerText = "$" + data.ingresosMes;
      document.getElementById("totalClientes").innerText = data.totalClientes;

      // Tabla últimas reservas
      const tbody = document.getElementById("ultimasReservas");
      tbody.innerHTML = "";
      data.ultimasReservas.forEach((r) => {
        const fila = `
          <tr>
            <td>${r.cliente}</td>
            <td>${r.habitacion}</td>
            <td>${r.fecha_reserva}</td>
            <td>${r.estado}</td>
          </tr>`;
        tbody.innerHTML += fila;
      });

      // Gráfico de reservas por mes
      const meses = [
        "Ene", "Feb", "Mar", "Abr", "May", "Jun",
        "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"
      ];

      const etiquetas = new Array(12).fill(0).map((_, i) => meses[i]);
      const datos = new Array(12).fill(0);

      data.reservasMensuales.forEach((r) => {
        const index = r.mes - 1;
        datos[index] = r.total;
      });

      const ctx = document.getElementById("graficoReservas").getContext("2d");
      new Chart(ctx, {
        type: "bar",
        data: {
          labels: etiquetas,
          datasets: [{
            label: "Reservas",
            data: datos,
            backgroundColor: "#007bff"
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: ctx => `Reservas: ${ctx.raw}` } }
          }
        }
      });
    })
    .catch((err) => {
      console.error("Error al cargar dashboard:", err);
    });
});