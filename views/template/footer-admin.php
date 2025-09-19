</div> <!-- Fin de .page-content -->
</div> <!-- Fin de .page-wrapper -->

<!-- Overlay de fondo y botón volver arriba -->
<div class="overlay toggle-icon"></div>
<a href="javascript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>

<!-- Footer -->
<footer class="page-footer">
    <p class="mb-0">© <?php echo date('Y'); ?> StarHotelHub. Todos los derechos reservados.</p>
</footer>
</div> <!-- Fin de .wrapper -->

<!-- Scripts JS ESENCIALES -->
<script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/js/jquery.min.js'; ?>"></script>
<script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/js/bootstrap.bundle.min.js'; ?>"></script>
<script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/plugins/simplebar/js/simplebar.min.js'; ?>"></script>
<script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/plugins/metismenu/js/metisMenu.min.js'; ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Scripts de PLUGINS (DataTables, Gráficos, etc.) -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/plugins/chartjs/js/Chart.min.js'; ?>"></script>

<!-- Scripts de la APLICACIÓN -->
<script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/js/app.js'; ?>"></script>
<script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/js/custom.js'; ?>"></script>

<!-- Variables Globales JS -->
<script>
    const base_url = '<?php echo RUTA_PRINCIPAL; ?>';
</script>

<!-- Scripts específicos de la PÁGINA -->
<script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/js/Pages/reservas.js'; ?>"></script>
<script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/js/Pages/Blog.js'; ?>"></script>

</body>
</html>
