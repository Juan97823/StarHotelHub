<?php  
include_once 'views/template/header-principal.php'; 
include_once 'views/template/portada.php'; 
?>

<!-- Área de Contacto -->
<section class="main-contact-area contact-info-area contact-info-three pt-100 pb-70">
    <div class="container">
        <div class="section-title">
            <span>Contáctanos</span>
            <h2>¿Tienes alguna pregunta? ¡Escríbenos!</h2>
            <p>En StarHotelHub estamos para ayudarte. Completa el formulario y nuestro equipo se pondrá en contacto contigo a la brevedad.</p>
        </div>
        <div class="row">
            <!-- Formulario de Contacto -->
            <div class="col-lg-6">
                <div class="contact-wrap contact-pages">
                    <div class="contact-form contact-form-mb">
                        <form id="contactForm">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="name" id="name" class="form-control" required data-error="Por favor ingresa tu nombre" placeholder="Tu Nombre">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="email" name="correo" id="correo" class="form-control" required data-error="Por favor ingresa tu correo" placeholder="Tu Correo">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="phone_number" id="phone_number" required data-error="Por favor ingresa tu teléfono" class="form-control" placeholder="Tu Teléfono">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="msg_subject" id="msg_subject" class="form-control" required data-error="Por favor ingresa el asunto" placeholder="Asunto">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <textarea name="message" class="form-control textarea-hight" id="message" cols="30" rows="4" required data-error="Escribe tu mensaje" placeholder="Mensaje"></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <button type="submit" class="default-btn btn-two">
                                        Enviar Mensaje
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

            <!-- Información de Contacto -->
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="single-contact-info">
                            <i class="bx bx-envelope"></i>
                            <h3>Correo Electrónico:</h3>
                            <a href="mailto:contacto@starhotelhub.com">contacto@starhotelhub.com</a>
                            <a href="mailto:reservas@starhotelhub.com">reservas@starhotelhub.com</a>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6">
                        <div class="single-contact-info">
                            <i class="bx bx-phone-call"></i>
                            <h3>Teléfonos:</h3>
                            <a href="tel:+571234567890">+57 1 234 567 890</a>
                            <a href="tel:+573001234567">+57 300 123 4567</a>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6">
                        <div class="single-contact-info">
                            <i class="bx bx-location-plus"></i>
                            <h3>Dirección:</h3>
                            <a href="#">Calle Principal 123, Bogotá, Colombia</a>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6">
                        <div class="single-contact-info">
                            <i class="bx bx-time"></i>
                            <h3>Horario:</h3>
                            <p>Lunes a Domingo: 08:00 - 22:00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Área del Mapa -->
<div class="map-area">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.123456789!2d-74.08175!3d4.60971!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f99a123456789%3A0x123456789abcdef!2sBogot%C3%A1%2C%20Colombia!5e0!3m2!1ses!2sco!4v1234567890" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</div>

<?php include_once 'views/template/footer-principal.php'; ?>
