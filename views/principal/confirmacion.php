<?php include_once 'views/template/header-principal.php'; ?>

<main class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold text-success">✅ Pago Completado</h1>
        <p>Gracias por tu pago. Tu reserva ha sido confirmada exitosamente.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3">Detalles de la Reserva</h4>
                    <p><strong>Habitación:</strong> <?= $data['habitacion']['nombre']; ?></p>
                    <p><strong>Fecha de ingreso:</strong> <?= $data['reserva']['fecha_ingreso']; ?></p>
                    <p><strong>Fecha de salida:</strong> <?= $data['reserva']['fecha_salida']; ?></p>
                    <p><strong>Total pagado:</strong> $<?= number_format($data['factura']['total'], 0, ',', '.'); ?></p>
                    <p><strong>ID de Transacción:</strong> <?= $data['factura']['id_transaccion']; ?></p>
                    <hr>
                    <p>Recibirás un correo de confirmación con todos los detalles de tu reserva.  
                       Si deseas imprimir tu factura, puedes hacerlo desde tu perfil.</p>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="<?= RUTA_PRINCIPAL ?>cliente/reservas" class="btn btn-primary">
                    Volver a mis reservas
                </a>
            </div>
        </div>
    </div>
</main>

<?php include_once 'views/template/footer-principal.php'; ?>
