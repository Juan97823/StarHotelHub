let tableReservasEmpleado;

document.addEventListener('DOMContentLoaded', function() {
    // 1. Inicializar DataTable
    tableReservasEmpleado = new DataTable('#tableReservasEmpleado', {
        ajax: {
            url: base_url + 'empleado/listarReservas',
            dataSrc: ''
        },
        columns: [
            { data: 'id' },
            { data: 'estilo_habitacion' }, 
            { data: 'nombre_cliente' },
            { data: 'fecha_ingreso' },
            { data: 'fecha_salida' },
            { data: 'monto' },
            {
                data: 'estado',
                render: function(data) {
                    let badgeClass = 'bg-light-secondary';
                    if (data === 'Confirmada') badgeClass = 'bg-light-success';
                    if (data === 'Activa') badgeClass = 'bg-light-primary';
                    if (data === 'Completada') badgeClass = 'bg-light-info';
                    if (data === 'Cancelada') badgeClass = 'bg-light-danger';
                    return `<span class="badge rounded-pill ${badgeClass}">${data}</span>`;
                }
            },
            { 
                data: null,
                render: function(data, type, row) {
                    return generarBotones(row);
                }
            }
        ],
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
        }
    });

    // 2. Manejar clic en "Nueva Reserva"
    document.querySelector('#btnNuevaReservaEmpleado').addEventListener('click', function() {
        document.querySelector('#reservaEmpleadoForm').reset();
        document.querySelector('#idReserva').value = '';
        document.querySelector('#reservaEmpleadoModalLabel').textContent = 'Nueva Reserva';
        new bootstrap.Modal(document.getElementById('reservaEmpleadoModal')).show();
    });

    // 3. Manejar envío del formulario
    document.querySelector('#reservaEmpleadoForm').addEventListener('submit', function(e) {
        e.preventDefault();
        registrarReserva();
    });
});

// Función para generar los botones de acción según el estado
function generarBotones(reserva) {
    let botones = '<div class="d-flex justify-content-center">';
    
    // Siempre se puede ver el detalle
    botones += `<button class="btn btn-sm btn-info me-1" onclick="verReserva(${reserva.id})"><i class="fas fa-eye"></i></button>`;

    switch (reserva.estado) {
        case 'Confirmada':
            botones += `<button class="btn btn-sm btn-success me-1" onclick="realizarCheckIn(${reserva.id})">Check-In</button>`;
            botones += `<button class="btn btn-sm btn-warning me-1" onclick="editarReserva(${reserva.id})"><i class="fas fa-edit"></i></button>`;
            botones += `<button class="btn btn-sm btn-danger" onclick="cancelarReserva(${reserva.id})"><i class="fas fa-times"></i></button>`;
            break;
        case 'Activa':
            botones += `<button class="btn btn-sm btn-primary" onclick="realizarCheckOut(${reserva.id})">Check-Out</button>`;
            break;
        case 'Completada':
        case 'Cancelada':
            // No hay acciones para reservas completadas o canceladas, solo ver
            break;
    }
    
    botones += '</div>';
    return botones;
}

// Funciones de acción
function registrarReserva() {
    const url = base_url + 'empleado/registrarReserva';
    const data = new FormData(document.getElementById('reservaEmpleadoForm'));

    fetch(url, {
        method: 'POST',
        body: data
    })
    .then(response => response.json())
    .then(res => {
        if (res.status) {
            Swal.fire('Éxito', res.msg, 'success');
            bootstrap.Modal.getInstance(document.getElementById('reservaEmpleadoModal')).hide();
            tableReservasEmpleado.ajax.reload();
        } else {
            Swal.fire('Error', res.msg, 'error');
        }
    });
}

function verReserva(idReserva) {
    // Aquí podrías mostrar un modal con toda la información detallada
    Swal.fire('Info', `Viendo detalles de la reserva ${idReserva}. Funcionalidad a implementar.`, 'info');
}

function editarReserva(idReserva) {
    fetch(base_url + `empleado/getReserva/${idReserva}`)
        .then(response => response.json())
        .then(res => {
            if (res) {
                document.querySelector('#idReserva').value = res.id;
                document.querySelector('#habitacion').value = res.id_habitacion;
                document.querySelector('#cliente').value = res.id_cliente;
                document.querySelector('#fecha_ingreso').value = res.fecha_ingreso;
                document.querySelector('#fecha_salida').value = res.fecha_salida;
                document.querySelector('#monto').value = res.monto;
                document.querySelector('#reservaEmpleadoModalLabel').textContent = 'Editar Reserva';
                new bootstrap.Modal(document.getElementById('reservaEmpleadoModal')).show();
            } else {
                Swal.fire('Error', 'No se pudo cargar la información de la reserva.', 'error');
            }
        });
}

function cambiarEstadoReserva(idReserva, nuevoEstado, accionTexto) {
    Swal.fire({
        title: `¿Estás seguro de realizar el ${accionTexto}?`,
        text: "Esta acción cambiará el estado de la reserva.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: `Sí, realizar ${accionTexto}`,
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + `empleado/actualizarEstadoReserva/${idReserva}/${nuevoEstado}`;
            fetch(url)
                .then(response => response.json())
                .then(res => {
                    if (res.status) {
                        Swal.fire('Éxito', res.msg, 'success');
                        tableReservasEmpleado.ajax.reload();
                    } else {
                        Swal.fire('Error', res.msg, 'error');
                    }
                });
        }
    });
}

function realizarCheckIn(idReserva) {
    cambiarEstadoReserva(idReserva, 'Activa', 'Check-In');
}

function realizarCheckOut(idReserva) {
    cambiarEstadoReserva(idReserva, 'Completada', 'Check-Out');
}

function cancelarReserva(idReserva) {
    cambiarEstadoReserva(idReserva, 'Cancelada', 'Cancelación');
}
