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
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3 small text-muted">
                                    <i class="flaticon-user me-2"></i> Admin
                                    <span class="mx-2">·</span>
                                    <i class="flaticon-conversation me-2"></i> 5 comentarios
                                </div>
                                <h5 class="fw-bold text-dark mb-3"><?php echo $entrada['titulo']; ?></h5>
                                <p class="text-muted">
                                    <?php echo substr($entrada['descripcion'], 0, 120) . '...'; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>

        </div>
    </div>
</section>
<!-- End News Area -->

<?php include_once 'views/template/footer-principal.php'; ?>
</body>

</html>