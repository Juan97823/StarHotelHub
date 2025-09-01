<?php  include_once 'views/template/header-principal.php'; 
include_once 'views/template/portada.php'; ?>
<!-- End News Area -->
<section class="news-area ptb-100">
	<div class="container">
		<div class="section-title">
			<span>Nuestro Blog</span>
			<h2>Noticias y artículos</h2>
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
							<li>
								<a href="#">
									<i class="flaticon-user"></i>
									Admin
								</a>
							</li>
							<li>
								<a href="#">
									<i class="flaticon-conversation"></i>
									Comentarios
								</a>
							</li>
						</ul>
						<a href="<?php echo RUTA_PRINCIPAL . 'blog/detalle/' . $entrada['slug']; ?>">
							<h3><?php echo $entrada['titulo']; ?></h3>
						</a>
						<p><?php echo substr($entrada['descripcion'], 0, 100) . '...'; ?></p>
						<a class="read-more" href="<?php echo RUTA_PRINCIPAL . 'blog/detalle/' . $entrada['slug']; ?>">
							Leer más
							<i class="flaticon-right"></i>
						</a>
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