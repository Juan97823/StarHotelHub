let tblHabitaciones;

document.addEventListener('DOMContentLoaded', function () {
    tblHabitaciones = $('#tblHabitaciones').DataTable({
        ajax: {
            url: `${base_url}admin/habitaciones/listar`,
            dataSrc: ""
        },
        columns: [
            { data: 'id' },
            { data: 'estilo' },
            { data: 'capacidad' },
            { 
                data: 'precio',
                render: function (data) {
                    return 'S/ ' + parseFloat(data).toFixed(2);
                }
            },
            {
                data: 'foto',
                render: function (data) {
                    return data
                        ? `<img src="${base_url}assets/img/habitaciones/${data}" width="100" class="img-thumbnail">`
                        : 'Sin foto';
                }
            },
            {
                data: 'estado',
                render: function (data) {
                    return data == 1
                        ? '<span class="badge bg-success">Activo</span>'
                        : '<span class="badge bg-danger">Inactivo</span>';
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    const urlEditar = `${base_url}admin/habitaciones/editar/${row.id}`;
                    let btnReingresar = '';
                    if (row.estado == 0) {
                        btnReingresar = `<button class="btn btn-success btn-sm" onclick="reingresarHabitacion(${row.id})"><i class="fas fa-check-circle"></i></button>`;
                    }
                    return `
                        <a href="${urlEditar}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-danger btn-sm" onclick="eliminarHabitacion(${row.id})"><i class="fas fa-trash-alt"></i></button>
                        ${btnReingresar}
                    `;
                }
            }
        ],
        language: {
            url: `${base_url}assets/DataTables/es-ES.json`
        },
        responsive: true
    });
});

function eliminarHabitacion(id) {
    Swal.fire({
        title: '¿Dar de baja la habitación?',
        text: "La habitación aparecerá como inactiva.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, dar de baja',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = `${base_url}admin/habitaciones/eliminar/${id}`;
            fetch(url)
                .then(response => response.json())
                .then(res => {
                    Swal.fire('Aviso', res.msg, res.icono);
                    if (res.icono === 'success') {
                        tblHabitaciones.ajax.reload();
                    }
                });
        }
    });
}

function reingresarHabitacion(id) {
    Swal.fire({
        title: '¿Reingresar la habitación?',
        text: "La habitación volverá a estar activa.",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, reingresar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = `${base_url}admin/habitaciones/reingresar/${id}`;
            fetch(url)
                .then(response => response.json())
                .then(res => {
                    Swal.fire('Aviso', res.msg, res.icono);
                    if (res.icono === 'success') {
                        tblHabitaciones.ajax.reload();
                    }
                });
        }
    });
}
