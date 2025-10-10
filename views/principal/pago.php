<?php include_once 'views/template/header-principal.php'; ?>

<main class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold"><?= $data['title'] ?? 'Pago'; ?></h1>
        <p>Verifica los detalles de tu reserva antes de proceder con el pago.</p>
    </div>

    <div class="row g-4 justify-content-center">
        <!-- Detalles de la habitación -->
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <img src="<?= RUTA_PRINCIPAL ?>assets/img/habitaciones/<?= $data['habitacion']['imagen'] ?? 'default.jpg'; ?>"
                     class="card-img-top" alt="<?= $data['habitacion']['nombre'] ?? 'Habitación'; ?>">
                <div class="card-body">
                    <h4 class="card-title"><?= $data['habitacion']['nombre'] ?? 'Habitación'; ?></h4>
                    <p class="card-text text-muted"><?= $data['habitacion']['descripcion'] ?? 'Descripción no disponible.'; ?></p>
                    <ul class="list-unstyled">
                        <li><strong>Precio por noche:</strong>
                            $<?= number_format($data['habitacion']['precio'] ?? 0, 0, ',', '.'); ?></li>
                        <li><strong>Fecha ingreso:</strong> <?= $data['reserva']['fecha_ingreso'] ?? '---'; ?></li>
                        <li><strong>Fecha salida:</strong> <?= $data['reserva']['fecha_salida'] ?? '---'; ?></li>
                        <li><strong>Total a pagar:</strong>
                            $<?= number_format($data['factura']['total'] ?? 0, 0, ',', '.'); ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Sección de pago -->
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="mb-4">Completa tu pago con PayPal</h5>
                    <div id="paypal-button-container"></div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://www.paypal.com/sdk/js?client-id=YOUR_PAYPAL_CLIENT_ID&currency=USD"></script>
<script>
    const idReserva = <?= $data['reserva']['id'] ?? 0; ?>;
    const total = <?= $data['factura']['total'] ?? 0; ?>;

    paypal.Buttons({
        createOrder: function (data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: (total / 4000).toFixed(2) // Convertir pesos a dólares aprox
                    }
                }]
            });
        },
        onApprove: function (data, actions) {
            return actions.order.capture().then(function (details) {
                fetch('<?= RUTA_PRINCIPAL ?>pago/capturarPago', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        details: details,
                        id_reserva: idReserva
                    })
                })
                .then(res => res.json())
                .then(resp => {
                    if (resp.status === 'success') {
                        window.location.href = resp.redirect;
                    } else {
                        alert(resp.msg);
                    }
                })
                .catch(err => console.error(err));
            });
        },
        onError: function (err) {
            alert("Ocurrió un error durante el pago. Intenta nuevamente.");
            console.error(err);
        }
    }).render('#paypal-button-container');
</script>

<?php include_once 'views/template/footer-principal.php'; ?>
