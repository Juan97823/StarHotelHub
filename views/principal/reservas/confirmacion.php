<?php
include_once 'views/template/header-principal.php';

// Extraer los datos preparados por el controlador
$reserva = $data['reserva'];
$usuario = $data['usuario'];
$habitacion = $data['habitacion'];
$factura = $data['factura'];
?>

<style>
    @media print {
        body {
            background-color: white;
        }
        .confirmation-area {
            background-color: white !important;
        }
        .card {
            box-shadow: none !important;
            border: 1px solid #000 !important;
        }
        .btn {
            display: none;
        }
        .alert {
            border: 1px solid #000 !important;
        }
        table {
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #000 !important;
        }
    }
</style>

<section class="confirmation-area py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">FACTURA DE RESERVA</h4>
                    </div>
                    <div class="card-body p-4">
                        <!-- Encabezado de la Factura -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/logo.png'; ?>" alt="Logo Hotel" width="150">
                                <h5 class="mt-3">StarHotelHub</h5>
                                <p class="mb-0">Dirección del Hotel, Ciudad</p>
                                <p>Email: starhotelhub@gmail.com</p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <p><strong>Factura #:</strong> <?php echo $factura['numero']; ?></p>
                                <p><strong>Fecha:</strong> <?php echo date('d/m/Y'); ?></p>
                                <p><strong>Código de Reserva:</strong> <?php echo $reserva['id']; ?></p>
                                <span class="badge bg-warning text-dark fs-6">PENDIENTE DE PAGO</span>
                            </div>
                        </div>

                        <!-- Datos del Cliente -->
                        <div class="border-top pt-3 mb-4">
                            <h5 class="fw-bold">Facturar a:</h5>
                            <p class="mb-1"><strong>Cliente:</strong> <?php echo htmlspecialchars($usuario['nombre']); ?></p>
                            <p class="mb-1"><strong>Correo:</strong> <?php echo htmlspecialchars($usuario['correo']); ?></p>
                            <p class="mb-1"><strong>ID Usuario:</strong> <?php echo $usuario['id']; ?></p>
                        </div>

                        <!-- Datos de Transacción -->
                        <div class="border-top pt-3 mb-4">
                            <h5 class="fw-bold">Información de Transacción:</h5>
                            <p class="mb-1"><strong>Número de Transacción:</strong> <code><?php echo htmlspecialchars($reserva['num_transaccion']); ?></code></p>
                            <p class="mb-1"><strong>Código de Reserva:</strong> <code><?php echo htmlspecialchars($reserva['cod_reserva']); ?></code></p>
                            <p class="mb-1"><strong>Tipo de Facturación:</strong> <?php echo htmlspecialchars($reserva['facturacion']); ?></p>
                            <p class="mb-1"><strong>Método de Pago:</strong>
                                <?php
                                    $metodos = [1 => 'Online', 2 => 'En el Hotel', 3 => 'Transferencia'];
                                    echo $metodos[$reserva['metodo']] ?? 'Desconocido';
                                ?>
                            </p>
                        </div>

                        <!-- Detalles de la Reserva -->
                        <div class="border-top pt-3 mb-4">
                            <h5 class="fw-bold">Detalles de la Estadía:</h5>
                            <p class="mb-1"><strong>Habitación:</strong> <?php echo htmlspecialchars($habitacion['estilo']); ?></p>
                            <p class="mb-1"><strong>Número de Habitación:</strong> <?php echo htmlspecialchars($habitacion['numero'] ?? 'N/A'); ?></p>
                            <p class="mb-1"><strong>Check-in:</strong> <?php echo date("d/m/Y H:i", strtotime($reserva['fecha_ingreso'])); ?></p>
                            <p class="mb-1"><strong>Check-out:</strong> <?php echo date("d/m/Y H:i", strtotime($reserva['fecha_salida'])); ?></p>
                            <p class="mb-1"><strong>Estado:</strong>
                                <?php
                                    $estados = [1 => 'Pendiente', 2 => 'Confirmada', 3 => 'Cancelada'];
                                    $estado = $estados[$reserva['estado']] ?? 'Desconocido';
                                    $badgeClass = $reserva['estado'] == 1 ? 'warning' : ($reserva['estado'] == 2 ? 'success' : 'danger');
                                    echo "<span class='badge bg-{$badgeClass}'>{$estado}</span>";
                                ?>
                            </p>
                        </div>

                        <!-- Tabla de Cargos -->
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Descripción</th>
                                    <th scope="col" class="text-center">Cantidad</th>
                                    <th scope="col" class="text-end">Precio Unit.</th>
                                    <th scope="col" class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Estadía en <?php echo htmlspecialchars($habitacion['estilo']); ?></td>
                                    <td class="text-center"><?php echo $factura['noches']; ?> noche(s)</td>
                                    <td class="text-end">$<?php echo number_format($factura['precio_noche'], 0, ',', '.'); ?></td>
                                    <td class="text-end">$<?php echo number_format($factura['subtotal'], 0, ',', '.'); ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Resumen Financiero -->
                        <div class="row justify-content-end">
                            <div class="col-md-5">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Subtotal (sin IVA):</span>
                                        <strong>$<?php echo number_format($factura['subtotal'], 0, ',', '.'); ?></strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>IVA (19% incluido):</span>
                                        <strong>$<?php echo number_format($factura['impuestos'], 0, ',', '.'); ?></strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between bg-success text-white fs-5">
                                        <strong>TOTAL A PAGAR:</strong>
                                        <strong>$<?php echo number_format($factura['total'], 0, ',', '.'); ?></strong>
                                    </li>
                                </ul>
                                <div class="alert alert-info mt-3 mb-0">
                                    <small><strong>ℹ️ Nota:</strong> El precio mostrado incluye el IVA del 19%. Este es el monto total que pagarás.</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información de Base de Datos -->
                        <div class="border-top pt-3 mb-4">
                            <h5 class="fw-bold">📊 Información Guardada en Base de Datos:</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <tr>
                                        <td><strong>ID Reserva:</strong></td>
                                        <td><?php echo $reserva['id']; ?></td>
                                        <td><strong>ID Usuario:</strong></td>
                                        <td><?php echo $reserva['id_usuario']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>ID Habitación:</strong></td>
                                        <td><?php echo $reserva['id_habitacion']; ?></td>
                                        <td><strong>ID Empleado:</strong></td>
                                        <td><?php echo $reserva['id_empleado'] ?? 'N/A'; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Monto:</strong></td>
                                        <td>$<?php echo number_format($reserva['monto'], 0, ',', '.'); ?></td>
                                        <td><strong>Método:</strong></td>
                                        <td><?php echo $reserva['metodo']; ?> (Online)</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Estado:</strong></td>
                                        <td><?php echo $reserva['estado']; ?> (Pendiente)</td>
                                        <td><strong>Fecha Reserva:</strong></td>
                                        <td><?php echo date("d/m/Y H:i:s", strtotime($reserva['fecha_reserva'])); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="border-top pt-3 mb-4">
                            <h5 class="fw-bold">Información de Contacto:</h5>
                            <p class="mb-1"><strong>Teléfono Hotel:</strong> +57 (1) 1234-5678</p>
                            <p class="mb-1"><strong>Email:</strong> starhotelhub@gmail.com</p>
                            <p class="mb-1"><strong>Dirección:</strong> Calle Principal 123, Ciudad</p>
                        </div>

                        <!-- Términos y Condiciones -->
                        <div class="alert alert-info" role="alert">
                            <small>
                                <strong>Nota Importante:</strong> El pago se realizará en el hotel al momento del check-in.
                                Por favor, presenta esta confirmación en la recepción.
                                Para cancelaciones, contacta con nosotros con al menos 48 horas de anticipación.
                            </small>
                        </div>

                        <!-- Pie de página de la factura -->
                        <div class="text-center mt-5">
                            <p>Gracias por su preferencia. ¡Esperamos recibirte pronto!</p>
                            <button class="btn btn-primary" onclick="window.print();">
                                <i class="fas fa-print"></i> Imprimir / Guardar como PDF
                            </button>
                            <a href="<?php echo RUTA_PRINCIPAL; ?>" class="btn btn-secondary">
                                <i class="fas fa-home"></i> Volver al Inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once 'views/template/footer-principal.php'; ?>
