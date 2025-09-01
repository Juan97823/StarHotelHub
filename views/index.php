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
                    <ul class="tabs">
                        <?php foreach ($data['habitaciones'] as $habitacion) { ?>
                        <li class="single-rooms">
                            <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/habitaciones/' . $habitacion['foto']; ?>" alt="<?php echo $habitacion['estilo']; ?>">
                            <div class="room-content">
                                <h3><?php echo $habitacion['estilo']; ?></h3>
                                <span class="price">Desde $<?php echo number_format($habitacion['precio']); ?>/noche</span>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="col-lg-8">
                    <div class="tab_content">
                        <?php foreach ($data['habitaciones'] as $habitacion) { ?>
                        <div class="tabs_item">
                            <div class="our-rooms-single-img" style="background-image: url(<?php echo RUTA_PRINCIPAL . 'assets/img/habitaciones/' . $habitacion['foto']; ?>)"></div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Our Rooms Area -->

<!-- End News Area -->
<section class="news-area pb-60">
    <div class="container">
        <div class="section-title">
            <span>Nuestro Blog</span>
            <h2>Novedades y artículos</h2>
        </div>
        <div class="row">
            <?php foreach ($data['entradas'] as $entrada) { ?>
                <div class="col-lg-4 col-md-6">
                    <div class="single-news">
                        <div class="news-img">
                            <a href="<?php echo RUTA_PRINCIPAL . 'blog/detalle/' . $entrada['slug']; ?>">
                                <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/entradas/' . $entrada['foto']; ?>" alt="<?php echo $entrada['titulo']; ?>">
                            </a>
                            <div class="dates">
                                <span><?php echo $entrada['categorias']; ?></span>
                            </div>
                        </div>
                        <div class="news-content-wrap">
                            <ul>
                                <li><i class="flaticon-user"></i> <?php echo $entrada['autor']; ?></li>
                            </ul>
                            <a href="<?php echo RUTA_PRINCIPAL . 'blog/detalle/' . $entrada['slug']; ?>">
                                <h3><?php echo $entrada['titulo']; ?></h3>
                            </a>
                            <p><?php echo substr($entrada['descripcion'], 0, 100) . '...'; ?></p>
                            <a class="read-more" href="<?php echo RUTA_PRINCIPAL . 'blog/detalle/' . $entrada['slug']; ?>">
                                Leer más <i class="flaticon-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
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
</body>

</html>