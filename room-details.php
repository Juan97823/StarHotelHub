<?php include 'header.php'; ?>

<div class="container">

<h1 class="title">Suites de Lujo</h1>

<!-- Carrusel de imágenes -->
<div id="RoomDetails" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="item active"><img src="images/photos/8.jpg" class="img-responsive" alt="slide"></div>
        <div class="item height-full"><img src="images/photos/9.jpg" class="img-responsive" alt="slide"></div>
        <div class="item height-full"><img src="images/photos/10.jpg" class="img-responsive" alt="slide"></div>
    </div>
    <!-- Controles -->
    <a class="left carousel-control" href="#RoomDetails" role="button" data-slide="prev"><i class="fa fa-angle-left"></i></a>
    <a class="right carousel-control" href="#RoomDetails" role="button" data-slide="next"><i class="fa fa-angle-right"></i></a>
</div>

<!-- Detalles de la habitación -->
<div class="room-features spacer">
    <div class="row">
        <div class="col-sm-12 col-md-5"> 
            <p>Nuestras Suites de Lujo ofrecen un equilibrio perfecto entre elegancia, comodidad y modernidad. Diseñadas para los huéspedes más exigentes, cuentan con vistas impresionantes, una cama tamaño king, baño privado con jacuzzi, y una decoración cuidadosamente seleccionada para crear un ambiente relajante y exclusivo.</p>
            <p>Disfruta de una experiencia inolvidable con servicio a la habitación, conexión Wi-Fi de alta velocidad, aire acondicionado, minibar y atención personalizada las 24 horas.</p>
        </div>

        <div class="col-sm-6 col-md-3 amenitites"> 
            <h3>Amenidades</h3>    
            <ul>
                <li>Cama tamaño king con sábanas premium</li>
                <li>Jacuzzi privado y ducha tipo lluvia</li>
                <li>TV inteligente con canales internacionales</li>
                <li>Wi-Fi de alta velocidad</li>
                <li>Servicio a la habitación 24/7</li>
                <li>Minibar y cafetera</li>
            </ul>
        </div>  

        <div class="col-sm-3 col-md-2">
            <div class="size-price">Tamaño<span>44 m²</span></div>
        </div>

        <div class="col-sm-3 col-md-2">
    <div class="size-price">Precio <span id="dynamic-price">Cargando...</span></div>
</div>

<script>
  fetch('https://ipapi.co/json/')
    .then(response => response.json())
    .then(data => {
      const currency = data.currency;
      const prices = {
        'USD': '$200 / noche',
        'EUR': '€185 / noche',
        'COP': '$780.000 / noche',
        'MXN': 'MX$3,400 / noche',
        'BRL': 'R$990 / noite',
        'GBP': '£160 / night'
      };

      const defaultPrice = '$200 / noche';
      const priceElement = document.getElementById('dynamic-price');

      priceElement.innerText = prices[currency] || defaultPrice;
    })
    .catch(error => {
      console.error('Error al detectar la ubicación:', error);
      document.getElementById('dynamic-price').innerText = '$200 / noche';
    });
</script>

    </div>
</div>

</div>

<?php include 'footer.php'; ?>
