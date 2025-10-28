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
                $clave = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10);
                $id_usuario = $this->model->crearUsuario($nombre, $correo, $clave, 'N/A', 3);
                if (!$id_usuario) {
                    echo json_encode(['status' => 'error', 'msg' => 'Error al crear el usuario.']);
                    exit;
                }
            }

            // Calcular monto
            $habitacion = $this->model->getHabitacion($habitacion_id);
            $noches = (new DateTime($f_llegada))->diff(new DateTime($f_salida))->days;
            $monto = $noches * $habitacion['precio'];

            // Insertar reserva
            $dataReserva = [
                'id_habitacion' => $habitacion_id,
                'id_usuario' => $id_usuario,
                'fecha_ingreso' => $f_llegada,
                'fecha_salida' => $f_salida,
                'descripcion' => $descripcion,
                'metodo' => '1', // 1: Online
                'estado' => 1, // 1: Pendiente
                'monto' => $monto,
            ];

            $id_reserva = $this->model->insertReservaPublica($dataReserva);

            if ($id_reserva) {
                $_SESSION['ultima_reserva'] = $id_reserva;
                echo json_encode(['status' => 'success', 'msg' => 'Reserva realizada con éxito', 'redirect' => RUTA_PRINCIPAL . 'reserva/confirmacion']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Error al guardar la reserva.']);
            }
            exit;
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

        // 2. Calcular desglose de costos
        $precioNoche = $habitacion['precio'];
        $subtotal = $noches * $precioNoche;
        $impuestos = $subtotal * 0.19; // IVA 19%
        $total = $subtotal + $impuestos;

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
}