<?php require_once 'views/template/header-admin.php'; ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div><h4 class="mb-0">Reservas</h4></div>
            <!-- ===== INICIO: Botón Nueva Reserva ===== -->
            <div class="ms-auto">
                <button class="btn btn-primary" type="button" onclick="btnNuevaReserva()"><i class="fas fa-plus"></i> Nueva Reserva</button>
            </div>
            <!-- ===== FIN: Botón Nueva Reserva ===== -->
        </div>
        <hr/>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="tableReservas">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Habitación</th>
                        <th>Cliente</th>
                        <th>Fecha Entrada</th>
                        <th>Fecha Salida</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los datos se cargarán aquí dinámicamente -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ===== INICIO: Estructura de la Ventana Modal ===== -->
<div class="modal fade" id="reservaModal" tabindex="-1" aria-labelledby="reservaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reservaModalLabel">Nueva Reserva</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="reservaForm" onsubmit="guardarReserva(event)">
        <div class="modal-body">
           <input type="hidden" id="idReserva" name="idReserva">
           
           <div class="mb-3">
               <label for="habitacion" class="form-label">Habitación</label>
               <select class="form-control" id="habitacion" name="habitacion" required>
                   <!-- Las opciones se cargarán dinámicamente con JS -->
                   <option value="">Seleccionar Habitación</option>
               </select>
           </div>
           
           <div class="mb-3">
               <label for="cliente" class="form-label">Cliente</label>
               <select class="form-control" id="cliente" name="cliente" required>
                   <!-- Las opciones se cargarán dinámicamente con JS -->
                   <option value="">Seleccionar Cliente</option>
               </select>
           </div>
           
           <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fecha_ingreso" class="form-label">Fecha Ingreso</label>
                    <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="fecha_salida" class="form-label">Fecha Salida</label>
                    <input type="date" class="form-control" id="fecha_salida" name="fecha_salida" required>
                </div>
           </div>
           
           <div class="mb-3">
                <label for="monto" class="form-label">Monto</label>
                <input type="number" step="0.01" class="form-control" id="monto" name="monto" required>
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- ===== FIN: Estructura de la Ventana Modal ===== -->

<?php require_once 'views/template/footer-admin.php'; ?>

<!-- Script de JavaScript -->
<script>
    let tblReservas;
    let myModal; // Variable para la instancia de la modal

    document.addEventListener("DOMContentLoaded", function () {
        // Inicializar DataTables
        tblReservas = $('#tableReservas').DataTable({
            "processing": true,
            "serverSide": false,
            "ajax": {
                "url": base_url + "admin/reservas/listar",
                "dataSrc": "",
                "cache": false
            },
            "columns": [
                { "data": "id" },
                { "data": "habitacion" },
                { "data": "cliente" },
                { "data": "fecha_ingreso" },
                { "data": "fecha_salida" },
                { "data": "monto" },
                { "data": "estado" },
                { "data": "acciones" }
            ],
            "language": {
                "url": base_url + "assets/admin/js/Spanish.json"
            },
            "order": [],
            responsive: true,
            dom: 'Bfrtilp',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
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

    // Función para el botón Editar (aún es un placeholder)
    function btnEditarReserva(id) {
        document.getElementById('reservaModalLabel').textContent = "Editar Reserva";
        console.log("ID de reserva para editar:", id);
        // (Aquí irá la lógica para cargar los datos en el formulario)
        myModal.show();
    }
    
    // Función para manejar el envío del formulario
    function guardarReserva(event) {
        event.preventDefault();
        console.log("Formulario enviado. Aquí irá la lógica para guardar en la BD.");
        // (Aquí irá la lógica para enviar los datos al controlador)
        myModal.hide(); // Oculta la modal después de enviar
    }

    // Función para el botón Eliminar (ya funcional)
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
</script>