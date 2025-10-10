<?php include_once 'views/template/header-principal.php'; ?>

<main class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold"><?= $data['title'] ?? 'Pago en efectivo'; ?></h1>
        <p>Verifica los detalles de tu reserva antes de proceder.</p>
    </div>

    <div class="row g-4 justify-content-center">
        <!-- Detalles de la habitación -->
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <img src="<?= RUTA_PRINCIPAL ?>assets/img/habitaciones/<?= $data['habitacion']['imagen'] ?? 'default.jpg'; ?>"
                     class="card-img-top" alt="<?= $data['habitacion']['estilo'] ?? 'Habitación'; ?>">
                <div class="card-body">
                    <h4 class="card-title"><?= $data['habitacion']['estilo'] ?? 'Habitación'; ?></h4>
                    <p class="card-text text-muted"><?= $data['habitacion']['descripcion'] ?? 'Descripción no disponible.'; ?></p>
                    <ul class="list-unstyled">
                        <li><strong>Precio por noche:</strong>
                            $<?= number_format($data['habitacion']['precio'] ?? 0, 0, ',', '.'); ?></li>
                        <li><strong>Fecha ingreso:</strong> <?= $data['reserva']['fecha_ingreso'] ?? '---'; ?></li>
                        <li><strong>Fecha salida:</strong> <?= $data['reserva']['fecha_salida'] ?? '---'; ?></li>
                        <li><strong>Total a pagar:</strong>
                            $<?= number_format($data['total_pagar'] ?? 0, 0, ',', '.'); ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Botón de pago en efectivo -->
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="mb-4">Pagar en efectivo al llegar</h5>
                    <form action="<?= RUTA_PRINCIPAL ?>pago/confirmarEfectivo/<?= $data['reserva']['id']; ?>" method="POST">
                        <button type="submit" class="btn btn-success btn-lg">Confirmar pago en efectivo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include_once 'views/template/footer-principal.php'; ?>
