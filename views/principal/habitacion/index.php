<?php
include_once 'views/template/header-principal.php';
include_once 'views/template/portada.php';
?>

<!-- Beneficios principales -->
<section class="our-rooms-area-two our-rooms-area-four ptb-100">
	<div class="container">
		<div class="section-title">
			<span>Beneficios</span>
			<h2>¿Por qué reservar con nosotros?</h2>
		</div>
		<div class="tab industries-list-tab">
			<div class="row">
				<div class="col-lg-5">
					<div class="tabs row">
						<div class="col-lg-6 col-sm-6 single-tab">
							<div class="single-rooms">
								<i class="flaticon-online-booking"></i>
								<span class="booking-title">Reservas fáciles</span>
								<h3>Sin cargos adicionales</h3>
							</div>
						</div>
						<div class="col-lg-6 col-sm-6 single-tab">
							<div class="single-rooms">
								<i class="flaticon-podium"></i>
								<span class="booking-title">Mejor precio</span>
								<h3>Garantía de tarifa baja</h3>
							</div>
						</div>
						<div class="col-lg-6 col-sm-6 single-tab">
							<div class="single-rooms">
								<i class="flaticon-airport"></i>
								<span class="booking-title">Disponibilidad</span>
								<h3>Reservas 24/7</h3>
							</div>
						</div>
						<div class="col-lg-6 col-sm-6 single-tab">
							<div class="single-rooms">
								<i class="flaticon-slow"></i>
								<span class="booking-title">Conexión rápida</span>
								<h3>Wi-Fi de alta velocidad</h3>
							</div>
						</div>
						<div class="col-lg-6 col-sm-6 single-tab">
							<div class="single-rooms">
								<i class="flaticon-coffee-cup-1"></i>
								<span class="booking-title">Incluido</span>
								<h3>Desayuno gratuito</h3>
							</div>
						</div>
						<div class="col-lg-6 col-sm-6 single-tab">
							<div class="single-rooms">
								<i class="flaticon-user"></i>
								<span class="booking-title">Promoción especial</span>
								<h3>Acompañante gratis*</h3>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-7">
					<div class="tab_content">
						<!-- Las imágenes aquí también se pueden hacer dinámicas si se desea -->
						<div class="tabs_item">
							<div class="our-rooms-single-img room-bg-1"></div>
						</div>
						<div class="tabs_item">
							<div class="our-rooms-single-img room-bg-2"></div>
						</div>
						<div class="tabs_item">
							<div class="our-rooms-single-img room-bg-3"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Habitaciones -->
<section class="our-rooms-area pb-100">
	<div class="container">
		<div class="section-title">
			<span>Habitaciones</span>
			<h2>Explora nuestras habitaciones & suites</h2>
		</div>
		<div class="row">
            <?php foreach ($data['habitaciones'] as $habitacion) { ?>
                <div class="col-lg-4 col-sm-6">
                    <div class="single-rooms-three-wrap">
                        <div class="single-rooms-three">
                            <img src="<?php echo RUTA_PRINCIPAL . 'Assets/img/habitaciones/' . $habitacion['foto']; ?>" alt="<?php echo $habitacion['estilo']; ?>">
                            <div class="single-rooms-three-content">
                                <h3><?php echo $habitacion['estilo']; ?></h3>
                                <ul class="rating">
                                    <!-- Puedes hacer esto dinámico si tienes un sistema de calificación -->
                                    <li><i class="bx bxs-star"></i></li>
                                    <li><i class="bx bxs-star"></i></li>
                                    <li><i class="bx bxs-star"></i></li>
                                    <li><i class="bx bxs-star"></i></li>
                                    <li><i class="bx bxs-star"></i></li>
                                </ul>
                                <span class="price">Desde $<?php echo number_format($habitacion['precio']); ?>/noche</span>
                                <a href="<?php echo RUTA_PRINCIPAL . 'habitacion/detalle/' . $habitacion['slug']; ?>" class="default-btn">Ver Detalles <i class="flaticon-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
		</div>
	</div>
</section>

<?php include_once 'views/template/footer-principal.php'; ?>
