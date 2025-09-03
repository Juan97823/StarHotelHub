<?php include_once 'views/template/header-admin.php'; ?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Gestión de Habitaciones</h5>
            <a href="<?php echo RUTA_PRINCIPAL; ?>admin/habitaciones/crear" class="btn btn-primary mb-3">Nueva Habitación</a>

            <div class="table-responsive">
                <table id="tblHabitaciones" class="table table-bordered table-striped" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Estilo</th>
                            <th>Capacidad</th>
                            <th>Precio</th>
                            <th>Foto</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los datos se cargarán con DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/template/footer-admin.php'; ?>

<script>
    var tblHabitaciones;
    $(document).ready(function() {
        tblHabitaciones = $('#tblHabitaciones').DataTable({
            "ajax": {
                "url": '<?php echo RUTA_PRINCIPAL; ?>admin/habitaciones/listar',
                "dataSrc": ""
            },
            "columns": [
                { "data": 'id' },
                { "data": 'estilo' },
                { "data": 'capacidad' },
                { "data": 'precio' },
                {
                    "data": 'foto',
                    "render": function(data, type, row) {
                        if (data) {
                            return '<img src="<?php echo RUTA_PRINCIPAL; ?>assets/img/habitaciones/' + data + '" width="100">';
                        } else {
                            return 'Sin foto';
                        }
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        const urlEditar = `<?php echo RUTA_PRINCIPAL; ?>admin/habitaciones/editar/${row.id}`;
                        return '' +
                            `<a href="${urlEditar}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> ` +
                            `<button class="btn btn-danger btn-sm" onclick="eliminarHabitacion(${row.id})"><i class="fas fa-trash-alt"></i></button> `;
                    }
                }
            ]
        });
    });

    function eliminarHabitacion(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, ¡eliminarlo!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo RUTA_PRINCIPAL; ?>admin/habitaciones/eliminar/' + id,
                    type: 'GET',
                    success: function(response) {
                        var res = JSON.parse(response);
                        Swal.fire('Aviso', res.msg, res.icono);
                        if (res.icono == 'success') {
                            tblHabitaciones.ajax.reload();
                        }
                    }
                });
            }
        });
    }
</script>   