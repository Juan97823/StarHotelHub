<?php
// views/admin/Reportes.php

// Puedes incluir encabezado y navegación si es necesario
include_once __DIR__ . 'template/header-admin.php';
?>

<div class="container mt-5">
    <h2>Reportes Administrativos</h2>
    <form method="GET" action="">
        <div class="form-group mb-3">
            <label for="tipo_reporte">Tipo de Reporte:</label>
            <select class="form-control" id="tipo_reporte" name="tipo_reporte">
                <option value="reservas">Reservas</option>
                <option value="clientes">Clientes</option>
                <option value="habitaciones">Habitaciones</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="fecha_inicio">Fecha Inicio:</label>
            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
        </div>
        <div class="form-group mb-3">
            <label for="fecha_fin">Fecha Fin:</label>
            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
        </div>
        <button type="submit" class="btn btn-primary">Generar Reporte</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['tipo_reporte'])): ?>
        <hr>
        <h4>Resultado del Reporte: <?php echo htmlspecialchars($_GET['tipo_reporte']); ?></h4>
        <!-- Aquí puedes mostrar los datos del reporte según la selección -->
        <div>
            <p>Mostrando datos desde <strong><?php echo htmlspecialchars($_GET['fecha_inicio']); ?></strong> hasta <strong><?php echo htmlspecialchars($_GET['fecha_fin']); ?></strong>.</p>
            <!-- Ejemplo de tabla de resultados -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Detalle</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí irían los datos dinámicos del reporte -->
                    <tr>
                        <td>1</td>
                        <td>Ejemplo de dato</td>
                        <td>2024-06-01</td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php
// Puedes incluir pie de página si es necesario
include_once __DIR__ . 'template/footer-admin.php';
?>