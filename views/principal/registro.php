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

<!-- Start Sign Up Area -->
<section class="user-area-all-style sign-up-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="contact-form-action">
                    <div class="form-heading text-center">
                        <h3 class="form-title">Crear una cuenta!</h3>
                    </div>
                    <form id="formulario" autocomplete="off">
                        <div class="row">
                            <div class="col-12">
                                <button class="default-btn w-100 py-3 fs-5" type="submit">
                                    <i class="bx bxl-google me-2 fs-4"></i> Iniciar sesión con Google
                                </button>
                            </div>
                            </button>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <input class="form-control" type="text" name="nombre" placeholder="Nombre Completo">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <input class="form-control" type="email" name="correo" placeholder="Correo Electrónico">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <input class="form-control" type="text" name="clave" placeholder="contraseña">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 ">
                            <div class="form-group">
                                <input class="form-control" type="text" name="confirmar" placeholder="Confirmar contraseña">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-condition">
                            <div class="agree-label">
                                <input type="checkbox" id="chb1">
                                <label for="chb1">
                                    I agree with Haipe's
                                    <a href="#">Privacy Policy</a>
                                </label>
                            </div>
                            <div class="col-12">
                                <button class="default-btn btn-two" type="submit">
                                    Registrar Cuenta
                                    <i class="flaticon-right"></i>
                                </button>
                            </div>
                            <div class="col-12">
                                <p class="account-desc">
                                    Already have an account?
                                    <a href="login"> Login</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Sign Up Area -->
<?php include_once 'views/template/footer-principal.php'; ?>

<script src="<?php echo RUTA_PRINCIPAL . 'assets/principal/js/pages/registro.js'; ?>"></script>
</body>

</html>