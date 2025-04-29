<?php include 'header.php'; ?>

<div class="container">
    <h2>Habitaciones y Tarifas</h2>
    <div class="row">
        <?php
        // Lista de habitaciones con nombre, imagen y descripción en español
        $habitaciones = [
            ["imagen" => "8.jpg", "nombre" => "Suite de Lujo A", "descripcion" => "Una suite acogedora con vista al jardín, ideal para parejas que buscan relajarse."],
            ["imagen" => "9.jpg", "nombre" => "Suite de Lujo B", "descripcion" => "Amplia suite con cama king y baño moderno."],
            ["imagen" => "10.jpg", "nombre" => "Suite de Lujo C", "descripcion" => "Diseño elegante y vistas al mar desde un balcón privado."],
            ["imagen" => "11.jpg", "nombre" => "Suite de Lujo D", "descripcion" => "Suite de lujo con ropa de cama premium y servicio personalizado."],
            ["imagen" => "9.jpg", "nombre" => "Suite de Lujo E", "descripcion" => "Suite familiar con dos camas dobles y zona de juegos."],
            ["imagen" => "8.jpg", "nombre" => "Suite de Lujo F", "descripcion" => "Tranquila y silenciosa, perfecta para estancias largas."],
            ["imagen" => "10.jpg", "nombre" => "Suite de Lujo G", "descripcion" => "Suite moderna con área de trabajo y televisión inteligente."],
            ["imagen" => "11.jpg", "nombre" => "Suite de Lujo H", "descripcion" => "Decoración clásica europea con acabados lujosos."],
            ["imagen" => "9.jpg", "nombre" => "Suite de Lujo I", "descripcion" => "Vistas panorámicas de la ciudad y un ambiente relajante."],
            ["imagen" => "8.jpg", "nombre" => "Suite de Lujo J", "descripcion" => "Encanto rústico con comodidad moderna, ideal para lunas de miel."],
            ["imagen" => "11.jpg", "nombre" => "Suite de Lujo K", "descripcion" => "Suite ecológica con materiales sostenibles y estilo moderno."],
            ["imagen" => "10.jpg", "nombre" => "Suite de Lujo L", "descripcion" => "Diseño minimalista para huéspedes que aman la simplicidad y elegancia."]
        ];

        // Mostrar cada habitación
        foreach ($habitaciones as $hab) {
            echo '
            <div class="col-sm-6 wowload fadeInUp">
                <div class="rooms">
                    <img src="images/photos/' . $hab["imagen"] . '" class="img-responsive">
                    <div class="info">
                        <h3>' . htmlspecialchars($hab["nombre"]) . '</h3>
                        <p>' . htmlspecialchars($hab["descripcion"]) . '</p>
                        <a href="room-details.php" class="btn btn-default">Ver Detalles</a>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>

    <!-- Paginación -->
    <div class="text-center">
        <ul class="pagination">
            <li class="disabled"><a href="#">«</a></li>
            <li class="active"><a href="#">1 <span class="sr-only">(actual)</span></a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">»</a></li>
        </ul>
    </div>
</div>

<?php include 'footer.php'; ?>
