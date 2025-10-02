<?php
class Reserva extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // Mostrar errores para depuración (puedes quitar en producción)
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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . RUTA_PRINCIPAL);
            exit;
        }

        $nombre = trim($_POST['nombre'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $f_llegada = trim($_POST['f_llegada'] ?? '');
        $f_salida = trim($_POST['f_salida'] ?? '');
        $habitacion_id = intval($_POST['habitacion'] ?? 0);
        $metodo = intval($_POST['metodo'] ?? 0);
        $descripcion = trim($_POST['descripcion'] ?? '');

        if (!$nombre || !$correo || !$f_llegada || !$f_salida || !$habitacion_id) {
            $res = ['tipo' => 'danger', 'mensaje' => 'Todos los campos son requeridos'];
            $this->views->getView($this, "publica", $res);
            return;
        }

        if (new DateTime($f_salida) <= new DateTime($f_llegada)) {
            $res = ['tipo' => 'danger', 'mensaje' => 'La fecha de salida debe ser posterior a la llegada.'];
            $this->views->getView($this, "publica", $res);
            return;
        }

        // Verificar usuario existente o crear
        $usuario = $this->model->getUsuarioBycorreo($correo);
        $idUsuario = $usuario['id'] ?? $this->model->crearUsuario($nombre, $correo, password_hash("123456", PASSWORD_DEFAULT));

        // Insertar reserva
        $dataReserva = [
            'habitacion_id' => $habitacion_id,
            'usuario_id' => $idUsuario,
            'fecha_ingreso' => $f_llegada,
            'fecha_salida' => $f_salida,
            'descripcion' => $descripcion ?: 'Reserva pública',
            'estado' => 1
        ];

        $idReserva = $this->model->insertReservaPublica($dataReserva);

        if (!$idReserva) {
            $res = ['tipo' => 'danger', 'mensaje' => 'Error al registrar la reserva.'];
            $this->views->getView($this, "publica", $res);
            return;
        }

        // Calcular monto
        $habitacion = $this->model->getHabitacion($habitacion_id);
        $noches = max(1, (new DateTime($f_llegada))->diff(new DateTime($f_salida))->days);
        $monto = $habitacion['precio'] * $noches;

        // Generar códigos
        $codigoReserva = "RES-" . str_pad($idReserva, 6, "0", STR_PAD_LEFT);
        $numTransaccion = "TRX-" . date("YmdHis") . "-" . rand(100, 999);

        // Registrar pago
        $dataPago = [
            'monto' => $monto,
            'num_transaccion' => $numTransaccion,
            'cod_reserva' => $codigoReserva,
            'fecha_ingreso' => $f_llegada,
            'fecha_salida' => $f_salida,
            'descripcion' => $descripcion ?: 'Pago reserva',
            'estado' => 1,
            'metodo' => $metodo,
            'facturacion' => "Pago sin factura",
            'id_habitacion' => $habitacion_id,
            'id_usuario' => $idUsuario,
            'id_empleado' => null
        ];
        $this->model->registrarPago($dataPago);

        $_SESSION['ultima_reserva'] = $idReserva;

        $res = ['tipo' => 'success', 'mensaje' => 'Reserva y pago registrados correctamente. Revisa tu correo electrónico.'];
        $this->views->getView($this, "publica", $res);
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
        $usuario = $this->model->getUsuarioById($reserva['id_usuario']);
        $habitacion = $this->model->getHabitacion($reserva['id_habitacion']);

        $codigoReserva = "RES-" . str_pad($idReserva, 6, "0", STR_PAD_LEFT);

        $data = [
            'reserva' => $reserva,
            'usuario' => $usuario,
            'habitacion' => $habitacion,
            'codigo_reserva' => $codigoReserva
        ];

        $this->views->getView('principal/reservas/confirmacion', $data);
    }

    public function pendiente()
    {
        $data['title'] = 'Reserva Pendiente';
        $this->views->getView('principal/clientes/reservas/pendiente', $data);
        $this->views->getView('admin/reservas/pendiente', $data);
    }
}
