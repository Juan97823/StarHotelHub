<?php 
include_once 'views/template/header-principal.php'; 
include_once 'views/template/portada.php';
$csrf_token = generarCsrfToken();
?>

<section class="user-area-all-style sign-up-area ptb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <div class="contact-form-action shadow-lg p-5 rounded bg-white">
                    <div class="form-heading text-center">
                        <h3 class="form-title">
                            <i class="bx bx-lock-open"></i> Recuperar Contraseña
                        </h3>
                        <p class="form-desc">Ingresa tu correo y te enviaremos una contraseña temporal.</p>
                    </div>

                    <form id="formRecuperarContrasena" autocomplete="off">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        
                        <div class="row">
                            <div class="col-12 mb-3">
                                <input class="form-control" type="email" name="correo" placeholder="Correo electrónico" required>
                            </div>
                            
                            <div class="col-12">
                                <button class="default-btn btn-two w-100" type="submit">
                                    Enviar Instrucciones <i class="flaticon-right ms-2"></i>
                                </button>
                            </div>
                            
                            <div class="col-12 text-center mt-3">
                                <p class="account-desc">
                                    ¿Recordaste tu contraseña? 
                                    <a href="<?php echo RUTA_PRINCIPAL . 'Login'; ?>">Iniciar sesión</a>
                                </p>
                            </div>
                        </div>
                    </form>

                    <div class="alert alert-info mt-4" role="alert">
                        <strong>¿Cómo funciona?</strong>
                        <ul class="mb-0 mt-2">
                            <li>Ingresa el correo asociado a tu cuenta</li>
                            <li>Recibirás un email con una contraseña temporal</li>
                            <li>Usa esa contraseña para acceder a tu cuenta</li>
                            <li>Cambia tu contraseña en tu perfil</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formRecuperarContrasena');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const url = '<?php echo RUTA_PRINCIPAL; ?>olvidecontrasena/recuperar';
        
        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alertaSW(data.msg, data.tipo);
            if (data.tipo === 'success') {
                form.reset();
                setTimeout(() => {
                    window.location.href = '<?php echo RUTA_PRINCIPAL; ?>login';
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alertaSW('Error al procesar la solicitud', 'error');
        });
    });
});
</script>

<?php include_once 'views/template/footer-principal.php'; ?>

