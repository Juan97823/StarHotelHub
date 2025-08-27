<?php include_once 'views/template/header-admin.php'; ?>
<div class="container py-4">
    <h2 class="mb-4">Reservas Pendientes</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Reserva</th>
                <th>Cliente</th>
                <th>Habitación</th>
                <th>Fecha de Reserva</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pendientes as $reserva): ?>
                <tr>
                    <td><?php echo $reserva['id']; ?></td>
                    <td><?php echo $reserva['cliente']; ?></td>
                    <td><?php echo $reserva['habitacion']; ?></td>
                    <td><?php echo $reserva['fecha_reserva']; ?></td>
                    <td><?php echo $reserva['estado']; ?></td>
                    <td>
                        <a href="<?php echo RUTA_PRINCIPAL . 'admin/reserva/aprobar/' . $reserva['id']; ?>" class="btn btn-success">Aprobar</a>
                        <a href="<?php echo RUTA_PRINCIPAL . 'admin/reserva/cancelar/' . $reserva['id']; ?>" class="btn btn-danger">Cancelar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<?php include_once 'views/template/footer-admin.php'; ?>