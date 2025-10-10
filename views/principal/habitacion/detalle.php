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

                    <div class="booking-action text-center mt-4">
                        <a href="#" class="btn-booking" data-bs-toggle="modal" data-bs-target="#reservationModal" data-id="<?php echo $habitacion['id']; ?>">
                            Reservar Ahora
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once 'views/template/footer-principal.php'; ?>
