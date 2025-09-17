<?php include_once 'views/template/header-admin.php'; ?>

<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header">
            <h5 class="card-title fw-semibold mb-0">Gestión de Habitaciones</h5>
        </div>
        <div class="card-body">
            <a href="<?php echo RUTA_PRINCIPAL; ?>admin/habitaciones/crear" class="btn btn-primary mb-3">Nueva Habitación</a>
            
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

<!-- Definir la constante en JS ANTES de cargar el script -->
<script>
    const RUTA_PRINCIPAL = "<?php echo RUTA_PRINCIPAL; ?>";
</script>
<script src="<?php echo RUTA_PRINCIPAL; ?>assets/admin/js/Pages/Habitaciones.js"></script>
