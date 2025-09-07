let tblUsuarios;

document.addEventListener("DOMContentLoaded", function () {
    tblUsuarios = $('#tableUsuarios').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": {
            "url": base_url + "admin/usuarios/listar",
            "dataSrc": ""
        },
        "columns": [
            { "data": "id" }, { "data": "nombre" }, { "data": "correo" },
            { "data": "rol" }, { "data": "estado" }, { "data": "acciones" }
        ],
        "language": { "url": base_url + "assets/admin/js/Spanish.json" },
        "order": [],
        responsive: true,
        dom: 'Bfrtilp',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
});

function btnNuevoUsuario() {
    Swal.fire('En desarrollo', 'La función para añadir nuevos usuarios se implementará pronto.', 'info');
}

/**
 * Redirige a la página de edición del usuario.
 * @param {number} id El ID del usuario a editar.
 */
function btnEditarUsuario(id) {
    window.location.href = base_url + 'admin/usuarios/editar/' + id;
}

function btnAccionUsuario(id, estadoActual) {
    const accion = estadoActual == 1 ? 'inactivar' : 'reactivar';
    const textoConfirmacion = `¿Estás seguro de que quieres ${accion} a este usuario?`;
    const textoExito = `¡El usuario ha sido ${accion}do!`;

    Swal.fire({
        title: 'Confirmar Acción',
        text: textoConfirmacion,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: `Sí, ¡${accion}!`, 
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "admin/usuarios/accion/" + id;
            fetch(url)
                .then(response => response.json())
                .then(res => {
                    if (res.msg == 'ok') {
                        Swal.fire('¡Éxito!', textoExito, 'success');
                        tblUsuarios.ajax.reload();
                    } else {
                        Swal.fire('¡Error!', res.msg, 'error');
                    }
                });
        }
    });
}
