<?php include_once 'views/template/header-principal.php'; ?>

<style>
    .our-rooms-area .single-rooms-item .rooms-img {
        height: 250px;
        overflow: hidden;
    }

    .our-rooms-area .single-rooms-item .rooms-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
</style>

<!-- Start Ecorik Slider Area -->
<section class="eorik-slider-area">
    <div class="eorik-slider owl-carousel owl-theme">
        <?php foreach ($data['sliders'] as $slider): ?>
            <div class="eorik-slider-item"
                style="background-image: url('<?= htmlspecialchars(RUTA_PRINCIPAL . 'assets/img/sliders/' . $slider['foto'], ENT_QUOTES, 'UTF-8'); ?>');">
                <div class="d-table">
                    <div class="d-table-cell">
                        <div class="container">
                            <div class="eorik-slider-text overflow-hidden one eorik-slider-text-one">
                                <h1><?= htmlspecialchars($slider['titulo']); ?></h1>
                                <span><?= htmlspecialchars($slider['subtitulo']); ?></span>
                                <div class="slider-btn">
                                    <a class="default-btn" href="<?= htmlspecialchars($slider['url']); ?>">
                                        Más Información
                                        <i class="flaticon-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="white-shape">
        <img src="<?= RUTA_PRINCIPAL . 'assets/principal'; ?>/img/home-one/slider/white-shape.png" alt="Image">
    </div>
</section>
<!-- End Ecorik Slider Area -->

<!-- Start Check Area -->
<div class="check-area mb-minus-70">
    <div class="container">
        <form class="check-form" id="formulario" action="<?= htmlspecialchars(RUTA_PRINCIPAL . 'reserva/verify'); ?>">
            <div class="row align-items-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="check-content">
                        <p>Fecha Llegada</p>
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker-1">
                                <i class="flaticon-calendar"></i>
                                <input type="text" class="form-control" id="f_llegada" name="f_llegada"
                                    value="<?= date('Y-m-d'); ?>">
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
                                <input type="text" class="form-control" id="f_salida" name="f_salida"
                                    value="<?= date('Y-m-d'); ?>">
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
                                <?php foreach ($data['habitaciones'] as $habitacion): ?>
                                    <option value="<?= htmlspecialchars($habitacion['id']); ?>">
                                        <?= htmlspecialchars($habitacion['estilo']); ?></option>
                                <?php endforeach; ?>
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
        <div class="rooms-slider owl-carousel owl-theme">
            <?php foreach ($data['habitaciones'] as $habitacion): ?>
                <div class="single-rooms-item">
                    <div class="rooms-img">
                        <a href="room-details.html">
                            <img loading="lazy"
                                src="<?= htmlspecialchars(RUTA_PRINCIPAL . 'assets/img/habitaciones/' . $habitacion['foto']); ?>"
                                alt="<?= htmlspecialchars($habitacion['estilo']); ?>">
                        </a>
                    </div>
                    <div class="rooms-content">
                        <h3><a href="room-details.html"><?= htmlspecialchars($habitacion['estilo']); ?></a></h3>
                        <span class="price">Desde $<?= number_format($habitacion['precio']); ?>/noche</span>
                    </div>
                </div>
            <?php endforeach; ?>
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
            <?php foreach ($data['entradas'] as $entrada): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="single-news">
                        <div class="news-img">
                            <a href="<?= htmlspecialchars(RUTA_PRINCIPAL . 'blog/detalle/' . $entrada['slug']); ?>">
                                <img loading="lazy"
                                    src="<?= htmlspecialchars(RUTA_PRINCIPAL . 'assets/img/entradas/' . $entrada['foto']); ?>"
                                    alt="<?= htmlspecialchars($entrada['titulo']); ?>">
                            </a>
                            <div class="dates">
                                <span><?= htmlspecialchars($entrada['categoriass']); ?></span>
                            </div>
                        </div>
                        <div class="news-content-wrap">
                            <ul>
                                <li><i class="flaticon-user"></i> <?= htmlspecialchars($entrada['autor']); ?></li>
                            </ul>
                            <a href="<?= htmlspecialchars(RUTA_PRINCIPAL . 'blog/detalle/' . $entrada['slug']); ?>">
                                <h3><?= htmlspecialchars($entrada['titulo']); ?></h3>
                            </a>
                            <p><?= htmlspecialchars(substr($entrada['descripcion'], 0, 100)) . '...'; ?></p>
                            <a class="read-more"
                                href="<?= htmlspecialchars(RUTA_PRINCIPAL . 'blog/detalle/' . $entrada['slug']); ?>">
                                Leer más <i class="flaticon-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- End News Area -->


<?php include_once 'views/template/footer-principal.php';

if (!empty($_GET['respuesta']) && $_GET['respuesta'] === 'warning') { ?>

    <script>
        alertaSW('TODO LOS CAMPOS SON REQUERIDOS', 'warning');
    </script>

<?php } ?>
<script src="<?= htmlspecialchars(RUTA_PRINCIPAL . 'assets/principal/js/pages/disponibilidad.js'); ?>"></script>

<script>
    $(document).ready(function () {
        $('.rooms-slider').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        });
    });
</script>

</body>

</html>