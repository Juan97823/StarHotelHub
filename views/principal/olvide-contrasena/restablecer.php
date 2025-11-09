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
                            <i class="bx bx-key"></i> Restablecer Contraseña
                        </h3>
                        <p class="form-desc">Hola <strong><?php echo htmlspecialchars($nombre); ?></strong>, ingresa tu nueva contraseña.</p>
                    </div>

                    <form id="formRestablecerContrasena" autocomplete="off">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                        
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="password" class="form-label">Nueva Contraseña</label>
                                <div class="input-group">
                                    <input class="form-control" type="password" id="password" name="password" 
                                           placeholder="Mínimo 6 caracteres" required minlength="6">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bx bx-show"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Debe tener al menos 6 caracteres</small>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="password_confirm" class="form-label">Confirmar Contraseña</label>
                                <div class="input-group">
                                    <input class="form-control" type="password" id="password_confirm" name="password_confirm" 
                                           placeholder="Repite la contraseña" required minlength="6">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                        <i class="bx bx-show"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <button class="default-btn btn-two w-100" type="submit">
                                    Cambiar Contraseña <i class="flaticon-right ms-2"></i>
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

                    <div class="alert alert-warning mt-4" role="alert">
                        <i class="bx bx-info-circle"></i> <strong>Importante:</strong> Este enlace es válido por 1 hora. 
                        Tu contraseña actual seguirá funcionando hasta que confirmes el cambio.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formRestablecerContrasena');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirm');
    const togglePassword = document.getElementById('togglePassword');
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');

    // Toggle mostrar/ocultar contraseña
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.querySelector('i').classList.toggle('bx-show');
        this.querySelector('i').classList.toggle('bx-hide');
    });

    togglePasswordConfirm.addEventListener('click', function() {
        const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirmInput.setAttribute('type', type);
        this.querySelector('i').classList.toggle('bx-show');
        this.querySelector('i').classList.toggle('bx-hide');
    });

    // Validar que las contraseñas coincidan en tiempo real
    passwordConfirmInput.addEventListener('input', function() {
        if (passwordInput.value !== passwordConfirmInput.value) {
            passwordConfirmInput.setCustomValidity('Las contraseñas no coinciden');
        } else {
            passwordConfirmInput.setCustomValidity('');
        }
    });

    passwordInput.addEventListener('input', function() {
        if (passwordConfirmInput.value && passwordInput.value !== passwordConfirmInput.value) {
            passwordConfirmInput.setCustomValidity('Las contraseñas no coinciden');
        } else {
            passwordConfirmInput.setCustomValidity('');
        }
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Validar que las contraseñas coincidan
        if (passwordInput.value !== passwordConfirmInput.value) {
            alertaSW('Las contraseñas no coinciden', 'warning');
            return;
        }

        // Validar longitud mínima
        if (passwordInput.value.length < 6) {
            alertaSW('La contraseña debe tener al menos 6 caracteres', 'warning');
            return;
        }

        const formData = new FormData(form);
        const url = '<?php echo RUTA_PRINCIPAL; ?>olvidecontrasena/procesarRestablecimiento';

        // Deshabilitar botón de envío
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Procesando...';

        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else if (response.status === 403) {
                return response.json().then(data => {
                    throw { status: 403, msg: data.msg || 'Token inválido' };
                });
            } else if (response.status === 400) {
                return response.json().then(data => {
                    throw { status: 400, msg: data.msg || 'Solicitud inválida' };
                });
            } else {
                throw { status: response.status, msg: 'Error en el servidor' };
            }
        })
        .then(data => {
            alertaSW(data.msg, data.tipo);
            if (data.tipo === 'success') {
                form.reset();
                setTimeout(() => {
                    window.location.href = data.redirect || '<?php echo RUTA_PRINCIPAL; ?>login';
                }, 2000);
            } else {
                // Rehabilitar botón
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Cambiar Contraseña <i class="flaticon-right ms-2"></i>';
                recargarToken();
            }
        })
        .catch(error => {
            // Rehabilitar botón
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Cambiar Contraseña <i class="flaticon-right ms-2"></i>';
            
            if (error.status === 403 || error.status === 400) {
                alertaSW(error.msg, 'error');
                recargarToken();
            } else {
                alertaSW('Error al procesar la solicitud. Intenta de nuevo.', 'error');
            }
        });
    });
});

function recargarToken() {
    const csrfInput = document.querySelector('input[name="csrf_token"]');
    if (csrfInput) {
        fetch('<?php echo RUTA_PRINCIPAL; ?>api/csrf-token')
            .then(response => response.json())
            .then(data => {
                if (data.token) {
                    csrfInput.value = data.token;
                }
            })
            .catch(() => {
                location.reload();
            });
    }
}
</script>

<?php include_once 'views/template/footer-principal.php'; ?>

