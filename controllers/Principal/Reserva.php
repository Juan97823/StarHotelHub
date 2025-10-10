<?php
class Reserva extends Controller
{
    public function __construct()
    {
        parent::__construct();
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

    // Devuelve reservas de la habitación en formato JSON para FullCalendar
    public function listar($parametros = '')
    {
        $array = explode(',', $parametros);
        $f_llegada = $array[0] ?? null;
        $f_salida = $array[1] ?? null;
        $habitacion = $array[2] ?? null;

        $results = [];

        if ($habitacion) {
            $reservas = $this->model->getReservasHabitacion($habitacion) ?? [];

            foreach ($reservas as $reserva) {
                $results[] = [
                    'id' => $reserva['id'],
                    'title' => 'OCUPADO',
                    'start' => $reserva['fecha_ingreso'],
                    'end' => $reserva['fecha_salida'],
                    'color' => '#ff0000'
                ];
            }

            if ($f_llegada && $f_salida) {
                $results[] = [
                    'id' => 'seleccion',
                    'title' => 'SELECCIÓN',
                    'start' => $f_llegada,
                    'end' => $f_salida,
                    'color' => '#00ff00'
                ];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($results, JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Guarda reserva desde la página pública
    public function guardarPublica()
    {
        // 1. Recibir y limpiar datos del formulario
        $nombre = $_POST['nombre'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $habitacion_id = $_POST['habitacion'] ?? '';
        $f_llegada = $_POST['f_llegada'] ?? '';
        $f_salida = $_POST['f_salida'] ?? '';
        $adultos = $_POST['adultos'] ?? 1;
        $ninos = $_POST['ninos'] ?? 0;
        $metodo = $_POST['metodo_pago'] ?? 'pendiente';
        $descripcion = $_POST['descripcion'] ?? 'Reserva pública';

        // 2. Validación mínima
        if (empty($nombre) || empty($correo) || empty($habitacion_id) || empty($f_llegada) || empty($f_salida)) {
            echo json_encode(['status' => 'error', 'msg' => 'Faltan datos obligatorios']);
            exit;
        }

        // 3. Verificar usuario existente o crear uno nuevo
        $usuario = $this->model->getUsuarioBycorreo($correo);
        $idUsuario = $usuario['id'] ?? $this->model->crearUsuario($nombre, $correo, password_hash("123456", PASSWORD_DEFAULT));

        if (!$idUsuario) {
            echo json_encode(['status' => 'error', 'msg' => 'No se pudo crear el usuario']);
            exit;
        }

        // 4. Insertar reserva
        $dataReserva = [
            ':id_habitacion' => $habitacion_id,
            ':id_usuario' => $idUsuario,
            ':fecha_ingreso' => $f_llegada,
            ':fecha_salida' => $f_salida,
            ':descripcion' => $descripcion,
            ':estado' => 1,
            ':metodo' => $metodo
        ];


        $idReserva = $this->model->insertReservaPublica($dataReserva);

        if (!$idReserva) {
            echo json_encode(['status' => 'error', 'msg' => 'No se pudo crear la reserva']);
            exit;
        }

        // 5. Calcular monto según habitación y noches
        $habitacion = $this->model->getHabitacion($habitacion_id);
        if (!$habitacion) {$idReserva = $this->model->insertReservaPublica($dataReserva);
            echo json_encode(['status' => 'error', 'msg' => 'Habitación no encontrada']);
            exit;
        }

        $noches = max(1, (new DateTime($f_llegada))->diff(new DateTime($f_salida))->days);
        $monto = $habitacion['precio'] * $noches;

        // 6. Generar códigos de pago
        $codigoReserva = "RES-" . str_pad($idReserva, 6, "0", STR_PAD_LEFT);
        $numTransaccion = "TRX-" . date("YmdHis") . "-" . rand(100, 999);

        // 7. Registrar pago (según estructura actual de la tabla pagos)
        $dataPago = [
            'id_reserva' => $idReserva,
            'id_usuario' => $idUsuario,
            'id_habitacion' => $habitacion_id,
            'monto' => $monto,
            'num_transaccion' => $numTransaccion,
            'cod_reserva' => $codigoReserva,
            'fecha_ingreso' => $f_llegada,
            'fecha_salida' => $f_salida,
            'descripcion' => $descripcion,
            'metodo' => $metodo,
            'facturacion' => $nombre,
            'id_empleado' => null,
            'estado' => 1
        ];

        $pagoRegistrado = $this->model->registrarPago($dataPago);

        if (!$pagoRegistrado) {
            echo json_encode(['status' => 'error', 'msg' => 'No se pudo registrar el pago']);
            exit;
        }

        // 8. Guardar ID de última reserva en sesión
        $_SESSION['ultima_reserva'] = $idReserva;

        // 9. Respuesta exitosa
        echo json_encode([
            'status' => 'success',
            'msg' => 'Reserva y pago registrados correctamente',
            'id_reserva' => $idReserva,
            'codigo_reserva' => $codigoReserva,
            'monto' => $monto,
            'noches' => $noches
        ]);
        exit;
    }

    // Confirmación de reserva
    public function confirmacion()
    {
        $idReserva = $_SESSION['ultima_reserva'] ?? null;
        if (!$idReserva) {
            header("Location: " . RUTA_PRINCIPAL);
            exit;
        }

        $reserva = $this->model->getReservaById($idReserva);
        $usuario = $this->model->getUsuarioById($reserva['usuario_id']);
        $habitacion = $this->model->getHabitacion($reserva['habitacion_id']);

        $codigoReserva = "RES-" . str_pad($idReserva, 6, "0", STR_PAD_LEFT);

        $data = [
            'reserva' => $reserva,
            'usuario' => $usuario,
            'habitacion' => $habitacion,
            'codigo_reserva' => $codigoReserva
        ];

        $this->views->getView('principal/reservas/confirmacion', $data);
    }

    // Vista de reservas pendientes
    public function pendiente()
    {
        $data['title'] = 'Reserva Pendiente';
        $this->views->getView('principal/clientes/reservas/pendiente', $data);
        $this->views->getView('admin/reservas/pendiente', $data);
    }
}
