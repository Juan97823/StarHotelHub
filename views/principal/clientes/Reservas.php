<?php include_once 'views/template/header-cliente.php'; ?>

<div class="container py-5">
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
            <h4 class="fw-bold mb-0"><i class='bx bx-calendar-edit me-2'></i>Gestionar Mis Reservas</h4>
            <a href="<?php echo RUTA_PRINCIPAL; ?>habitaciones" class="btn btn-light fw-bold">+ Nueva Reserva</a>
        </div>
        <div class="card-body p-4">
            <?php if (empty($data['reservas'])) : ?>
                <div class="text-center py-5">
                    <i class="bx bx-calendar-x bx-lg text-muted mb-3"></i>
                    <h5 class="mb-3">Aún no tienes reservas.</h5>
                    <p class="text-muted">¡Anímate a explorar nuestras habitaciones y encuentra tu estancia perfecta!</p>
                </div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Habitación</th>
                                <th>Fechas</th>
                                <th>Monto Total</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['reservas'] as $reserva) : ?>
                                <tr id="reserva-<?php echo $reserva['id']; ?>">
                                    <td class="fw-semibold"><?php echo $reserva['tipo']; ?></td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            <i class="bx bx-calendar-check me-1"></i>
                                            <?php echo date("d/m/y", strtotime($reserva['fecha_ingreso'])); ?>
                                        </span>
                                        <i class="bx bx-right-arrow-alt mx-1"></i>
                                        <span class="badge bg-light text-dark">
                                            <i class="bx bx-calendar-x me-1"></i>
                                            <?php echo date("d/m/y", strtotime($reserva['fecha_salida'])); ?>
                                        </span>
                                    </td>
                                    <td class="fw-bold">$<?php echo number_format($reserva['monto_total'], 2); ?></td>
                                    <td class="text-center">
                                        <?php
                                        $estado = ['texto' => 'Cancelada', 'clase' => 'danger', 'icono' => 'x-circle'];
                                        if ($reserva['estado'] == 1) $estado = ['texto' => 'Pendiente', 'clase' => 'warning', 'icono' => 'clock'];
                                        if ($reserva['estado'] == 2) $estado = ['texto' => 'Completada', 'clase' => 'success', 'icono' => 'check-circle'];
                                        ?>
                                        <span class="badge bg-<?php echo $estado['clase']; ?>-soft text-<?php echo $estado['clase']; ?> p-2">
                                            <i class="bx bxs-<?php echo $estado['icono']; ?> me-1"></i><?php echo $estado['texto']; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($reserva['estado'] == 1) : //  1 es PENDIENTE ?>
                                            <button class="btn btn-danger btn-sm btn-cancelar" data-id="<?php echo $reserva['id']; ?>">
                                                <i class="bx bx-x-circle me-1"></i>Cancelar
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-info btn-sm btn-ver-detalle" data-id="<?php echo $reserva['id']; ?>">
                                                <i class="bx bx-info-circle me-1"></i>Ver Detalle
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal de Detalle de Reserva -->
<div class="modal fade" id="detalleReservaModal" tabindex="-1" aria-labelledby="detalleReservaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title fw-bold" id="detalleReservaModalLabel">
                    <i class="bx bx-receipt me-2"></i>Detalle de Reserva
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="detalleReservaContent">
                <!-- Contenido cargado dinámicamente -->
            </div>
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnDescargarFactura">
                    <i class="bx bx-download me-1"></i>Descargar Factura
                </button>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/template/footer-cliente.php'; ?>

