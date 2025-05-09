<?php include 'header.php';?>
<div class="container">

    <h1 class="title">Contacto</h1>

    <!-- formulario de contacto -->
    <div class="contact">

        <div class="row">

            <div class="col-sm-12">
                <div class="map mb-4">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.6897633195393!2d-74.057904!3d4.673932!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9a95cf99f385%3A0x577d39069b97d5b!2sHotel%20Estelar%20Parque%20de%20la%2093!5e0!3m2!1ses!2sco!4v1714400000000!5m2!1ses!2sco" 
                        width="100%" 
                        height="300" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <div class="col-sm-6 col-sm-offset-3">
                <div class="spacer">
                    <h4>Escríbenos</h4>
                    <form role="form">
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" placeholder="Nombre completo">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" placeholder="Correo electrónico">
                        </div>
                        <div class="form-group">
                            <input type="tel" class="form-control" id="phone" placeholder="Teléfono">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" placeholder="Mensaje" rows="4"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Enviar</button>
                    </form>
                </div>
            </div>

        </div>

    </div>
    <!-- /formulario de contacto -->

</div>
<?php include 'footer.php'; ?>
