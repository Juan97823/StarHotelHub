<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexion = new mysqli('localhost', 'root', '', 'starhotelhub'); // Ajusta si usas otro usuario o contraseña
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $clave = $_POST['clave'];
    $confirmar = $_POST['confirmar'];

    if ($clave !== $confirmar) {
        echo "<script>alert('Las contraseñas no coinciden');</script>";
    } else {
        $clave_encriptada = password_hash($clave, PASSWORD_DEFAULT);

        $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, correo, clave, rol) VALUES (?, ?, ?, 2)");
        $stmt->bind_param("sss", $nombre, $correo, $clave_encriptada);

        if ($stmt->execute()) {
            echo "<script>alert('Cuenta registrada exitosamente'); window.location.href='login';</script>";
        } else {
            echo "<script>alert('Error al registrar: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }

    $conexion->close();
}
?>

<?php include_once 'views/template/header-principal.php'; ?>
<?php include_once 'views/template/portada.php'; ?>

<section class="user-area-all-style sign-up-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="contact-form-action">
                    <div class="form-heading text-center">
                        <h3 class="form-title">Create an account!</h3>
                        <p class="form-desc">With your email address.</p>
                    </div>
                    <form method="post">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="nombre" placeholder="Nombre completo" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <input class="form-control" type="email" name="correo" placeholder="Correo electrónico" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <input class="form-control" type="password" name="clave" placeholder="Contraseña" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <input class="form-control" type="password" name="confirmar" placeholder="Confirmar contraseña" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-condition">
                                <div class="agree-label">
                                    <input type="checkbox" id="chb1" required>
                                    <label for="chb1">Acepto la <a href="#">política de privacidad</a></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="default-btn btn-two" type="submit">
                                    Registrar Cuenta
                                    <i class="flaticon-right"></i>
                                </button>
                            </div>
                            <div class="col-12">
                                <p class="account-desc">
                                    ¿Ya tienes una cuenta?
                                    <a href="<?php echo RUTA_PRINCIPAL . 'login'; ?>">Inicia sesión aquí</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once 'views/template/footer-principal.php'; ?>
<script src="<?php echo RUTA_PRINCIPAL . 'assets/principal/js/pages/registro.js'; ?>"></script>
</body>

</html>