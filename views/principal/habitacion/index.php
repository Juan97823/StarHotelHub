<?php
include_once 'views/template/header-principal.php';
include_once 'views/template/portada.php';
?>

<!-- Sección de Habitaciones Modernizada -->
<section class="rooms-area-three pb-100">
    <div class="container">
        <div class="section-title">
            <span>Nuestras Habitaciones</span>
            <h2>Descubre Nuestras Suites y Habitaciones</h2>
            <p>Disfruta de una estancia inolvidable en nuestras habitaciones diseñadas para tu confort y elegancia. Cada una ofrece una experiencia única con vistas espectaculares y un servicio de primera.</p>
        </div>
        <div class="row">
            <?php foreach ($data['habitaciones'] as $habitacion) { ?>
                <div class="col-lg-4 col-md-6">
                    <div class="single-room-card">
                        <div class="room-image">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#reservationModal" data-id="<?php echo $habitacion['id']; ?>">
                                <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/habitaciones/' . $habitacion['foto']; ?>" alt="<?php echo $habitacion['estilo']; ?>">
                            </a>
                        </div>
                        <div class="room-content">
                            <h3><a href="#" data-bs-toggle="modal" data-bs-target="#reservationModal" data-id="<?php echo $habitacion['id']; ?>"><?php echo $habitacion['estilo']; ?></a></h3>
                            <p>Capacidad para <?php echo $habitacion['capacidad']; ?> personas.</p>
                            <div class="price">Desde <span>$<?php echo number_format($habitacion['precio']); ?></span> / noche</div>
                            <a href="#" class="btn-details" data-bs-toggle="modal" data-bs-target="#reservationModal" data-id="<?php echo $habitacion['id']; ?>">Reservar</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php include_once 'views/template/footer-principal.php'; ?>