let tblReservasEmpleado;
const reservaEmpleadoForm = document.getElementById("reservaEmpleadoForm");

document.addEventListener("DOMContentLoaded", function () {
    // Inicializar DataTable
    tblReservasEmpleado = $("#tableReservasEmpleado").DataTable({
        ajax: {
            url: base_url + "ReservasEmpleado/listar",
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
            url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
        },
        responsive: true,
        order: [[0, "desc"]]
    });

    // Guardar reserva
    reservaEmpleadoForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const url = base_url + "ReservasEmpleado/guardar";
        const formData = new FormData(reservaEmpleadoForm);

        fetch(url, {
            method: "POST",
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("Éxito", data.message, "success");
                    $("#reservaEmpleadoModal").modal("hide");
                    reservaEmpleadoForm.reset();
                    tblReservasEmpleado.ajax.reload();
                } else {
                    Swal.fire("Error", data.message, "error");
                }
            })
            .catch(err => console.error("Error:", err));
    });
});

// Abrir modal
function btnNuevaReservaEmpleado() {
    document.getElementById("idReservaEmpleado").value = "";
    reservaEmpleadoForm.reset();
    document.getElementById("reservaEmpleadoModalLabel").textContent = "Nueva Reserva";
    $("#reservaEmpleadoModal").modal("show");
}

// Editar reserva
function btnEditarReservaEmpleado(id) {
    const url = base_url + "ReservasEmpleado/editar/" + id;

    fetch(url)
        .then(res => res.json())
        .then(data => {
            document.getElementById("idReservaEmpleado").value = data.id;
            document.getElementById("habitacion").value = data.habitacion_id;
            document.getElementById("cliente").value = data.cliente_id;
            document.getElementById("fecha_ingreso").value = data.fecha_ingreso;
            document.getElementById("fecha_salida").value = data.fecha_salida;
            document.getElementById("monto").value = data.monto;

            document.getElementById("reservaEmpleadoModalLabel").textContent = "Editar Reserva";
            $("#reservaEmpleadoModal").modal("show");
        })
        .catch(err => console.error("Error:", err));
}

// Eliminar / Cambiar estado
function btnEliminarReservaEmpleado(id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "ReservasEmpleado/eliminar/" + id;

            fetch(url, { method: "GET" })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire("Éxito", data.message, "success");
                        tblReservasEmpleado.ajax.reload();
                    } else {
                        Swal.fire("Error", data.message, "error");
                    }
                })
                .catch(err => console.error("Error:", err));
        }
    });
}
