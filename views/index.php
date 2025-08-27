<?php include_once 'views/template/header-principal.php'; ?>

<!-- Start Ecorik Slider Area -->
<section class="eorik-slider-area">
    <div class="eorik-slider owl-carousel owl-theme">
        <?php foreach ($data['sliders'] as $slider) { ?>
            <div class="eorik-slider-item" style=" background-image: url(<?php echo RUTA_PRINCIPAL . 'assets/img/sliders/' . $slider['foto']; ?>);">
                <div class="d-table">
                    <div class="d-table-cell">
                        <div class="container">
                            <div class="eorik-slider-text overflow-hidden one eorik-slider-text-one">
                                <h1><?php echo $slider['titulo']; ?> </h1>
                                <span><?php echo $slider['subtitulo']; ?></span>
                                <div class="slider-btn">
                                    <a class="default-btn" href="<?php echo $slider['url']; ?>">
                                        Más Información
                                        <i class="flaticon-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="white-shape">
        <img src="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/img/home-one/slider/white-shape.png" alt="Image">
    </div>
</section>
<!-- End Ecorik Slider Area -->

<!-- Start Check Area -->
<div class="check-area mb-minus-70">
    <div class="container">
        <form class="check-form" id="formulario" action="<?php echo RUTA_PRINCIPAL . 'reserva/verify'; ?>">
            <div class="row align-items-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="check-content">
                        <p>Fecha Llegada</p>
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker-1">
                                <i class="flaticon-calendar"></i>
                                <input type="text" class="form-control" id="f_llegada" name="f_llegada" value="<?php echo date('Y-m-d'); ?>">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-th"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="check-content">
                        <p>Fecha Salida</p>
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker-2">
                                <i class="flaticon-calendar"></i>
                                <input type="text" class="form-control" id="f_salida" name="f_salida" value="<?php echo date('Y-m-d'); ?>">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-th"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="check-content">

                        <div class="form-group">
                            <label for="habitacion" class="form-label">Habitaciones</label>
                            <select name="habitacion" class="select-auto" id="habitacion" style="width: 100%;">
                                <option value="">Seleccionar</option>
                                <?php foreach ($data['habitaciones'] as $habitacion) { ?>
                                    <option value="<?php echo $habitacion['id']; ?>"><?php echo $habitacion['estilo']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="col-lg-3">
                    <div class="check-btn check-content mb-0">
                        <button class="default-btn" type="submit">
                            Comprobar
                            <i class="flaticon-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End Check Section -->

<!-- Start Explore Area -->
<section class="explore-area pt-170 pb-100">
    <div class="container">
        <div class="section-title">
            <span>Explorar</span>
            <h2>Nosotros somos geniales para darte placer</h2>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="explore-img">
                    <img src="<?php echo RUTA_PRINCIPAL . 'assets'; ?>/img/RoomLujo.jpg" alt="Image">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="explore-content ml-30">
                    <h2>Lujo Inigualable en Cada Detalle</h2>
                    <p>Nuestras Suites de Lujo ofrecen un equilibrio perfecto entre elegancia, comodidad y modernidad. Diseñadas para los huéspedes más exigentes, cuentan con vistas impresionantes, una cama tamaño king, baño privado con jacuzzi, y una decoración cuidadosamente seleccionada para crear un ambiente relajante y exclusivo.</p>
                    <p>Disfruta de una experiencia inolvidable con servicio a la habitación, conexión Wi-Fi de alta velocidad, aire acondicionado, minibar y atención personalizada las 24 horas.</p>
                    <a href="about.html" class="default-btn">
                        explorar más
                        <i class="flaticon-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Explore Area -->

<!-- End Facilities Area -->
<section class="facilities-area pb-60">
    <div class="container">
        <div class="section-title">
            <span>Instalaciones</span>
            <h2>
                <h2>Instalaciones Completamente Asombrosas</h2>
            </h2>
        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="single-facilities-wrap">
                    <div class="single-facilities">
                        <i class="facilities-icon flaticon-pickup"></i>
                        <h3>Recepción y Traslados​</h3>
                        <p>Disfruta de nuestro servicio de recogida y traslado para una llegada sin preocupaciones. </p>
                        <a href="service-details.html" class="icon-btn">
                            <i class="flaticon-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="single-facilities-wrap">
                    <div class="single-facilities">
                        <i class="facilities-icon flaticon-coffee-cup"></i>
                        <h3>Bebida de Bienvenida</h3>
                        <p>Recíbete con un detalle especial y comienza tu experiencia con el mejor sabor.</p>
                        <a href="service-details.html" class="icon-btn">
                            <i class="flaticon-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="single-facilities-wrap">
                    <div class="single-facilities">
                        <i class="facilities-icon flaticon-garage"></i>
                        <h3>Zona de Parqueo</h3>
                        <p>Estacionamiento privado y seguro para tu comodidad durante toda tu estancia.</p>
                        <a href="service-details.html" class="icon-btn">
                            <i class="flaticon-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="single-facilities-wrap">
                    <div class="single-facilities">
                        <i class="facilities-icon flaticon-water"></i>
                        <h3>Agua Caliente y Fría 24/7</h3>
                        <p>Confort absoluto con suministro constante de agua caliente y fría en todas las habitaciones.</p>
                        <a href="service-details.html" class="icon-btn">
                            <i class="flaticon-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Facilities Area -->

<!-- End Incredible Area -->
<section class="incredible-area ptb-140 jarallax">
    <div class="container">
        <div class="incredible-content">
            <a href="https://www.youtube.com/watch?v=bk7McNUjWgw" class="video-btn popup-youtube">
                <i class="flaticon-play-button"></i>
            </a>
            <h2><span>¡Exclusivo!</span> ¿Reservas para hoy?</h2>
            <p>
                Te invitamos a disfrutar de una experiencia de lujo, con instalaciones de primer nivel y un servicio diseñado para superar tus expectativas. Haz tu reserva ahora y descubre el verdadero significado del descanso.
            </p>
            <a href="#" class="default-btn">
                Reserva Ahora
                <i class="flaticon-right"></i>
            </a>

        </div>
    </div>
    <div class="white-shape">
        <img src="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/img/shape/white-shape-top.png" alt="Image">
        <img src="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/img/shape/white-shape-bottom.png" alt="Image">
    </div>
</section>
<!-- End Incredible Area -->

<!-- Start Our Rooms Area -->
<section class="our-rooms-area pt-60 pb-100">
    <div class="container">
        <div class="section-title">
            <span>Nuestras Habitaciones</span>
            <h2>Habitaciones y suites fascinantes</h2>
        </div>
        <div class="tab industries-list-tab">
            <div class="row">
                <div class="col-lg-4">
                    <div style="margin-bottom: 20px;">
                        <label for="currency">Selecciona la moneda:</label>
                        <select id="currency">
                            <option value="USD" selected>Dólar (USD)</option>
                            <option value="EUR">Euro (EUR)</option>
                            <option value="COP">Peso Colombiano (COP)</option>
                        </select>
                    </div>

                    <ul class="tabs">
                        <li class="single-rooms">
                            <img src="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/img/rooms/button-img-1.jpg" alt="Imagen">
                            <div class="room-content">
                                <h3>Habitación Doble</h3>
                                <span class="price" data-usd="75.90">Desde $75.9/noche</span>
                            </div>
                        </li>
                        <li class="single-rooms">
                            <img src="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/img/rooms/button-img-2.jpg" alt="Imagen">
                            <div class="room-content">
                                <h3>Habitación de Lujo</h3>
                                <span class="price" data-usd="50.9">Desde $50.9/noche</span>
                            </div>
                        </li>
                        <li class="single-rooms">
                            <img src="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/img/rooms/button-img-3.jpg" alt="Imagen">
                            <div class="room-content">
                                <h3>Mejor Habitación</h3>
                                <span class="price" data-usd="70.9">Desde $70.9/noche</span>
                            </div>
                        </li>
                        <li class="single-rooms">
                            <img src="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/img/rooms/button-img-4.jpg" alt="Imagen">
                            <div class="room-content">
                                <h3>Habitación Clásica</h3>
                                <span class="price" data-usd="95.9">Desde $95.9/noche</span>
                            </div>
                        </li>
                        <li class="single-rooms">
                            <img src="<?php echo RUTA_PRINCIPAL . 'assets/principal'; ?>/img/rooms/button-img-5.jpg" alt="Imagen">
                            <div class="room-content">
                                <h3>Habitación Económica</h3>
                                <span class="price" data-usd="105.9">Desde $105.9/noche</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

</li>
</ul>
</div>
<!-- ... -->
<div class="col-lg-8">
    <div class="tab_content">
        <div class="tabs_item">
            <div class="our-rooms-single-img room-bg-1"></div>
            <span class="preview-item">Vista previa: Habitación Doble</span>
        </div>
        <div class="tabs_item">
            <div class="our-rooms-single-img room-bg-2"></div>
            <span class="preview-item">Vista previa: Habitación de Lujo</span>
        </div>
        <div class="tabs_item">
            <div class="our-rooms-single-img room-bg-3"></div>
            <span class="preview-item">Vista previa: Mejor Habitación</span>
        </div>
        <div class="tabs_item">
            <div class="our-rooms-single-img room-bg-4"></div>
            <span class="preview-item">Vista previa: Habitación Clásica</span>
        </div>
        <div class="tabs_item">
            <div class="our-rooms-single-img room-bg-5"></div>
            <span class="preview-item">Vista previa: Habitación Económica</span>
        </div>
    </div>
</div>

</div>
</div>
</div>
</div>
</section>
<!-- End Our Rooms Area -->

<!-- Start City View Area -->
<section class="city-view-area ptb-100">
    <div class="container">
        <div class="city-wrap">
            <div class="single-city-item owl-carousel owl-theme">
                <div class="city-view-single-item">
                    <div class="city-content">
                        <span>Vista de la Ciudad</span>
                        <h3>Una vista encantadora del centro</h3>
                        <p>Descubre el encanto de la ciudad desde una perspectiva única. Disfruta de paisajes urbanos, arquitectura vibrante y el ritmo acogedor de la vida local.</p>
                        <p>Una experiencia visual que combina historia, cultura y modernidad. Ideal para los amantes de las ciudades con alma.</p>
                    </div>
                </div>
                <div class="city-view-single-item">
                    <div class="city-content">
                        <span>Vista de la Ciudad</span>
                        <h3>La mejor vista del casco urbano</h3>
                        <p>Sumérgete en una vista panorámica que captura la esencia del destino. Cada amanecer y atardecer se convierte en un espectáculo desde nuestras instalaciones.</p>
                        <p>Perfecto para relajarte, tomar fotos memorables o simplemente dejarte maravillar.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- End City View Area -->

<!-- Start Exclusive Area -->
<section class="exclusive-area pt-100 pb-70">
    <div class="container">
        <div class="section-title">
            <span>Ofertas Exclusivas</span>
            <h2>Aprovecha nuestras promociones especiales</h2>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="exclusive-wrap">
                    <div class="row">
                        <div class="col-lg-6 pr-0">
                            <div class="exclusive-img bg-1"></div>
                        </div>
                        <div class="col-lg-6 pl-0">
                            <div class="exclusive-content">
                                <span class="title">Hasta 30% de descuento</span>
                                <h3>Natación para hombres</h3>
                                <span class="review">
                                    4.5
                                    <a href="#">(432 opiniones)</a>
                                </span>
                                <p>Disfruta de una experiencia acuática exclusiva en nuestras instalaciones con atención profesional.</p>
                                <ul>
                                    <li><i class="bx bx-time"></i> Duración: 2 horas</li>
                                    <li><i class="bx bx-target-lock"></i> Mayores de 18 años</li>
                                </ul>
                                <a href="book-table.html" class="default-btn">
                                    Reservar ahora
                                    <i class="flaticon-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="exclusive-wrap">
                    <div class="row">
                        <div class="col-lg-6 pr-0">
                            <div class="exclusive-img bg-2"></div>
                        </div>
                        <div class="col-lg-6 pl-0">
                            <div class="exclusive-content">
                                <span class="title">Solo por este mes</span>
                                <h3>Desayuno por solo $5</h3>
                                <span class="review">
                                    5.0
                                    <a href="#">(580 opiniones)</a>
                                </span>
                                <p>Comienza tu día con un delicioso desayuno completo por un precio increíble. Oferta limitada.</p>
                                <ul>
                                    <li><i class="bx bx-time"></i> Duración: 2 horas</li>
                                    <li><i class="bx bx-target-lock"></i> Mayores de 18 años</li>
                                </ul>
                                <a href="book-table.html" class="default-btn">
                                    Reservar ahora
                                    <i class="flaticon-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- End Exclusive Area -->

<!-- Start Booking Area -->
<section class="bokking-area pb-70">
    <div class="container">
        <div class="section-title">
            <span>Reservas</span>
            <h2>Beneficios de reservar directamente</h2>

        </div>

        <div class="row">
            <div class="booking-col-2">
                <div class="single-booking">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <i class="book-icon flaticon-online-booking"></i>
                        <span class="booking-title">Free cost</span>
                        <h3>Sin costo de reserva</h3>


                    </a>

                    <div class="modal fade" id="staticBackdrop">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">No booking fee</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <p>Realiza tu reserva sin cargos adicionales. Transparencia garantizada desde el primer paso.</p>
                                </div>

                                <div class="modal-footer">
                                    <a href="book-table.html" class="default-btn">
                                        Book Now
                                        <i class="flaticon-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="booking-col-2">
                <div class="single-booking">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop-2">
                        <i class="book-icon flaticon-podium"></i>
                        <span class="booking-title">Free cost</span>
                        <h3>Mejor tarifa garantizada</h3>
                    </a>

                    <div class="modal fade" id="staticBackdrop-2">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Best rate guarantee</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <p>Reservar directo te asegura el mejor precio disponible en línea. ¡Compruébalo tú mismo!</p>
                                </div>

                                <div class="modal-footer">
                                    <a href="book-table.html" class="default-btn">
                                        Book Now
                                        <i class="flaticon-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="booking-col-2">
                <div class="single-booking">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop-3">
                        <i class="book-icon flaticon-airport"></i>
                        <span class="booking-title">Free cost</span>
                        <h3>Reservas 24/7</h3>
                    </a>

                    <div class="modal fade" id="staticBackdrop-3">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Reservations 24/7</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <p>Estamos disponibles todo el día, todos los días, para que puedas planear tu viaje en cualquier momento.</p>
                                </div>

                                <div class="modal-footer">
                                    <a href="book-table.html" class="default-btn">
                                        Book Now
                                        <i class="flaticon-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="booking-col-2">
                <div class="single-booking">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop-4">
                        <i class="book-icon flaticon-slow"></i>
                        <span class="booking-title">Free cost</span>
                        <h3>Wi-Fi de Alta Velocidad</h3>
                    </a>

                    <div class="modal fade" id="staticBackdrop-4">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">High-speed Wi-Fi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <p>Conexión estable y veloz disponible en todas las áreas del hotel. Perfecto para trabajo o entretenimiento.</p>
                                </div>

                                <div class="modal-footer">
                                    <a href="book-table.html" class="default-btn">
                                        Book Now
                                        <i class="flaticon-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="booking-col-2">
                <div class="single-booking">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop-5">
                        <i class="book-icon flaticon-coffee-cup-1"></i>
                        <span class="booking-title">Free cost</span>
                        <h3>Desayuno incluido</h3>
                    </a>

                    <div class="modal fade" id="staticBackdrop-5">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Free breakfast</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <p>Empieza tu día con energía gracias a un desayuno completo cortesía de la casa.</p>
                                </div>

                                <div class="modal-footer">
                                    <a href="book-table.html" class="default-btn">
                                        Book Now
                                        <i class="flaticon-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Booking Area -->

<!-- Start Restaurants Area -->
<section class="restaurants-area pb-100">
    <div class="container-fluid p-0">
        <div class="section-title">
            <span>Instalaciones</span>
            <h2>Lo que puedes disfrutar en StarHotelHub</h2>
        </div>

        <div class="restaurants-wrap owl-carousel owl-theme">
            <div class="single-restaurants bg-1">
                <i class="restaurants-icon flaticon-coffee-cup"></i>
                <span>Restaurantes</span>
                <p>Sabores únicos en nuestros espacios gastronómicos. Disfruta de cocina internacional y platos locales preparados por chefs expertos.</p>
                <a href="#" class="default-btn">
                    Explorar más
                    <i class="flaticon-right"></i>
                </a>
            </div>
            <div class="single-restaurants bg-2">
                <i class="restaurants-icon flaticon-swimming"></i>
                <span>Piscina</span>
                <p>Zona de relajación con piscina climatizada, tumbonas y bar. Ideal para disfrutar del sol y la tranquilidad.</p>
                <a href="#" class="default-btn">
                    Explorar más
                    <i class="flaticon-right"></i>
                </a>
            </div>
            <div class="single-restaurants bg-3">
                <i class="restaurants-icon flaticon-speaker"></i>
                <span>Sala de conferencias</span>
                <p>Espacios totalmente equipados para eventos, reuniones o presentaciones corporativas. Tecnología y comodidad en un solo lugar.</p>
                <a href="#" class="default-btn">
                    Explorar más
                    <i class="flaticon-right"></i>
                </a>
            </div>
            <div class="single-restaurants bg-4">
                <i class="restaurants-icon flaticon-podium"></i>
                <span>Mejor tarifa</span>
                <p>Al reservar directamente con nosotros obtienes los mejores precios del mercado sin comisiones ocultas.</p>
                <a href="#" class="default-btn">
                    Explorar más
                    <i class="flaticon-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- End Restaurants Area -->

<!-- start Testimonials Area -->
<section class="testimonials-area pb-100">
    <div class="container">
        <div class="section-title">
            <span>Testimonios</span>
            <h2>Lo que opinan nuestros clientes</h2>
        </div>
        <div class="testimonials-wrap owl-carousel owl-theme">
            <div class="single-testimonials">
                <ul>
                    <li><i class="bx bxs-star"></i></li>
                    <!-- ... -->
                </ul>
                <h3>Habitación excelente</h3>
                <p>“Increíble experiencia. Todo impecable, cómodo y con excelente atención. ¡Volveremos sin duda!”</p>
                <div class="testimonials-content">
                    <img src="..." alt="Imagen">
                    <h4>Ayman Jenis</h4>
                    <span>CEO @Leasuely</span>
                </div>
            </div>
            <!-- Puedes duplicar esto para los otros testimonios -->
        </div>
    </div>
</section>

<!-- End Testimonials Area -->

<!-- End News Area -->
<section class="news-area pb-60">
    <div class="container">
        <div class="section-title">
            <span>Nuestro Blog</span>
            <h2>Novedades y artículos</h2>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="single-news">
                    <div class="news-img">
                        <a href="news-details.html">
                            <img src="..." alt="Imagen">
                        </a>
                        <div class="dates">
                            <span>HOTEL</span>
                        </div>
                    </div>
                    <div class="news-content-wrap">
                        <ul>
                            <li><i class="flaticon-user"></i> Admin</li>
                            <li><i class="flaticon-conversation"></i> Comentarios</li>
                        </ul>
                        <a href="news-details.html">
                            <h3>Celebrando una década del hotel en 2020</h3>
                        </a>
                        <p>Explora la historia, los logros y el crecimiento de nuestro hotel durante la última década.</p>
                        <a class="read-more" href="news-details.html">
                            Leer más <i class="flaticon-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Repite para las demás noticias -->
        </div>
    </div>
</section>

<!-- End News Area -->

<?php include_once 'views/template/footer-principal.php';

if (!empty($_GET['respuesta']) && $_GET['respuesta'] == 'warning') { ?>

    <script>
        alertaSW('TODO LOS CAMPOS SON REQUERIDOS', 'warning');
    </script>

<?php } ?>
<script src="<?php echo RUTA_PRINCIPAL . 'assets/principal/js/pages/disponibilidad.js'; ?>"></script>

<script src="<?php echo RUTA_PRINCIPAL . 'assets/principal/js/pages/index.js'; ?>"></script>
<script>
    const currencySelect = document.getElementById('currency');
    const prices = document.querySelectorAll('.price');

    const conversionRates = {
        USD: 1,
        EUR: 0.91,
        COP: 4139.49 // puedes actualizarlo dinámicamente si quieres
    };

    const symbols = {
        USD: '$',
        EUR: '€',
        COP: '$'
    };

    currencySelect.addEventListener('change', () => {
        const selectedCurrency = currencySelect.value;

        prices.forEach(price => {
            const usdValue = parseFloat(price.dataset.usd);
            const converted = usdValue * conversionRates[selectedCurrency];

            let formatted = converted.toLocaleString('es-CO', {
                style: 'currency',
                currency: selectedCurrency,
                minimumFractionDigits: selectedCurrency === 'COP' ? 0 : 2,
                maximumFractionDigits: selectedCurrency === 'COP' ? 0 : 2
            });

            price.innerHTML = `Desde ${formatted}/noche`;
        });
    });
</script>


</body>

</html>