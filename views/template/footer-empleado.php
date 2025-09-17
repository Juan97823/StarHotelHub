<!-- Overlay y botón volver arriba -->
<div class="overlay toggle-icon"></div>
<a href="javascript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>

<!-- Footer -->
<footer class="page-footer">
    <p class="mb-0">© <?php echo date('Y'); ?> StarHotelHub. Todos los derechos reservados.</p>
</footer>
</div> <!-- Fin de .wrapper -->

<!-- Scripts JS base -->
<script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/js/jquery.min.js'; ?>"></script>
<script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/js/bootstrap.bundle.min.js'; ?>"></script>
<script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/plugins/simplebar/js/simplebar.min.js'; ?>"></script>
<script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/plugins/metismenu/js/metisMenu.min.js'; ?>"></script>
<script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/plugins/chartjs/js/Chart.min.js'; ?>"></script>
<script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/js/app.js'; ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- URL base -->
<script>
    const base_url = '<?php echo RUTA_PRINCIPAL; ?>';

    // Función para cerrar sesión
    function cerrarSesion() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Cerrarás sesión en tu cuenta.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cerrar sesión',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = base_url + 'empleado/logout';
            }
        });
    }
</script>

<!-- Scripts personalizados de empleado -->
<script src="<?php echo RUTA_PRINCIPAL . 'assets/empleado/js/pages/dashboard.js'; ?>"></script>
<script src="<?php echo RUTA_PRINCIPAL . 'assets/empleado/js/custom.js'; ?>"></script>

</body>
</html>
