<?php 
include_once 'views/template/header-principal.php'; 
include_once 'views/template/portada.php';
$temp_password = $data['temp_password'] ?? 0;
?>

<section class="user-area-all-style sign-up-area ptb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <div class="contact-form-action shadow-lg p-5 rounded bg-white">
                    <div class="form-heading text-center">
                        <h3 class="form-title">
                            <i class="bx bx-lock-alt"></i> Cambiar Contraseña
                        </h3>
                        <?php if ($temp_password == 1): ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            <i class="bx bx-error-circle"></i>
                            <strong>¡Atención!</strong> Estás usando una contraseña temporal. 
                            Por seguridad, debes cambiarla antes de continuar.
                        </div>
                        <?php else: ?>
                        <p class="form-desc">Actualiza tu contraseña para mantener tu cuenta segura.</p>
                        <?php endif; ?>
                    </div>

                    <form id="formCambiarContrasena" autocomplete="off">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="password_actual" class="form-label">Contraseña Actual *</label>
                                <input class="form-control" type="password" id="password_actual" name="password_actual" 
                                       placeholder="Ingresa tu contraseña actual" required>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label for="password_nueva" class="form-label">Nueva Contraseña *</label>
                                <input class="form-control" type="password" id="password_nueva" name="password_nueva" 
                                       placeholder="Ingresa tu nueva contraseña" required minlength="6">
                                <small class="text-muted">Mínimo 6 caracteres</small>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label for="confirmar_password" class="form-label">Confirmar Nueva Contraseña *</label>
                                <input class="form-control" type="password" id="confirmar_password" name="confirmar_password" 
                                       placeholder="Confirma tu nueva contraseña" required minlength="6">
                            </div>
                            
                            <div class="col-12">
                                <button class="default-btn btn-two w-100" type="submit">
                                    Actualizar Contraseña <i class="flaticon-right ms-2"></i>
                                </button>
                            </div>
                            
                            <?php if ($temp_password == 0): ?>
                            <div class="col-12 text-center mt-3">
                                <a href="<?php echo RUTA_PRINCIPAL . 'cliente/dashboard'; ?>" class="text-muted">
                                    <i class="bx bx-arrow-back"></i> Volver al Dashboard
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const frm = document.querySelector("#formCambiarContrasena");
    const tempPassword = <?php echo $temp_password; ?>;
    
    if (!frm) return;

    frm.addEventListener("submit", function (e) {
        e.preventDefault();

        const password_actual = frm.password_actual.value.trim();
        const password_nueva = frm.password_nueva.value.trim();
        const confirmar_password = frm.confirmar_password.value.trim();

        if (password_actual === "" || password_nueva === "" || confirmar_password === "") {
            alertaSW("Todos los campos son obligatorios", "warning");
            return;
        }

        if (password_nueva !== confirmar_password) {
            alertaSW("Las nuevas contraseñas no coinciden", "warning");
            return;
        }

        if (password_nueva.length < 6) {
            alertaSW("La contraseña debe tener al menos 6 caracteres", "warning");
            return;
        }

        const http = new XMLHttpRequest();
        const url = base_url + "perfil/actualizarContrasena";
        http.open("POST", url, true);
        http.send(new FormData(frm));

        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                try {
                    const res = JSON.parse(this.responseText);
                    alertaSW(res.msg, res.tipo);

                    if (res.tipo === "success") {
                        frm.reset();
                        setTimeout(() => {
                            // Si era contraseña temporal, redirigir al dashboard
                            if (tempPassword == 1) {
                                window.location = base_url + "cliente/dashboard";
                            } else {
                                window.location = base_url + "perfil";
                            }
                        }, 1600);
                    }
                } catch (e) {
                    alertaSW("Error al procesar la respuesta del servidor", "error");
                }
            }
        };

        http.onerror = function () {
            alertaSW("Error de conexión. Intenta de nuevo.", "error");
        };
    });
});
</script>

<?php include_once 'views/template/footer-principal.php'; ?>

