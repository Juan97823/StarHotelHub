<?php include 'views/template/header-principal.php'; ?>

<div class="login-container">
    <!-- Columna del Formulario -->
    <div class="login-form-column">
        <div class="login-form-container">
            
            <!-- Logo y Nombre -->
            <div class="logo-container">
                <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/Logo.png'; ?>" alt="StarHotelHub Logo" class="logo-icon">
                <h2 class="logo-text">StarHotelHub</h2>
            </div>

            <!-- Encabezado del Formulario -->
            <div class="form-header">
                <h1>Bienvenido de nuevo</h1>
                <p>Inicia sesión para acceder a tu panel de control.</p>
            </div>

            <!-- Formulario de Login -->
            <form id="formulario" autocomplete="off">
                <input type="hidden" name="csrf_token" value="<?php echo generarCsrfToken(); ?>">
                
                <div class="form-group">
                    <label for="usuario">Correo electrónico o usuario</label>
                    <input id="usuario" class="form-control" type="text" name="usuario" placeholder="tucorreo@ejemplo.com">
                </div>

                <div class="form-group">
                    <label for="clave">Contraseña</label>
                    <input id="clave" class="form-control" type="password" name="clave" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                </div>

                <div class="form-options">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Recuérdame</label>
                    </div>
                    <a href="#" class="forgot-password-link">¿Olvidaste tu contraseña?</a>
                </div>

                <button class="login-btn" type="submit">Iniciar sesión</button>

                <div class="register-link">
                    <p>¿No tienes una cuenta? <a href="<?php echo RUTA_PRINCIPAL . 'registro'; ?>">Regístrate</a></p>
                </div>

            </form>
        </div>
    </div>

    <!-- Columna de la Imagen -->
    <div class="login-image-column"></div>

</div>

<?php include_once 'views/template/footer-login.php'; ?>
<script src="<?php echo RUTA_PRINCIPAL . 'assets/principal/js/pages/login.js'; ?>"></script>