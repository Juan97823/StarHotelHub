<?php include 'header.php';?>

<!-- banner -->
<div class="banner">           
    <img src="images/photos/banner.jpg"  class="img-responsive" alt="slide">
    <div class="welcome-message">
        <div class="wrap-info">
            <div class="information">
                <h1 class="animated fadeInDown">StarHotelhub</h1>
                <p class="animated fadeInUp">Gestión Empresarial de Prueba</p>                
            </div>
            <a href="#informacion" class="arrow-nav scroll wowload fadeInDownBig"><i class="fa fa-angle-down"></i></a>
        </div>
    </div>
</div>
<!-- banner -->

<!-- informacion-reserva -->
<div id="informacion" class="spacer reserve-info">
<div class="container">
<div class="row">
<div class="col-sm-7 col-md-8">
    <div class="embed-responsive embed-responsive-16by9 wowload fadeInLeft">
        <iframe class="embed-responsive-item" width="100%" height="400" frameborder="0" allowfullscreen></iframe>
    </div>
</div>
<div class="col-sm-5 col-md-4">
<h3>Reservar</h3>
    <form role="form" class="wowload fadeInRight">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Nombre">
        </div>
        <div class="form-group">
            <input type="email" class="form-control" placeholder="Correo Electrónico">
        </div>
        <div class="form-group">
            <input type="tel" class="form-control" placeholder="Teléfono">
        </div>        
        <div class="form-group">
            <div class="row">
                <div class="col-xs-6">
                    <select class="form-control">
                        <option>Número de Habitaciones</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>        
                <div class="col-xs-6">
                    <select class="form-control">
                        <option>Número de Adultos</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-xs-4">
                    <select class="form-control" name="dia">
                        <option>Día</option>
                        <?php for ($i = 1; $i <= 31; $i++) echo "<option>$i</option>"; ?>
                    </select>
                </div>
                <div class="col-xs-4">
                    <select class="form-control" name="mes">
                        <option>Mes</option>
                        <option value="01">Enero</option>
                        <option value="02">Febrero</option>
                        <option value="03">Marzo</option>
                        <option value="04">Abril</option>
                        <option value="05">Mayo</option>
                        <option value="06">Junio</option>
                        <option value="07">Julio</option>
                        <option value="08">Agosto</option>
                        <option value="09">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>
                <div class="col-xs-4">
                    <select class="form-control" name="año">
                        <option>Año</option>
                        <?php for ($y = date('Y'); $y >= 2013; $y--) echo "<option>$y</option>"; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <textarea class="form-control" placeholder="Mensaje" rows="4"></textarea>
        </div>
        <button class="btn btn-default">Enviar</button>
    </form>    
</div>
</div>  
</div>
</div>
<!-- informacion-reserva -->

<!-- servicios -->
<div class="spacer services wowload fadeInUp">
<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <div id="RoomCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="item active"><img src="images/photos/8.jpg" class="img-responsive" alt="Habitaciones"></div>                
                    <div class="item"><img src="images/photos/9.jpg" class="img-responsive" alt="Habitaciones"></div>
                    <div class="item"><img src="images/photos/10.jpg" class="img-responsive" alt="Habitaciones"></div>
                </div>
                <a class="left carousel-control" href="#RoomCarousel" role="button" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                <a class="right carousel-control" href="#RoomCarousel" role="button" data-slide="next"><i class="fa fa-angle-right"></i></a>
            </div>
            <div class="caption">Habitaciones<a href="rooms-tariff.php" class="pull-right"><i class="fa fa-edit"></i></a></div>
        </div>

        <div class="col-sm-4">
            <div id="TourCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="item active"><img src="images/photos/6.jpg" class="img-responsive" alt="Tours"></div>
                    <div class="item"><img src="images/photos/3.jpg" class="img-responsive" alt="Tours"></div>
                    <div class="item"><img src="images/photos/4.jpg" class="img-responsive" alt="Tours"></div>
                </div>
                <a class="left carousel-control" href="#TourCarousel" role="button" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                <a class="right carousel-control" href="#TourCarousel" role="button" data-slide="next"><i class="fa fa-angle-right"></i></a>
            </div>
            <div class="caption">Paquetes Turísticos<a href="controller/principal/gallery.php" class="pull-right"><i class="fa fa-edit"></i></a></div>
        </div>

        <div class="col-sm-4">
            <div id="FoodCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="item active"><img src="images/photos/1.jpg" class="img-responsive" alt="Comida"></div>
                    <div class="item"><img src="images/photos/2.jpg" class="img-responsive" alt="Comida"></div>
                    <div class="item"><img src="images/photos/5.jpg" class="img-responsive" alt="Comida"></div>
                </div>
                <a class="left carousel-control" href="#FoodCarousel" role="button" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                <a class="right carousel-control" href="#FoodCarousel" role="button" data-slide="next"><i class="fa fa-angle-right"></i></a>
            </div>
            <div class="caption">Comida y Bebidas<a href="gallery.php" class="pull-right"><i class="fa fa-edit"></i></a></div>
        </div>
    </div>
</div>
</div>
<!-- servicios -->

<?php include 'footer.php';?>
