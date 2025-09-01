<?php
include_once 'views/template/header-principal.php';
include_once 'views/template/portada.php';

$habitacion = $data['habitacion'];
?>

<section class="room-details-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="room-details-article">
                    <div class="room-details-slider owl-carousel owl-theme">
                        <div class="room-details-item">
                            <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/habitaciones/' . $habitacion['foto']; ?>" alt="<?php echo $habitacion['estilo']; ?>">
                        </div>
                    </div>

                    <div class="room-details-content">
                        <h2><?php echo $habitacion['estilo']; ?></h2>
                        <p><?php echo nl2br($habitacion['descripcion']); ?></p>

                        <div class="row">
                            <div class="col-lg-6">
                                <?php
                                if (!empty($habitacion['servicios'])) {
                                    echo '<h3>Servicios Incluidos</h3>';
                                    echo '<ul class="services-list">';
                                    $servicios = explode(',', $habitacion['servicios']);
                                    foreach ($servicios as $servicio) {
                                        // Usando un ícono genérico para simplificar
                                        echo '<li><i class="flaticon-check"></i> ' . htmlspecialchars(trim($servicio)) . '</li>';
                                    }
                                    echo '</ul>';
                                }
                                ?>
                            </div>
                        </div>

                        <div class="room-details-price mt-4">
                            <h4>Desde <span class="price">$<?php echo number_format($habitacion['precio']); ?></span>/noche</h4>
                        </div>
                        <a href="<?php echo RUTA_PRINCIPAL . 'reserva?id=' . $habitacion['id']; ?>" class="default-btn">Reservar Ahora <i class="flaticon-right"></i></a>

                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="room-details-sidebar">
                    <div class="room-details-info">
                        <h3>Información de la Habitación</h3>
                        <ul>
                            <li><strong>Capacidad:</strong> <span><?php echo $habitacion['capacidad']; ?> Personas</span></li>
                            <li><strong>Precio:</strong> <span>$<?php echo number_format($habitacion['precio']); ?> / noche</span></li>
                            <li><strong>Estado:</strong> <span class="text-success">Disponible</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
