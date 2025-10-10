<?php include_once 'views/template/header-principal.php';
include_once 'views/template/portada.php'; ?>

<section class="reservation-area py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="text-primary fw-bold"><?php echo $data['title']; ?></span>
            <h2 class="fw-bold"><?php echo $data['subtitle']; ?></h2>
        </div>

        <div class="row g-4">
            <!-- Calendario -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>

            <!-- Formulario de reserva -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-4">Completa tu reserva</h5>
                        <form method="post" id="formulario"
                            action="<?php echo RUTA_PRINCIPAL . 'reserva/guardarPublica'; ?>">

                            <input type="hidden" name="metodo" value="1"> 

                            <div class="mb-3">
                                <label for="nombre" class="form-label fw-semibold">Nombre Completo</label>
                                <input type="text" name="nombre" id="nombre" class="form-control form-control-lg"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="correo" class="form-label fw-semibold">Correo Electrónico</label>
                                <input type="email" name="correo" id="correo" class="form-control form-control-lg"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="f_llegada" class="form-label fw-semibold">Fecha Llegada</label>
                                <input type="date" class="form-control form-control-lg" id="f_llegada" name="f_llegada"
                                    value="<?php echo $data['disponible']['f_llegada'] ?? ''; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="f_salida" class="form-label fw-semibold">Fecha Salida</label>
                                <input type="date" class="form-control form-control-lg" id="f_salida" name="f_salida"
                                    value="<?php echo $data['disponible']['f_salida'] ?? ''; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="habitacion" class="form-label fw-semibold">Habitación</label>
                                <select name="habitacion" id="habitacion" class="form-select form-select-lg" required>
                                    <option value="">Seleccionar</option>
                                    <?php foreach ($data['habitaciones'] as $habitacionItem) { ?>
                                        <option value="<?php echo $habitacionItem['id']; ?>" 
                                        data-precio="<?php echo $habitacionItem['precio']; ?>"
                                    <?php echo (isset($data['disponible']['habitacion']) && $habitacionItem['id'] == $data['disponible']['habitacion']) ? 'selected' : ''; ?>>
                                    <?php echo $habitacionItem['estilo']; ?>
                            </option>
                            <?php } ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label fw-semibold">Observaciones</label>
                                <textarea name="descripcion" id="descripcion" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Total Estimado</label>
                                <input type="text" id="totalReserva" class="form-control form-control-lg" readonly
                                    value="$0">
                            </div>

                            <!-- Contenedor para el mensaje de disponibilidad -->
                            <div id="disponibilidad-mensaje" class="mt-2 text-center fw-bold"></div>

                            <div class="d-grid mt-4">
                                <button class="btn btn-primary btn-lg fw-bold" type="submit">
                                    Procesar Reserva
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once 'views/template/footer-principal.php'; ?>
<script src="<?php echo RUTA_PRINCIPAL . 'assets/principal/js/pages/reservas.js?v=' . time(); ?>"></script>