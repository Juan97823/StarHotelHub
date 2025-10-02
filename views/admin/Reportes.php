<?php include_once 'views/template/header-admin.php'; ?>

<div class="container mt-5">
    <h2>Reportes Administrativos</h2>
    <form id="formReportes" method="GET">
        <div class="form-group mb-3">
            <label for="tipo_reporte">Tipo de Reporte:</label>
            <select class="form-control" id="tipo_reporte" name="tipo_reporte">
                <option value="reservas">Reservas</option>
                <option value="usuarios">usuarios</option>
                <option value="habitaciones">Habitaciones</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="fecha_inicio">Fecha Inicio:</label>
            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
        </div>
        <div class="form-group mb-3">
            <label for="fecha_fin">Fecha Fin:</label>
            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
        </div>
        <button type="submit" class="btn btn-primary">Generar Reporte</button>
    </form>

    <!-- Aquí el JS pintará el resultado -->
    <div id="resultado" class="mt-4"></div>
</div>

<?php include_once 'views/template/footer-admin.php'; ?>
<script src="<?php echo RUTA_PRINCIPAL ?>assets/admin/js/pages/reportes.js"></script>
