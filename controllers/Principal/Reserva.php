<?php
class Reserva extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cargarModel('Reserva');

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    // Verifica disponibilidad de la habitación
    public function verify()
    {
        $f_llegada = $_GET['f_llegada'] ?? null;
        $f_salida = $_GET['f_salida'] ?? null;
        $habitacion = $_GET['habitacion'] ?? null;

        if (!$f_llegada || !$f_salida || !$habitacion) {
            header('Location:' . RUTA_PRINCIPAL . '?respuesta=warning');
            exit;
        }

        $f_llegada = strClean($f_llegada);
        $f_salida = strClean($f_salida);
        $habitacion = strClean($habitacion);

        $reserva = $this->model->getDisponible($f_llegada, $f_salida, $habitacion);

        $data = [
            'title' => 'Reservas',
            'subtitle' => 'Verificar Disponibilidad',
            'disponible' => [
                'f_llegada' => $f_llegada,
                'f_salida' => $f_salida,
                'habitacion' => $habitacion
            ],
            'mensaje' => empty($reserva) ? 'La habitación está disponible' : 'La habitación no está disponible',
            'tipo' => empty($reserva) ? 'success' : 'danger',
            'habitaciones' => $this->model->getHabitaciones(),
            'habitacion' => $this->model->getHabitacion($habitacion)
        ];

        $this->views->getView('principal/reservas', $data);
    }

    // Enviar confirmación de reserva por email
    private function enviarConfirmacionReserva($idReserva, $usuario, $reserva, $habitacion, $factura)
    {
        try {
            require_once RUTA_RAIZ . '/config/email.php';
            require_once RUTA_RAIZ . '/app/helpers/EmailHelper.php';

            $asunto = 'Confirmación de Reserva - StarHotelHub';
            $cuerpo = "
            <html>
            <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
                <div style='max-width: 600px; margin: 0 auto; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;'>
                    <!-- Encabezado -->
                    <div style='background-color: #007bff; color: white; padding: 20px; text-align: center;'>
                        <h2>¡Reserva Confirmada!</h2>
                    </div>

                    <!-- Contenido -->
                    <div style='padding: 20px;'>
                        <p>Hola <strong>{$usuario['nombre']}</strong>,</p>
                        <p>Tu reserva ha sido confirmada exitosamente. Aquí están los detalles:</p>

                        <h3 style='color: #007bff; border-bottom: 2px solid #007bff; padding-bottom: 10px;'>Detalles de la Reserva</h3>
                        <table style='width: 100%; border-collapse: collapse;'>
                            <tr style='background-color: #f5f5f5;'>
                                <td style='padding: 10px; border: 1px solid #ddd;'><strong>Número de Reserva:</strong></td>
                                <td style='padding: 10px; border: 1px solid #ddd;'>FAC-" . str_pad($idReserva, 6, "0", STR_PAD_LEFT) . "</td>
                            </tr>
                            <tr>
                                <td style='padding: 10px; border: 1px solid #ddd;'><strong>Código de Reserva:</strong></td>
                                <td style='padding: 10px; border: 1px solid #ddd;'><code>{$reserva['cod_reserva']}</code></td>
                            </tr>
                            <tr style='background-color: #f5f5f5;'>
                                <td style='padding: 10px; border: 1px solid #ddd;'><strong>Número de Transacción:</strong></td>
                                <td style='padding: 10px; border: 1px solid #ddd;'><code>{$reserva['num_transaccion']}</code></td>
                            </tr>
                            <tr>
                                <td style='padding: 10px; border: 1px solid #ddd;'><strong>Habitación:</strong></td>
                                <td style='padding: 10px; border: 1px solid #ddd;'>{$habitacion['estilo']}</td>
                            </tr>
                            <tr style='background-color: #f5f5f5;'>
                                <td style='padding: 10px; border: 1px solid #ddd;'><strong>Check-in:</strong></td>
                                <td style='padding: 10px; border: 1px solid #ddd;'>" . date("d/m/Y H:i", strtotime($reserva['fecha_ingreso'])) . "</td>
                            </tr>
                            <tr>
                                <td style='padding: 10px; border: 1px solid #ddd;'><strong>Check-out:</strong></td>
                                <td style='padding: 10px; border: 1px solid #ddd;'>" . date("d/m/Y H:i", strtotime($reserva['fecha_salida'])) . "</td>
                            </tr>
                            <tr style='background-color: #f5f5f5;'>
                                <td style='padding: 10px; border: 1px solid #ddd;'><strong>Noches:</strong></td>
                                <td style='padding: 10px; border: 1px solid #ddd;'>{$factura['noches']}</td>
                            </tr>
                            <tr>
                                <td style='padding: 10px; border: 1px solid #ddd;'><strong>Precio por Noche:</strong></td>
                                <td style='padding: 10px; border: 1px solid #ddd;'>\${$factura['precio_noche']}</td>
                            </tr>
                            <tr style='background-color: #f5f5f5;'>
                                <td style='padding: 10px; border: 1px solid #ddd;'><strong>Tipo de Facturación:</strong></td>
                                <td style='padding: 10px; border: 1px solid #ddd;'>{$reserva['facturacion']}</td>
                            </tr>
                        </table>

                        <h3 style='color: #007bff; border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-top: 20px;'>Resumen de Pago</h3>
                        <table style='width: 100%; border-collapse: collapse;'>
                            <tr>
                                <td style='padding: 10px; text-align: right;'><strong>Subtotal (sin IVA):</strong></td>
                                <td style='padding: 10px; text-align: right;'>\$" . number_format($factura['subtotal'], 0, ',', '.') . "</td>
                            </tr>
                            <tr style='background-color: #f5f5f5;'>
                                <td style='padding: 10px; text-align: right;'><strong>IVA (19% incluido):</strong></td>
                                <td style='padding: 10px; text-align: right;'>\$" . number_format($factura['impuestos'], 0, ',', '.') . "</td>
                            </tr>
                            <tr style='background-color: #28a745; color: white;'>
                                <td style='padding: 10px; text-align: right;'><strong>TOTAL A PAGAR:</strong></td>
                                <td style='padding: 10px; text-align: right;'><strong>\$" . number_format($factura['total'], 0, ',', '.') . "</strong></td>
                            </tr>
                        </table>

                        <div style='background-color: #e7f3ff; border-left: 4px solid #007bff; padding: 15px; margin-top: 20px; border-radius: 4px;'>
                            <p style='margin: 0; color: #004085;'>
                                <strong>ℹ️ Importante:</strong> El precio mostrado incluye el IVA del 19%. Este es el monto total que pagarás en el hotel al momento del check-in.
                            </p>
                        </div>

                        <p style='margin-top: 20px;'>
                            Si tienes alguna pregunta, no dudes en contactarnos a <strong>starhotelhub@gmail.com</strong>
                        </p>
                    </div>

                    <!-- Pie de página -->
                    <div style='background-color: #f5f5f5; padding: 15px; text-align: center; font-size: 12px; color: #666;'>
                        <p>© 2025 StarHotelHub. Todos los derechos reservados.</p>
                    </div>
                </div>
            </body>
            </html>";

            $email = new EmailHelper();
            $email->setTo($usuario['correo'], $usuario['nombre'])
                  ->setSubject($asunto)
                  ->setBody($cuerpo)
                  ->send();

            error_log(" Email de confirmación enviado a: " . $usuario['correo']);
        } catch (Exception $e) {
            error_log(" Error al enviar email de confirmación: " . $e->getMessage());
        }
    }

    public function verificar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $f_llegada = strClean($_POST['f_llegada'] ?? '');
            $f_salida = strClean($_POST['f_salida'] ?? '');
            $habitacion_id = strClean($_POST['habitacion'] ?? '');

            header('Content-Type: application/json');

            if (empty($f_llegada) || empty($f_salida) || empty($habitacion_id)) {
                echo json_encode(['disponible' => false, 'error' => 'Campos requeridos']);
                exit;
            }

            // Validar que las fechas sean válidas
            try {
                $llegada = new DateTime($f_llegada);
                $salida = new DateTime($f_salida);
            } catch (Exception $e) {
                echo json_encode(['disponible' => false, 'error' => 'Fechas inválidas']);
                exit;
            }

            // Validar que salida sea posterior a llegada
            if ($salida <= $llegada) {
                echo json_encode(['disponible' => false, 'error' => 'La fecha de salida debe ser posterior a la llegada']);
                exit;
            }

            // Validar que no sea fecha pasada
            $hoy = new DateTime();
            $hoy->setTime(0, 0, 0);
            if ($llegada < $hoy) {
                echo json_encode(['disponible' => false, 'error' => 'No se pueden hacer reservas en fechas pasadas']);
                exit;
            }

            $reserva = $this->model->getDisponible($f_llegada, $f_salida, $habitacion_id);

            echo json_encode(['disponible' => empty($reserva)]);
            exit;
        }
    }

    // Devuelve reservas de la habitación en formato JSON para FullCalendar
    public function listar($parametros = '')
    {
        header('Content-Type: application/json');
        
        if (empty($parametros)) {
            echo json_encode([]);
            exit;
        }

        $array = explode(',', $parametros);
        $id_habitacion = (!empty($array[2])) ? intval($array[2]) : null;

        if (!$id_habitacion) {
            echo json_encode([]);
            exit;
        }

        try {
            $reservas = $this->model->getReservasHabitacion($id_habitacion);
            $eventos = [];
            foreach ($reservas as $reserva) {
                $eventos[] = [
                    'title' => 'Ocupado',
                    'start' => $reserva['fecha_ingreso'],
                    'end' => $reserva['fecha_salida'],
                    'color' => '#dc3545' // Rojo para indicar no disponible
                ];
            }
            echo json_encode($eventos);

        } catch (Exception $e) {
            // Log del error para depuración
            error_log('Error en listar: ' . $e->getMessage());
            echo json_encode([]); // Devolver un array vacío en caso de error
        }

        exit;
    }


    // Guarda reserva desde la página pública
    public function guardarPublica()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');

            $nombre = strClean($_POST['nombre'] ?? '');
            $correo = strClean($_POST['correo'] ?? '');
            $f_llegada = strClean($_POST['f_llegada'] ?? '');
            $f_salida = strClean($_POST['f_salida'] ?? '');
            $habitacion_id = strClean($_POST['habitacion'] ?? '');
            $descripcion = strClean($_POST['descripcion'] ?? '');

            if (empty($nombre) || empty($correo) || empty($f_llegada) || empty($f_salida) || empty($habitacion_id)) {
                echo json_encode(['status' => 'error', 'msg' => 'Todos los campos son obligatorios.']);
                exit;
            }

            // Validar fechas
            if (new DateTime($f_llegada) >= new DateTime($f_salida)) {
                echo json_encode(['status' => 'error', 'msg' => 'La fecha de salida debe ser posterior a la de llegada.']);
                exit;
            }

            // Verificar disponibilidad
            $disponible = $this->model->getDisponible($f_llegada, $f_salida, $habitacion_id);
            if (!empty($disponible)) {
                echo json_encode(['status' => 'error', 'msg' => 'La habitación no está disponible en las fechas seleccionadas.']);
                exit;
            }

            // Gestionar usuario
            $usuario = $this->model->getUsuarioByCorreo($correo);
            if ($usuario) {
                $id_usuario = $usuario['id'];
            } else {
                // Generar contraseña temporal aleatoria
                $clave = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10);
                $id_usuario = $this->model->crearUsuario($nombre, $correo, $clave);
                if (!$id_usuario) {
                    echo json_encode(['status' => 'error', 'msg' => 'Error al crear el usuario.']);
                    exit;
                }
            }

            // Calcular monto
            $habitacion = $this->model->getHabitacion($habitacion_id);
            $noches = (new DateTime($f_llegada))->diff(new DateTime($f_salida))->days;
            $monto = $noches * $habitacion['precio'];

            // Generar códigos únicos
            $num_transaccion = 'TX' . date('YmdHis') . rand(1000, 9999);
            $cod_reserva = 'RES' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);

            // Insertar reserva CON TODOS LOS CAMPOS
            $dataReserva = [
                'id_habitacion' => $habitacion_id,
                'id_usuario' => $id_usuario,
                'fecha_ingreso' => $f_llegada,
                'fecha_salida' => $f_salida,
                'descripcion' => $descripcion,
                'metodo' => 1, // 1: Online
                'estado' => 1, // 1: Pendiente
                'monto' => $monto,
                'num_transaccion' => $num_transaccion,
                'cod_reserva' => $cod_reserva,
                'facturacion' => 'Factura Plataforma', // Tipo de facturación
                'id_empleado' => null, // Sin empleado asignado aún
            ];

            $id_reserva = $this->model->insertReservaPublica($dataReserva);

            if ($id_reserva) {
                $_SESSION['ultima_reserva'] = $id_reserva;
                error_log("Reserva creada con ID: " . $id_reserva);

                // Obtener datos completos para el email
                $reservaCompleta = $this->model->getReservaById($id_reserva);
                $usuarioCompleto = $this->model->getUsuarioById($id_usuario);
                $habitacionCompleta = $this->model->getHabitacion($habitacion_id);

                // Calcular factura (IVA INCLUIDO EN EL PRECIO)
                $fechaLlegada = new DateTime($f_llegada);
                $fechaSalida = new DateTime($f_salida);
                $intervalo = $fechaLlegada->diff($fechaSalida);
                $noches = $intervalo->days > 0 ? $intervalo->days : 1;
                $precioNoche = $habitacionCompleta['precio']; // Ya incluye IVA
                $total = $noches * $precioNoche; // Total con IVA incluido
                $subtotal = $total / 1.19; // Desglose: precio sin IVA
                $impuestos = $total - $subtotal; // IVA desglosado

                $factura = [
                    'numero' => 'FAC-' . str_pad($id_reserva, 6, "0", STR_PAD_LEFT),
                    'noches' => $noches,
                    'precio_noche' => $precioNoche,
                    'subtotal' => $subtotal,
                    'impuestos' => $impuestos,
                    'total' => $total
                ];

                // Enviar email de confirmación (no bloquear si falla)
                try {
                    $this->enviarConfirmacionReserva($id_reserva, $usuarioCompleto, $reservaCompleta, $habitacionCompleta, $factura);
                    error_log("Email de confirmacion enviado");
                } catch (Exception $e) {
                    error_log("ADVERTENCIA Error al enviar email de confirmacion: " . $e->getMessage());
                }

                // Si es usuario nuevo, enviar credenciales (no bloquear si falla)
                if (!$usuario) {
                    try {
                        $this->enviarCredencialesNuevoUsuario($usuarioCompleto, $clave);
                        error_log("Email de credenciales enviado");
                    } catch (Exception $e) {
                        error_log("ADVERTENCIA Error al enviar email de credenciales: " . $e->getMessage());
                    }
                }

                $redirectUrl = RUTA_PRINCIPAL . 'reserva/confirmacion';
                error_log("Redirigiendo a: " . $redirectUrl);

                echo json_encode([
                    'status' => 'success',
                    'msg' => 'Reserva realizada con éxito',
                    'redirect' => $redirectUrl,
                    'id_reserva' => $id_reserva
                ]);
            } else {
                error_log("ERROR Error al insertar reserva en la base de datos");
                echo json_encode(['status' => 'error', 'msg' => 'Error al guardar la reserva.']);
            }
            exit;
        }
    }

    // Enviar credenciales a usuario nuevo
    private function enviarCredencialesNuevoUsuario($usuario, $clave)
    {
        try {
            require_once RUTA_RAIZ . '/config/email.php';
            require_once RUTA_RAIZ . '/app/helpers/EmailHelper.php';

            $asunto = 'Bienvenido a StarHotelHub - Tus Credenciales de Acceso';
            $cuerpo = "
            <html>
            <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
                <div style='max-width: 600px; margin: 0 auto; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;'>
                    <!-- Encabezado -->
                    <div style='background-color: #28a745; color: white; padding: 20px; text-align: center;'>
                        <h2>¡Bienvenido a StarHotelHub!</h2>
                    </div>

                    <!-- Contenido -->
                    <div style='padding: 20px;'>
                        <p>Hola <strong>{$usuario['nombre']}</strong>,</p>
                        <p>Tu cuenta ha sido creada exitosamente. Aquí están tus credenciales de acceso:</p>

                        <div style='background-color: #f5f5f5; padding: 15px; border-radius: 5px; margin: 20px 0;'>
                            <p><strong>Email:</strong> {$usuario['correo']}</p>
                            <p><strong>Contraseña Temporal:</strong> <code style='background-color: #e9ecef; padding: 5px 10px; border-radius: 3px;'>{$clave}</code></p>
                        </div>

                        <p style='color: #d9534f;'>
                            <strong>⚠️ Importante:</strong> Te recomendamos cambiar tu contraseña temporal por una más segura después de tu primer acceso.
                        </p>

                        <p style='margin-top: 20px;'>
                            <a href='" . RUTA_PRINCIPAL . "login' style='display: inline-block; background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Acceder a tu Cuenta</a>
                        </p>

                        <p style='margin-top: 20px;'>
                            Si tienes alguna pregunta, no dudes en contactarnos a <strong>starhotelhub@gmail.com</strong>
                        </p>
                    </div>

                    <!-- Pie de página -->
                    <div style='background-color: #f5f5f5; padding: 15px; text-align: center; font-size: 12px; color: #666;'>
                        <p>© 2025 StarHotelHub. Todos los derechos reservados.</p>
                    </div>
                </div>
            </body>
            </html>";

            $email = new EmailHelper();
            $email->setTo($usuario['correo'], $usuario['nombre'])
                  ->setSubject($asunto)
                  ->setBody($cuerpo)
                  ->send();

            error_log(" Email de credenciales enviado a: " . $usuario['correo']);
        } catch (Exception $e) {
            error_log("❌ Error al enviar email de credenciales: " . $e->getMessage());
        }
    }

    // Genera la página de confirmación/factura
    public function confirmacion()
    {
        $idReserva = $_SESSION['ultima_reserva'] ?? null;
        if (!$idReserva) {
            header("Location: " . RUTA_PRINCIPAL);
            exit;
        }

        $reserva = $this->model->getReservaById($idReserva);
        if (!$reserva) {
            header("Location: " . RUTA_PRINCIPAL . "?msg=reserva_no_encontrada");
            exit;
        }

        $usuario = $this->model->getUsuarioById($reserva['id_usuario']);
        $habitacion = $this->model->getHabitacion($reserva['id_habitacion']);

        // --- INICIO DE LA LÓGICA DE FACTURA ---

        // 1. Calcular número de noches
        $fechaLlegada = new DateTime($reserva['fecha_ingreso']);
        $fechaSalida = new DateTime($reserva['fecha_salida']);
        $intervalo = $fechaLlegada->diff($fechaSalida);
        $noches = $intervalo->days > 0 ? $intervalo->days : 1;

        // 2. Calcular desglose de costos (IVA INCLUIDO EN EL PRECIO)
        $precioNoche = $habitacion['precio']; // Ya incluye IVA
        $total = $noches * $precioNoche; // Total con IVA incluido
        $subtotal = $total / 1.19; // Desglose: precio sin IVA
        $impuestos = $total - $subtotal; // IVA desglosado

        // 3. Preparar datos para la vista
        $data = [
            'title' => 'Confirmación y Factura',
            'subtitle' => 'Resumen de tu Reserva',
            'reserva' => $reserva,
            'usuario' => $usuario,
            'habitacion' => $habitacion,
            'factura' => [
                'numero' => 'FAC-' . str_pad($idReserva, 6, "0", STR_PAD_LEFT),
                'noches' => $noches,
                'precio_noche' => $precioNoche,
                'subtotal' => $subtotal,
                'impuestos' => $impuestos,
                'total' => $total
            ]
        ];

        $this->views->getView('principal/reservas/confirmacion', $data);
    }

    // Vista de reservas pendientes
    public function pendiente()
    {
        $data['title'] = 'Reserva Pendiente';
        $this->views->getView('principal/clientes/reservas/pendiente', $data);
    }

    // Mostrar factura de una reserva específica (por ID)
    public function factura($idReserva = null)
    {
        if (!$idReserva) {
            echo json_encode(['error' => 'ID de reserva no proporcionado']);
            exit;
        }

        $idReserva = intval($idReserva);
        $reserva = $this->model->getReservaById($idReserva);

        if (!$reserva) {
            echo json_encode(['error' => 'Reserva no encontrada']);
            exit;
        }

        // Verificar permisos: solo admin, empleado o el cliente propietario
        if (isset($_SESSION['usuario'])) {
            $rol = $_SESSION['usuario']['rol'];
            $usuarioId = $_SESSION['usuario']['id'];

            // Permitir si es admin (1), empleado (2), o cliente propietario (3)
            if ($rol != 1 && $rol != 2 && ($rol == 3 && $reserva['id_usuario'] != $usuarioId)) {
                echo json_encode(['error' => 'No tienes permiso para ver esta factura']);
                exit;
            }
        }

        $usuario = $this->model->getUsuarioById($reserva['id_usuario']);
        $habitacion = $this->model->getHabitacion($reserva['id_habitacion']);

        // Calcular número de noches
        $fechaLlegada = new DateTime($reserva['fecha_ingreso']);
        $fechaSalida = new DateTime($reserva['fecha_salida']);
        $intervalo = $fechaLlegada->diff($fechaSalida);
        $noches = $intervalo->days > 0 ? $intervalo->days : 1;

        // Calcular desglose de costos (IVA INCLUIDO EN EL PRECIO)
        $precioNoche = $habitacion['precio'];
        $total = $noches * $precioNoche;
        $subtotal = $total / 1.19;
        $impuestos = $total - $subtotal;

        // Preparar datos para la vista
        $data = [
            'title' => 'Factura de Reserva',
            'subtitle' => 'Detalles de la Factura',
            'reserva' => $reserva,
            'usuario' => $usuario,
            'habitacion' => $habitacion,
            'factura' => [
                'numero' => 'FAC-' . str_pad($idReserva, 6, "0", STR_PAD_LEFT),
                'noches' => $noches,
                'precio_noche' => $precioNoche,
                'subtotal' => $subtotal,
                'impuestos' => $impuestos,
                'total' => $total
            ]
        ];

        $this->views->getView('principal/reservas/factura', $data);
    }
}