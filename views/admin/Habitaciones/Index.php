<?php include_once 'views/template/header-admin.php'; ?>

<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header">
            <h5 class="card-title fw-semibold mb-0">Gestión de Habitaciones</h5>
        </div>
        <div class="card-body">
            <a href="<?php echo RUTA_PRINCIPAL; ?>admin/habitaciones/crear" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Nueva Habitación</a>
            
            <?php 
            if (isset($_SESSION['alerta'])) {
                $alerta = $_SESSION['alerta'];
                echo '<div class="alert alert-' . $alerta['tipo'] . ' alert-dismissible fade show" role="alert">
                        ' . $alerta['mensaje'] . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                unset($_SESSION['alerta']);
            }
            ?>

            <div class="table-responsive">
                <table id="tblHabitaciones" class="table table-bordered table-striped" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Estilo</th>
                            <th>Capacidad</th>
                            <th>Precio</th>
                            <th>Foto</th>
                            <th>Estado</th>
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
    let tblHabitaciones;
    document.addEventListener('DOMContentLoaded', function() {
        tblHabitaciones = $('#tblHabitaciones').DataTable({
            "ajax": {
                "url": '<?php echo RUTA_PRINCIPAL; ?>admin/habitaciones/listar',
                "dataSrc": ""
            },
            "columns": [
                { "data": 'id' },
                { "data": 'estilo' },
                { "data": 'capacidad' },
                { "data": 'precio', "render": function(data) { return 'S/ ' + parseFloat(data).toFixed(2); } },
                {
                    "data": 'foto',
                    "render": function(data) {
                        if (data) {
                            return `<img src="<?php echo RUTA_PRINCIPAL; ?>assets/img/habitaciones/${data}" width="100" class="img-thumbnail">`;
                        } else {
                            return 'Sin foto';
                        }
                    }
                },
                {
                    "data": 'estado',
                    "render": function(data) {
                        return data == 1 
                            ? '<span class="badge bg-success">Activo</span>' 
                            : '<span class="badge bg-danger">Inactivo</span>';
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        const urlEditar = `<?php echo RUTA_PRINCIPAL; ?>admin/habitaciones/editar/${row.id}`;
                        let btnReingresar = '';
                        if (row.estado == 0) {
                             btnReingresar = `<button class="btn btn-success btn-sm" onclick="reingresarHabitacion(${row.id})"><i class="fas fa-check-circle"></i></button> `;
                        }
                        return '' +
                            `<a href="${urlEditar}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> ` +
                            `<button class="btn btn-danger btn-sm" onclick="eliminarHabitacion(${row.id})"><i class="fas fa-trash-alt"></i></button> ` +
                            btnReingresar;
                    }
                }
            ],
            "language": {
                "url": "<?php echo RUTA_PRINCIPAL; ?>assets/DataTables/es-ES.json"
            },
            "responsive": true
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
            confirmButtonText: 'Sí, ¡dar de baja!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = '<?php echo RUTA_PRINCIPAL; ?>admin/habitaciones/eliminar/' + id;
                fetch(url, { method: 'GET' })
                    .then(response => response.json())
                    .then(res => {
                        Swal.fire('Aviso', res.msg, res.icono);
                        if (res.icono == 'success') {
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
            confirmButtonText: 'Sí, ¡reingresar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Asumo que tienes un método 'reingresar' en tu controlador
                const url = '<?php echo RUTA_PRINCIPAL; ?>admin/habitaciones/reingresar/' + id;
                fetch(url, { method: 'GET' })
                    .then(response => response.json())
                    .then(res => {
                        Swal.fire('Aviso', res.msg, res.icono);
                        if (res.icono == 'success') {
                            tblHabitaciones.ajax.reload();
                        }
                    });
            }
        });
    }
</script>