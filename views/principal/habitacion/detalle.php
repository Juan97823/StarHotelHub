<?php
include_once 'views/template/header-principal.php';
include_once 'views/template/portada.php';

$habitacion = $data['habitacion'];
?>

<!-- Sección de Detalles de Habitación Modernizada -->
<section class="room-details-area-modern ptb-100">
    <div class="container">
        <div class="row">
            <!-- Columna de la Galería de Imágenes -->
            <div class="col-lg-7">
                <div class="room-gallery">
                    <div class="main-image">
                        <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/habitaciones/' . $habitacion['foto']; ?>" alt="<?php echo $habitacion['estilo']; ?>">
                    </div>
                    <!-- Puedes agregar miniaturas aquí si tienes más imágenes -->
                </div>
            </div>

            <!-- Columna de Información y Reserva -->
            <div class="col-lg-5">
                <div class="room-details-content-modern">
                    <h2 class="room-title"><?php echo $habitacion['estilo']; ?></h2>
                    <p class="room-description"><?php echo nl2br($habitacion['descripcion']); ?></p>

                    <div class="room-features">
                        <h3>Características Principales</h3>
                        <div class="features-list">
                            <div class="feature-item">
                                <i class="bx bx-group"></i>
                                <span>Capacidad: <strong><?php echo $habitacion['capacidad']; ?> Personas</strong></span>
                            </div>
                            <!-- Agrega más características con iconos según los datos que tengas -->
                            <?php
                            if (!empty($habitacion['servicios'])) {
                                $servicios = explode(',', $habitacion['servicios']);
                                foreach ($servicios as $servicio) {
                                    echo '<div class="feature-item"><i class="bx bx-check-shield"></i><span>' . htmlspecialchars(trim($servicio)) . '</span></div>';
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div class="room-price">
                        <span>Desde</span>
                        <p>$<?php echo number_format($habitacion['precio']); ?> / noche</p>
                    </div>

                    <div class="booking-form">
                        <h3>Reservar esta Habitación</h3>
                        <form action="<?php echo RUTA_PRINCIPAL . 'reserva'; ?>" method="get">
                            <input type="hidden" name="id" value="<?php echo $habitacion['id']; ?>">
                            <div class="form-group">
                                <label for="checkin">Fecha de Entrada</label>
                                <input type="date" id="checkin" name="checkin" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="checkout">Fecha de Salida</label>
                                <input type="date" id="checkout" name="checkout" class="form-control" required>
                            </div>
                            <button type="submit" class="btn-booking">Reservar Ahora</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once 'views/template/footer-principal.php'; ?>
