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

        <!-- Switcher de tema (puedes eliminarlo si no quieres que el cliente lo vea) -->
        <div class="switcher-wrapper">
            <div class="switcher-btn"><i class='bx bx-cog bx-spin'></i></div>
            <div class="switcher-body">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 text-uppercase">Personalizar Tema</h5>
                    <button type="button" class="btn-close ms-auto close-switcher" aria-label="Cerrar"></button>
                </div>
                <hr />
                <h6 class="mb-0">Estilos de Tema</h6>
                <hr />
                <div class="d-flex align-items-center justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="themeStyle" id="lightmode" checked>
                        <label class="form-check-label" for="lightmode">Claro</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="themeStyle" id="darkmode">
                        <label class="form-check-label" for="darkmode">Oscuro</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="themeStyle" id="semidark">
                        <label class="form-check-label" for="semidark">Semi oscuro</label>
                    </div>
                </div>
                <hr />
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="minimaltheme" name="themeStyle">
                    <label class="form-check-label" for="minimaltheme">Minimalista</label>
                </div>
                <hr />
                <h6 class="mb-0">Colores del Encabezado</h6>
                <hr />
                <div class="header-colors-indigators">
                    <div class="row row-cols-auto g-3">
                        <?php for ($i = 1; $i <= 8; $i++): ?>
                            <div class="col">
                                <div class="indigator headercolor<?php echo $i; ?>" id="headercolor<?php echo $i; ?>"></div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
                <hr />
                <h6 class="mb-0">Colores de la Barra Lateral</h6>
                <hr />
                <div class="header-colors-indigators">
                    <div class="row row-cols-auto g-3">
                        <?php for ($i = 1; $i <= 8; $i++): ?>
                            <div class="col">
                                <div class="indigator sidebarcolor<?php echo $i; ?>" id="sidebarcolor<?php echo $i; ?>"></div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts JS -->
        <script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/js/jquery.min.js'; ?>"></script>
        <script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/js/bootstrap.bundle.min.js'; ?>"></script>
        <script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/plugins/simplebar/js/simplebar.min.js'; ?>"></script>
        <script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/plugins/metismenu/js/metisMenu.min.js'; ?>"></script>
        <script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/plugins/chartjs/js/Chart.min.js'; ?>"></script>
        <script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/js/app.js'; ?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            const base_url = '<?php echo RUTA_PRINCIPAL; ?>';
        </script>
        <script src="<?php echo RUTA_PRINCIPAL . 'assets/admin/js/custom.js'; ?>"></script>