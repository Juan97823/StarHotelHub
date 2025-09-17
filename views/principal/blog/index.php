<?php include_once 'views/template/header-principal.php'; ?>
<?php include_once 'views/template/portada.php'; ?>

<!-- Sección de Blog -->
<section class="news-area ptb-100 bg-light">
    <div class="container">
        <div class="section-title text-center">
            <span class="text-primary fw-bold">Nuestro Blog</span>
            <h2 class="fw-bold display-6">Últimas noticias y artículos</h2>
            <p class="text-muted">Mantente actualizado con tendencias, consejos y novedades del mundo hotelero.</p>
        </div>
        <div class="row g-4 mt-4">

            <?php if (!empty($data['entradas'])) { ?>
                <?php foreach ($data['entradas'] as $entrada) { ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                            <div class="position-relative">
                                <a href="<?php echo RUTA_PRINCIPAL . 'blog/detalle/' . $entrada['slug']; ?>">
                                    <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/entradas/' . $entrada['foto']; ?>" 
                                         class="card-img-top img-fluid" 
                                         alt="<?php echo $entrada['titulo']; ?>">
                                </a>
                                <span class="badge bg-primary position-absolute top-0 start-0 m-3 px-3 py-2">
                                    <?php echo $entrada['categorias']; ?>
                                </span>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3 small text-muted">
                                    <i class="flaticon-user me-2"></i> Admin 
                                    <span class="mx-2">·</span> 
                                    <i class="flaticon-conversation me-2"></i> 5 comentarios
                                </div>
                                <a href="<?php echo RUTA_PRINCIPAL . 'blog/detalle/' . $entrada['slug']; ?>" class="text-decoration-none">
                                    <h5 class="fw-bold text-dark mb-3"><?php echo $entrada['titulo']; ?></h5>
                                </a>
                                <p class="text-muted">
                                    <?php echo substr($entrada['descripcion'], 0, 120) . '...'; ?>
                                </p>
                                <a class="btn btn-outline-primary btn-sm mt-2" href="<?php echo RUTA_PRINCIPAL . 'blog/detalle/' . $entrada['slug']; ?>">
                                    Leer más <i class="flaticon-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <!-- Ejemplos reales si aún no hay entradas -->
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                        <img src="assets/img/entradas/hotel-sostenible.jpg" class="card-img-top" alt="Hoteles sostenibles">
                        <div class="card-body p-4">
                            <span class="badge bg-success mb-2">Sostenibilidad</span>
                            <h5 class="fw-bold">5 prácticas sostenibles que aplicamos en nuestros hoteles</h5>
                            <p class="text-muted">Descubre cómo StarHotelHub promueve el turismo responsable con energías limpias, reciclaje y consumo responsable...</p>
                            <a href="#" class="btn btn-outline-success btn-sm">Leer más</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                        <img src="assets/img/entradas/experiencias-vip.jpg" class="card-img-top" alt="Experiencias VIP">
                        <div class="card-body p-4">
                            <span class="badge bg-warning text-dark mb-2">Experiencias</span>
                            <h5 class="fw-bold">Experiencias VIP: mucho más que una estadía</h5>
                            <p class="text-muted">Te contamos cómo nuestras suites ofrecen experiencias exclusivas con spa, catas privadas y tours personalizados...</p>
                            <a href="#" class="btn btn-outline-warning btn-sm">Leer más</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                        <img src="assets/img/entradas/tecnologia-hotelera.jpg" class="card-img-top" alt="Tecnología hotelera">
                        <div class="card-body p-4">
                            <span class="badge bg-info text-dark mb-2">Innovación</span>
                            <h5 class="fw-bold">La tecnología que transforma la experiencia hotelera</h5>
                            <p class="text-muted">Desde check-in digital hasta habitaciones inteligentes, descubre cómo la innovación mejora cada estadía...</p>
                            <a href="#" class="btn btn-outline-info btn-sm">Leer más</a>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</section>
<!-- End News Area -->

<?php include_once 'views/template/footer-principal.php'; ?>
</body>
</html>
