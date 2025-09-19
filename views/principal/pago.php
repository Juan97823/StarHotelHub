<?php include_once 'views/template/header-cliente.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-primary text-white text-center rounded-top-4">
                    <h3 class="mb-0 fw-bold">Confirmación y Pago de Reserva</h3>
                </div>
                <div class="card-body p-4">

                    <?php 
                    // Extraer los datos para facilitar el acceso
                    $reserva = $data['reserva'];
                    $factura = $data['factura'];
                    $habitacion = $data['habitacion'];
                    ?>

                    <h5 class="fw-bold mb-3">Resumen de tu Estancia</h5>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bx bxs-hotel me-2 text-primary"></i>Habitación</span>
                            <strong class="text-end"><?php echo htmlspecialchars($habitacion['estilo'], ENT_QUOTES, 'UTF-8'); ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bx bxs-calendar-plus me-2 text-success"></i>Fecha de Ingreso</span>
                            <strong class="text-end"><?php echo date("d/m/Y", strtotime($reserva['fecha_ingreso'])); ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bx bxs-calendar-minus me-2 text-danger"></i>Fecha de Salida</span>
                            <strong class="text-end"><?php echo date("d/m/Y", strtotime($reserva['fecha_salida'])); ?></strong>
                        </li>
                    </ul>

                    <h5 class="fw-bold mb-3">Detalles de la Factura</h5>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Subtotal</span>
                            <span>$<?php echo number_format($factura['subtotal'], 2); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Impuestos (19%)</span>
                            <span>$<?php echo number_format($factura['impuestos'], 2); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-dark rounded-bottom">
                            <strong class="fs-5">Total a Pagar (USD)</strong>
                            <strong class="fs-5 text-success">$<?php echo number_format($factura['total'], 2); ?></strong>
                        </li>
                    </ul>

                    <div class="text-center mt-4">
                        <p class="text-muted">Serás redirigido a PayPal para completar tu pago de forma segura.</p>
                        <!-- Contenedor para el botón de PayPal -->
                        <div id="paypal-button-container" class="mt-3"></div>
                    </div>

                </div>
            </div>

            <div class="alert alert-warning mt-4 text-center" role="alert">
                <i class="bx bxs-info-circle me-1"></i>
                <strong>Importante:</strong> Estás en un entorno de pruebas. No se realizarán cargos reales.
            </div>

        </div>
    </div>
</div>

<!-- SDK de PayPal y Configuración del Botón -->
<script src="https://www.paypal.com/sdk/js?client-id=AQVW2y0L_P82r995yq26d-Q2SgZsoJCHO1N123456789ABCDEFG&currency=USD"></script>
<script>
    paypal.Buttons({
        // --- Estilo del botón ---
        style: {
            layout: 'vertical',
            color:  'blue',
            shape:  'rect',
            label:  'pay'
        },

        // --- Crear la orden en PayPal ---
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?php echo $factura["total"]; ?>'
                    },
                    description: 'Pago de Reserva #<?php echo $reserva["id"]; ?> - Habitación: <?php echo htmlspecialchars($habitacion['estilo'], ENT_QUOTES, 'UTF-8'); ?>'
                }]
            });
        },

        // --- Aprobar y Capturar la transacción ---
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                // Construir la URL para nuestra propia API de captura
                let url = RUTA_PRINCIPAL + "pago/capturarPago";

                // Enviar los detalles del pago a nuestro servidor
                return fetch(url, {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        details: details,
                        id_reserva: '<?php echo $reserva["id"]; ?>'
                    })
                }).then(function(response) {
                    return response.json();
                }).then(function(res) {
                    // Redirigir al cliente a su panel con una alerta
                    window.location.href = RUTA_PRINCIPAL + "cliente/reservas?pago=" + res.status;
                });
            });
        },

        // --- Manejar la cancelación por parte del usuario ---
        onCancel: function (data) {
            // Opcional: Mostrar un mensaje o redirigir
            console.log("Pago cancelado por el usuario.");
            window.location.href = RUTA_PRINCIPAL + "cliente/reservas?pago=cancelado";
        },

        // --- Manejar errores del SDK de PayPal ---
        onError: function (err) {
            console.error('Error en la transacción de PayPal:', err);
            alert("Ocurrió un error con PayPal. Por favor, intenta de nuevo.");
        }

    }).render('#paypal-button-container');
</script>

<?php include_once 'views/template/footer-cliente.php'; ?>
