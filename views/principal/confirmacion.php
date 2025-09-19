<?php include_once 'views/template/header-principal.php'; ?>

<section class="confirmation-area ptb-100">
    <div class="container">
        <div class="section-title text-center">
            <span>¡Reserva Exitosa!</span>
            <h2>Gracias por confiar en StarHotelHub</h2>
        </div>

        <div class="card mx-auto" style="max-width:600px;">
            <div class="card-body">
                <h5 class="card-title">Resumen de tu Reserva</h5>
                <p><strong>Nombre:</strong> <?php echo $data['usuario']['nombre']; ?></p>
                <p><strong>correo:</strong> <?php echo $data['usuario']['correo']; ?></p>
                <hr>
                <p><strong>Habitación:</strong> <?php echo $data['habitacion']['estilo']; ?></p>
                <p><strong>Fecha Llegada:</strong> <?php echo $data['reserva']['fecha_ingreso']; ?></p>
                <p><strong>Fecha Salida:</strong> <?php echo $data['reserva']['fecha_salida']; ?></p>
                <hr>
                <h5>Factura</h5>
                <p><strong>Número de Factura:</strong> <?php echo $data['factura']['numero_factura']; ?></p>
                <p><strong>Subtotal:</strong> $<?php echo number_format($data['factura']['subtotal'], 0, ',', '.'); ?></p>
                <p><strong>Impuestos (IVA 19%):</strong> $<?php echo number_format($data['factura']['impuestos'], 0, ',', '.'); ?></p>
                <p><strong>Total:</strong> $<?php echo number_format($data['factura']['total'], 0, ',', '.'); ?></p>

                <div class="mt-3 text-center">
                    <a href="<?php echo RUTA_PRINCIPAL; ?>" class="btn btn-primary">Volver al Inicio</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once 'views/template/footer-principal.php'; ?>
