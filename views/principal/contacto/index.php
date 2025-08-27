<?php  include_once 'views/template/header-principal.php'; 
include_once 'views/template/portada.php'; ?>

<!-- Start Contact Area -->
<section class="main-contact-area contact-info-area contact-info-three pt-100 pb-70">
	<div class="container">
		<div class="section-title">
			<span>Contact Us</span>
			<h2>Drop us a message for any query</h2>
			<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eaque quibusdam deleniti porro praesentium. Aliquam minus quisquam velit in at nam.</p>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="contact-wrap contact-pages">
					<div class="contact-form contact-form-mb">
						<form id="contactForm">
							<div class="row">
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
										<input type="text" name="name" id="name" class="form-control" required data-error="Please enter your name" placeholder="Your Name">
										<div class="help-block with-errors"></div>
									</div>
								</div>

								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
										<input type="email" name="email" id="email" class="form-control" required data-error="Please enter your email" placeholder="Your Email">
										<div class="help-block with-errors"></div>
									</div>
								</div>

								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
										<input type="text" name="phone_number" id="phone_number" required data-error="Please enter your number" class="form-control" placeholder="Your Phone">
										<div class="help-block with-errors"></div>
									</div>
								</div>

								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
										<input type="text" name="msg_subject" id="msg_subject" class="form-control" required data-error="Please enter your subject" placeholder="Your Subject">
										<div class="help-block with-errors"></div>
									</div>
								</div>

								<div class="col-lg-12 col-md-12">
									<div class="form-group">
										<textarea name="message" class="form-control textarea-hight" id="message" cols="30" rows="4" required data-error="Write your message" placeholder="Your Message"></textarea>
										<div class="help-block with-errors"></div>
									</div>
								</div>

								<div class="col-lg-12 col-md-12">
									<button type="submit" class="default-btn btn-two">
										Send Message
										<i class="flaticon-right"></i>
									</button>
									<div id="msgSubmit" class="h3 text-center hidden"></div>
									<div class="clearfix"></div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="row">
					<div class="col-lg-6 col-sm-6">
						<div class="single-contact-info">
							<i class="bx bx-envelope"></i>
							<h3>Email Us:</h3>
							<a href="mailto:hello@arduix.com">hello@ecorik.com</a>
							<a href="mailto:info@arduix.com">info@ecorik.com</a>
						</div>
					</div>
					<div class="col-lg-6 col-sm-6">
						<div class="single-contact-info">
							<i class="bx bx-phone-call"></i>
							<h3>Call Us:</h3>
							<a href="tel:+(123)1800-567-8990">Tel. + (123) 1800-567-8990</a>
							<a href="tel:+(124)1523-567-9874">Tel. + (124) 1523-567-9874</a>
						</div>
					</div>
					<div class="col-lg-6 col-sm-6">
						<div class="single-contact-info">
							<i class="bx bx-location-plus"></i>
							<h3>London</h3>
							<a href="#">205 Fida Walinton, Tongo Street Front The USA</a>
						</div>
					</div>
					<div class="col-lg-6 col-sm-6">
						<div class="single-contact-info">
							<i class="bx bx-phone-call"></i>
							<h3>Call Us:</h3>
							<a href="tel:+(123)1800-567-8990">Tel. + (123) 1800-567-8990</a>
							<a href="tel:+(124)1523-567-9874">Tel. + (124) 1523-567-9874</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End Contact Area -->

<!-- Start Map Area -->
<div class="map-area">
	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193595.15830869428!2d-74.119763973046!3d40.69766374874431!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1608494047082!5m2!1sen!2sbd"></iframe>
</div>
<!-- End Map Area -->
<?php include_once 'views/template/footer-principal.php'; ?>

</body>

</html>