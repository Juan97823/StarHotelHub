document.addEventListener('DOMContentLoaded', function () {
    function cargarDatos() {
        fetch('<?php echo RUTA_PRINCIPAL; ?>empleado/dashboard/getData')
            .then(response => response.json())
            .then(data => {
                document.getElementById('reservasHoy').textContent = data.reservasHoy;
                document.getElementById('habitacionesOcupadas').textContent = data.habitacionesOcupadas;

                const ultimasReservasBody = document.getElementById('ultimasReservas');
                ultimasReservasBody.innerHTML = '';
                data.ultimasReservas.forEach(reserva => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${reserva.fecha_reserva}</td>
                        <td>${reserva.cliente}</td>
                        <td>${reserva.habitacion}</td>
                        <td><span class="badge bg-${reserva.estado == 1 ? 'success' : 'warning'}">${reserva.estado == 1 ? 'Confirmada' : 'Pendiente'}</span></td>
                    `;
                    ultimasReservasBody.appendChild(tr);
                });

                const tareasPendientesList = document.getElementById('tareasPendientes');
                tareasPendientesList.innerHTML = '';
                data.tareasPendientes.forEach(tarea => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.innerHTML = `Habitación <strong>${tarea.habitacion}</strong> (Cliente: ${tarea.cliente}) - Salida: ${tarea.fecha_salida}`;
                    tareasPendientesList.appendChild(li);
                });
            })
            .catch(error => console.error('Error al cargar los datos del dashboard:', error));
    }

    cargarDatos();
});
