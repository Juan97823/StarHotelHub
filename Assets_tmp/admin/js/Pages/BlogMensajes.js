let tblMensajes;

document.addEventListener("DOMContentLoaded", function () {
    if (typeof RUTA_PRINCIPAL === 'undefined') {
        console.error("La variable RUTA_PRINCIPAL no está definida");
        return;
    }

    tblMensajes = $('#tblMensajes').DataTable({
        ajax: {
            url: `${RUTA_PRINCIPAL}admin/blog/listarMensajes`,
            dataSrc: "data"
        },
        columns: [
            { data: "id" },
            { data: "nombre" },
            { data: "email" },
            { data: "entrada_titulo" },
            {
                data: "mensaje",
                render: function (data) {
                    return data.substring(0, 50) + '...';
                }
            },
            { data: "fecha" },
            {
                data: "estado",
                render: function (data) {
                    return data == 1 ? '<span class="badge bg-warning">No leído</span>' : '<span class="badge bg-success">Leído</span>';
                }
            },
            {
                data: "id",
                render: function (data, type, row) {
                    let btnVer = `<button class="btn btn-info btn-sm" onclick="verMensaje(${row.id})" title="Ver">
                        <i class="fas fa-eye"></i>
                    </button>`;
                    
                    let btnEstado = row.estado == 1
                        ? `<button class="btn btn-warning btn-sm" onclick="cambiarEstado(${row.id}, 2)" title="Marcar como leído">
                            <i class="fas fa-check"></i>
                        </button>`
                        : `<button class="btn btn-secondary btn-sm" onclick="cambiarEstado(${row.id}, 1)" title="Marcar como no leído">
                            <i class="fas fa-undo"></i>
                        </button>`;
                    
                    let btnEliminar = `<button class="btn btn-danger btn-sm" onclick="eliminarMensaje(${row.id})" title="Eliminar">
                        <i class="fas fa-trash"></i>
                    </button>`;
                    
                    return `${btnVer} ${btnEstado} ${btnEliminar}`;
                }
            }
        ],
        language: {
            url: `${RUTA_PRINCIPAL}assets/admin/js/i18n/es-ES.json`
        },
        responsive: true
    });
});

function verMensaje(id) {
    fetch(`${RUTA_PRINCIPAL}admin/blog/verMensaje/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const mensaje = data.mensaje;
                Swal.fire({
                    title: mensaje.nombre,
                    html: `
                        <div class="text-start">
                            <p><strong>Email:</strong> ${mensaje.email}</p>
                            <p><strong>Entrada:</strong> ${mensaje.entrada_titulo}</p>
                            <p><strong>Fecha:</strong> ${mensaje.fecha}</p>
                            <hr>
                            <p><strong>Mensaje:</strong></p>
                            <p>${mensaje.mensaje}</p>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonText: 'Cerrar'
                });
                
                // Marcar como leído
                if (mensaje.estado == 1) {
                    cambiarEstado(id, 2);
                }
            }
        })
        .catch(err => {
            Swal.fire('Error', 'No se pudo obtener el mensaje', 'error');
        });
}

function cambiarEstado(id, nuevoEstado) {
    fetch(`${RUTA_PRINCIPAL}admin/blog/cambiarEstadoMensaje/${id}/${nuevoEstado}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                tblMensajes.ajax.reload();
            } else {
                Swal.fire('Error', data.mensaje || 'No se pudo cambiar el estado', 'error');
            }
        })
        .catch(err => {
            Swal.fire('Error', 'No se pudo comunicar con el servidor', 'error');
        });
}

function eliminarMensaje(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`${RUTA_PRINCIPAL}admin/blog/eliminarMensaje/${id}`, {
                method: 'DELETE'
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire('Eliminado', 'El mensaje ha sido eliminado', 'success');
                        tblMensajes.ajax.reload();
                    } else {
                        Swal.fire('Error', data.mensaje || 'No se pudo eliminar', 'error');
                    }
                })
                .catch(err => {
                    Swal.fire('Error', 'No se pudo comunicar con el servidor', 'error');
                });
        }
    });
}

