let tblReservas;
let myModal;

// Esperar a que el DOM esté completamente cargado
document.addEventListener("DOMContentLoaded", function () {

    // Solo ejecutar el código de reservas si estamos en la página correcta
    if (document.getElementById('reservaModal')) {

        // Inicializar DataTable
        tblReservas = $('#tableReservas').DataTable({
            ajax: {
                url: base_url + "admin/reservas/listar",
                dataSrc: ""
            },
            columns: [
                { data: "id" },
                { data: "habitacion" },
                { data: "cliente" },
                { data: "fecha_ingreso" },
                { data: "fecha_salida" },
                { data: "monto" },
                { data: "estado" },
                { data: "acciones" }
            ],
            language: {
                url: base_url + "assets/admin/js/i18n/es-ES.json"
            },
            responsive: true,
            dom: 'Bfrtilp',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });

        // Inicializar la modal de Bootstrap
        myModal = new bootstrap.Modal(document.getElementById('reservaModal'));

        // Listeners para el cálculo automático del monto
        document.getElementById('habitacion').addEventListener('change', calcularMonto);
        document.getElementById('fecha_ingreso').addEventListener('change', calcularMonto);
        document.getElementById('fecha_salida').addEventListener('change', calcularMonto);

        // Listener para el envío del formulario
        document.getElementById('reservaForm').addEventListener('submit', guardarReserva);
    }
});

// Función para calcular el monto automáticamente
function calcularMonto() {
    const habitacionSelect = document.getElementById('habitacion');
    const fechaIngresoInput = document.getElementById('fecha_ingreso');
    const fechaSalidaInput = document.getElementById('fecha_salida');
    const montoInput = document.getElementById('monto');
    const selectedOption = habitacionSelect.options[habitacionSelect.selectedIndex];

    if (!selectedOption || !selectedOption.hasAttribute('data-precio')) {
        montoInput.value = '0.00';
        return;
    }

    const precioPorNoche = parseFloat(selectedOption.getAttribute('data-precio'));
    const fechaIngreso = new Date(fechaIngresoInput.value);
    const fechaSalida = new Date(fechaSalidaInput.value);

    if (precioPorNoche > 0 && fechaIngreso instanceof Date && !isNaN(fechaIngreso) && fechaSalida instanceof Date && !isNaN(fechaSalida) && fechaSalida > fechaIngreso) {
        const diffTime = Math.abs(fechaSalida - fechaIngreso);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        const montoTotal = diffDays * precioPorNoche;
        montoInput.value = montoTotal.toFixed(2);
    } else {
        montoInput.value = '0.00';
    }
}

// Función para el botón "Nueva Reserva"
function btnNuevaReserva() {
    document.getElementById('reservaForm').reset();
    document.getElementById('idReserva').value = "";
    document.getElementById('reservaModalLabel').textContent = "Nueva Reserva";
    document.getElementById('monto').value = '0.00';
    myModal.show();
}

// Función para el botón Editar: Cargar datos en el formulario
function btnEditarReserva(id) {
    document.getElementById('reservaModalLabel').textContent = "Editar Reserva";
    const url = base_url + "admin/reservas/obtener/" + id;
    fetch(url, { method: 'GET' })
        .then(response => response.json())
        .then(res => {
            // Rellenar el formulario con los datos obtenidos
            document.getElementById('idReserva').value = res.id;
            document.getElementById('habitacion').value = res.id_habitacion;
            document.getElementById('cliente').value = res.id_usuario;
            document.getElementById('fecha_ingreso').value = res.fecha_ingreso;
            document.getElementById('fecha_salida').value = res.fecha_salida;
            document.getElementById('monto').value = res.monto;
            myModal.show();
        })
        .catch(err => {
            Swal.fire('¡Error!', 'No se pudieron cargar los datos de la reserva.', 'error');
        });
}

// Función para guardar o actualizar una reserva
function guardarReserva(event) {
    event.preventDefault();
    const url = base_url + "admin/reservas/guardar";
    const form = document.getElementById('reservaForm');
    const data = new FormData(form);

    fetch(url, {
        method: 'POST',
        body: data
    })
        .then(response => response.json())
        .then(res => {
            if (res.msg == 'ok') {
                const idReserva = document.getElementById('idReserva').value;
                const mensaje = idReserva ? 'Reserva actualizada con éxito' : 'Reserva creada con éxito';
                Swal.fire('¡Éxito!', mensaje, 'success');
                myModal.hide();
                tblReservas.ajax.reload();
            } else {
                Swal.fire('¡Error!', res.msg, 'error');
            }
        })
        .catch(err => {
            Swal.fire('¡Error de Conexión!', 'No se pudo comunicar con el servidor.', 'error');
        });
}

// Función para cancelar una reserva
function btnCancelarReserva(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡La reserva se cancelará!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, ¡cancelar!',
        cancelButtonText: 'No, mantener'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "admin/reservas/eliminar/" + id;
            fetch(url, { method: 'GET' })
                .then(response => response.json())
                .then(res => {
                    if (res.msg == 'ok') {
                        Swal.fire('¡Cancelada!', 'La reserva ha sido cancelada.', 'success');
                        tblReservas.ajax.reload();
                    } else {
                        Swal.fire('¡Error!', res.msg, 'error');
                    }
                });
        }
    });
}

// Función para confirmar una reserva
function btnConfirmarReserva(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Se confirmará la reserva!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, ¡confirmar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "admin/reservas/confirmar/" + id;
            fetch(url, { method: 'GET' })
                .then(response => response.json())
                .then(res => {
                    if (res.msg == 'ok') {
                        Swal.fire('¡Confirmada!', 'La reserva ha sido confirmada.', 'success');
                        tblReservas.ajax.reload();
                    } else {
                        Swal.fire('¡Error!', res.msg, 'error');
                    }
                });
        }
    });
}

// Función para reactivar una reserva
function btnActivarReserva(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡La reserva se reactivará como pendiente!",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, ¡reactivar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "admin/reservas/activar/" + id;
            fetch(url, { method: 'GET' })
                .then(response => response.json())
                .then(res => {
                    if (res.msg == 'ok') {
                        Swal.fire('¡Reactivada!', 'La reserva ha sido reactivada.', 'success');
                        tblReservas.ajax.reload();
                    } else {
                        Swal.fire('¡Error!', res.msg, 'error');
                    }
                });
        }
    });
}