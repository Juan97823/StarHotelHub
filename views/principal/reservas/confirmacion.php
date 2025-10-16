<?php
include_once 'views/template/header-principal.php';

// Extraer los datos preparados por el controlador
$reserva = $data['reserva'];
$usuario = $data['usuario'];
$habitacion = $data['habitacion'];
$factura = $data['factura'];
?>

<section class="confirmation-area py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">FACTURA PROFORMA</h4>
                    </div>
                    <div class="card-body p-4">
                        <!-- Encabezado de la Factura -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/logo.png'; ?>" alt="Logo Hotel" width="150">
                                <h5 class="mt-3">StarHotelHub</h5>
                                <p class="mb-0">Dirección del Hotel, Ciudad</p>
                                <p>Email: contacto@starhotelhub.com</p>
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
                        </div>

                        <!-- Detalles de la Reserva -->
                        <div class="border-top pt-3 mb-4">
                            <h5 class="fw-bold">Detalles de la Estadía:</h5>
                            <p class="mb-1"><strong>Habitación:</strong> <?php echo htmlspecialchars($habitacion['estilo']); ?></p>
                            <p class="mb-1"><strong>Check-in:</strong> <?php echo date("d/m/Y", strtotime($reserva['fecha_ingreso'])); ?></p>
                            <p class="mb-1"><strong>Check-out:</strong> <?php echo date("d/m/Y", strtotime($reserva['fecha_salida'])); ?></p>
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
                                    <li class="list-group-item d-flex justify-content-between"><span>Subtotal:</span> <strong>$<?php echo number_format($factura['subtotal'], 0, ',', '.'); ?></strong></li>
                                    <li class="list-group-item d-flex justify-content-between"><span>IVA (19%):</span> <strong>$<?php echo number_format($factura['impuestos'], 0, ',', '.'); ?></strong></li>
                                    <li class="list-group-item d-flex justify-content-between bg-dark text-white fs-5">
                                        <strong>TOTAL A PAGAR:</strong> 
                                        <strong>$<?php echo number_format($factura['total'], 0, ',', '.'); ?></strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Pie de página de la factura -->
                        <div class="text-center mt-5">
                            <p>Gracias por su preferencia. El pago se realizará en el hotel.</p>
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
