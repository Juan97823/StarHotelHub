// assets/admin/js/reservas.js

// Declarar las variables globales necesarias
let tblReservas;
let myModal;

// Esperar a que el DOM esté completamente cargado
document.addEventListener("DOMContentLoaded", function () {

    // Inicializar DataTable
    tblReservas = $('#tableReservas').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: base_url + "admin/reservas/listar",
            dataSrc: "",
            cache: false
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
            url: base_url + "assets/admin/js/es-ES.json"
        },
        order: [],
        responsive: true,
        dom: 'Bfrtilp',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });

    // Inicializar la modal de Bootstrap
    myModal = new bootstrap.Modal(document.getElementById('reservaModal'));
});

// Función para el botón "Nueva Reserva"
function btnNuevaReserva() {
    document.getElementById('reservaForm').reset();
    document.getElementById('idReserva').value = "";
    document.getElementById('reservaModalLabel').textContent = "Nueva Reserva";
    myModal.show();
}

// Función para el botón Editar
function btnEditarReserva(id) {
    document.getElementById('reservaModalLabel').textContent = "Editar Reserva";
    console.log("ID de reserva para editar:", id);
    // Aquí iría la lógica para cargar datos en el formulario
    myModal.show();
}

// Función para guardar reserva (placeholder)
function guardarReserva(event) {
    event.preventDefault();
    console.log("Formulario enviado. Aquí irá la lógica para guardar en la BD.");
    myModal.hide(); // Oculta la modal después de enviar
}

// Función para eliminar reserva
function btnEliminarReserva(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡La reserva se eliminará permanentemente!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, ¡eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "admin/reservas/eliminar/" + id;
            fetch(url, { method: 'GET' })
                .then(response => response.json())
                .then(res => {
                    if (res.msg == 'ok') {
                        Swal.fire('¡Eliminado!', 'La reserva ha sido eliminada.', 'success');
                        tblReservas.ajax.reload();
                    } else {
                        Swal.fire('¡Error!', res.msg, 'error');
                    }
                })
                .catch(err => {
                    Swal.fire('¡Error de Conexión!', 'No se pudo comunicar con el servidor.', 'error');
                });
        }
    });
}