<script>
    // Manejar clic en "Ver Detalle"
    document.querySelectorAll('.btn-ver-detalle').forEach(btn => {
        btn.addEventListener('click', function() {
            const reservaId = this.getAttribute('data-id');
            cargarDetalleReserva(reservaId);
        });
    });

    function cargarDetalleReserva(reservaId) {
        const url = base_url + 'cliente/reservas/detalle/' + reservaId;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarDetalleReserva(data.reserva);
                    const modal = new bootstrap.Modal(document.getElementById('detalleReservaModal'));
                    modal.show();
                } else {
                    Swal.fire('Error', data.message || 'No se pudo cargar el detalle', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Error de conexión', 'error');
            });
    }

    function mostrarDetalleReserva(reserva) {
        const estadoMap = {
            0: { texto: 'Cancelada', clase: 'danger', icono: 'x-circle' },
            1: { texto: 'Pendiente', clase: 'warning', icono: 'clock' },
            2: { texto: 'Completada', clase: 'success', icono: 'check-circle' },
            3: { texto: 'Completada', clase: 'success', icono: 'check-circle' }
        };

        const estado = estadoMap[reserva.estado] || estadoMap[0];

        const html = `
            <div class="row g-4">
                <!-- Información Principal -->
                <div class="col-12">
                    <div class="card border-0 bg-light rounded-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-muted small mb-1">Número de Reserva</p>
                                    <h6 class="fw-bold">${reserva.cod_reserva || 'N/A'}</h6>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted small mb-1">Estado</p>
                                    <span class="badge bg-${estado.clase}-soft text-${estado.clase} p-2">
                                        <i class="bx bxs-${estado.icono} me-1"></i>${estado.texto}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detalles de la Habitación -->
                <div class="col-12 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-light border-0 p-3">
                            <h6 class="fw-bold mb-0"><i class="bx bxs-hotel me-2"></i>Habitación</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                <strong>Tipo:</strong> ${reserva.tipo || 'N/A'}
                            </p>
                            <p class="mb-2">
                                <strong>Número:</strong> ${reserva.numero_habitacion || 'N/A'}
                            </p>
                            <p class="mb-0">
                                <strong>Categoría:</strong> ${reserva.categoria || 'N/A'}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Fechas de Estadía -->
                <div class="col-12 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-light border-0 p-3">
                            <h6 class="fw-bold mb-0"><i class="bx bx-calendar me-2"></i>Fechas</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                <strong>Check-in:</strong> ${formatearFecha(reserva.fecha_ingreso)}
                            </p>
                            <p class="mb-2">
                                <strong>Check-out:</strong> ${formatearFecha(reserva.fecha_salida)}
                            </p>
                            <p class="mb-0">
                                <strong>Noches:</strong> ${calcularNoches(reserva.fecha_ingreso, reserva.fecha_salida)}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Información de Facturación -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-light border-0 p-3">
                            <h6 class="fw-bold mb-0"><i class="bx bx-receipt me-2"></i>Facturación</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-muted small mb-1">Precio por Noche</p>
                                    <h6 class="fw-bold">$${parseFloat(reserva.precio_noche || 0).toFixed(2)}</h6>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted small mb-1">Subtotal</p>
                                    <h6 class="fw-bold">$${parseFloat(reserva.subtotal || 0).toFixed(2)}</h6>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <p class="text-muted small mb-1">Impuestos</p>
                                    <h6 class="fw-bold">$${parseFloat(reserva.impuestos || 0).toFixed(2)}</h6>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <p class="text-muted small mb-1">Total</p>
                                    <h5 class="fw-bold text-primary">$${parseFloat(reserva.monto || 0).toFixed(2)}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información del Cliente -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-light border-0 p-3">
                            <h6 class="fw-bold mb-0"><i class="bx bx-user me-2"></i>Información del Cliente</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                <strong>Nombre:</strong> ${reserva.nombre_cliente || 'N/A'}
                            </p>
                            <p class="mb-2">
                                <strong>Email:</strong> ${reserva.email || 'N/A'}
                            </p>
                            <p class="mb-0">
                                <strong>Teléfono:</strong> ${reserva.telefono || 'N/A'}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Notas o Descripción -->
                ${reserva.descripcion ? `
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-light border-0 p-3">
                            <h6 class="fw-bold mb-0"><i class="bx bx-note me-2"></i>Notas</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">${reserva.descripcion}</p>
                        </div>
                    </div>
                </div>
                ` : ''}
            </div>
        `;

        document.getElementById('detalleReservaContent').innerHTML = html;
    }

    function formatearFecha(fecha) {
        const date = new Date(fecha);
        return date.toLocaleDateString('es-ES', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    function calcularNoches(fechaIngreso, fechaSalida) {
        const inicio = new Date(fechaIngreso);
        const fin = new Date(fechaSalida);
        const diferencia = fin - inicio;
        return Math.ceil(diferencia / (1000 * 60 * 60 * 24));
    }

    // Descargar factura
    document.getElementById('btnDescargarFactura').addEventListener('click', function() {
        Swal.fire('Información', 'La funcionalidad de descarga de factura estará disponible pronto', 'info');
    });
</script>