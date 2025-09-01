<?php include_once 'views/template/header-admin.php'; ?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Gestión de Habitaciones</h5>
            <button type="button" class="btn btn-primary mb-3" id="btnNuevo">Nueva Habitación</button>

            <div class="table-responsive">
                <table id="tblHabitaciones" class="table table-bordered">
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

<!-- Modal para registrar y editar -->
<div class="modal fade" id="modalHabitacion" tabindex="-1" aria-labelledby="modalHabitacionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHabitacionLabel">Nueva Habitación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formHabitacion" onsubmit="registrarHabitacion(event);">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <div class="mb-3">
                        <label for="estilo" class="form-label">Estilo</label>
                        <input type="text" class="form-control" id="estilo" name="estilo" required>
                    </div>
                    <div class="mb-3">
                        <label for="capacidad" class="form-label">Capacidad</label>
                        <input type="number" class="form-control" id="capacidad" name="capacidad" required>
                    </div>
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio por Noche</label>
                        <input type="text" class="form-control" id="precio" name="precio" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="servicios" class="form-label">Servicios (separados por comas)</label>
                        <input type="text" class="form-control" id="servicios" name="servicios">
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto">
                        <input type="hidden" id="foto_actual" name="foto_actual">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once 'views/template/footer-admin.php'; ?>

<script>
    let tblHabitaciones;

    document.addEventListener('DOMContentLoaded', function () {
        tblHabitaciones = new DataTable('#tblHabitaciones', {
            ajax: {
                url: '<?php echo RUTA_PRINCIPAL; ?>admin/habitaciones/listar',
                dataSrc: ''
            },
            columns: [
                { data: 'id' },
                { data: 'estilo' },
                { data: 'capacidad' },
                { data: 'precio' },
                { 
                    data: 'foto',
                    render: function(data) {
                        return '<img src="<?php echo RUTA_PRINCIPAL; ?>assets/img/habitaciones/' + data + '" width="100">';
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return '<button class="btn btn-warning btn-sm" onclick="editarHabitacion(' + row.id + ')">Editar</button> ' +
                               '<button class="btn btn-danger btn-sm" onclick="eliminarHabitacion(' + row.id + ')">Eliminar</button>';
                    }
                }
            ]
        });

        document.getElementById('btnNuevo').addEventListener('click', function() {
            document.getElementById('formHabitacion').reset();
            document.getElementById('id').value = '';
            document.getElementById('modalHabitacionLabel').textContent = 'Nueva Habitación';
            new bootstrap.Modal(document.getElementById('modalHabitacion')).show();
        });
    });

    function registrarHabitacion(e) {
        e.preventDefault();
        const url = '<?php echo RUTA_PRINCIPAL; ?>admin/habitaciones/registrar';
        const formData = new FormData(document.getElementById('formHabitacion'));
        const http = new XMLHttpRequest();
        http.open('POST', url, true);
        http.send(formData);
        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                if (res.icono == 'success') {
                    tblHabitaciones.ajax.reload();
                    bootstrap.Modal.getInstance(document.getElementById('modalHabitacion')).hide();
                }
                Swal.fire('Aviso', res.msg, res.icono);
            }
        }
    }

    function editarHabitacion(id) {
        const url = '<?php echo RUTA_PRINCIPAL; ?>admin/habitaciones/editar/' + id;
        const http = new XMLHttpRequest();
        http.open('GET', url, true);
        http.send();
        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                document.getElementById('id').value = res.id;
                document.getElementById('estilo').value = res.estilo;
                document.getElementById('capacidad').value = res.capacidad;
                document.getElementById('precio').value = res.precio;
                document.getElementById('descripcion').value = res.descripcion;
                document.getElementById('servicios').value = res.servicios;
                document.getElementById('foto_actual').value = res.foto;
                document.getElementById('modalHabitacionLabel').textContent = 'Editar Habitación';
                new bootstrap.Modal(document.getElementById('modalHabitacion')).show();
            }
        }
    }

    function eliminarHabitacion(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = '<?php echo RUTA_PRINCIPAL; ?>admin/habitaciones/eliminar/' + id;
                const http = new XMLHttpRequest();
                http.open('GET', url, true);
                http.send();
                http.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        const res = JSON.parse(this.responseText);
                        if (res.icono == 'success') {
                            tblHabitaciones.ajax.reload();
                        }
                        Swal.fire('Aviso', res.msg, res.icono);
                    }
                }
            }
        })
    }
</script>
