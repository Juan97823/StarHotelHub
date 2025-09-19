<?php
class Reserva extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function verify()
    {
        if (isset($_GET['f_llegada']) && isset($_GET['f_salida']) && isset($_GET['habitacion'])) {
            $f_llegada = strClean($_GET['f_llegada']);
            $f_salida = strClean($_GET['f_salida']);
            $habitacion = strClean($_GET['habitacion']);
            if (empty($f_llegada) || empty($f_salida) || empty($habitacion)) {
                header('Location:' . RUTA_PRINCIPAL . '?respuesta=warning');
            } else {
                $reserva = $this->model->getDisponible($f_llegada, $f_salida, $habitacion);
                $data['title'] = 'Reservas';
                $data['subtitle'] = 'Verificar Disponibilidad';
                $data['disponible'] = [
                    'f_llegada' => $f_llegada,
                    'f_salida' => $f_salida,
                    'habitacion' => $habitacion
                ];
                if (empty($reserva)) {
                    $data['mensaje'] = 'La habitacion esta disponible';
                    $data['tipo'] = 'success';
                } else {
                    $data['mensaje'] = 'La habitacion no esta disponible';
                    $data['tipo'] = 'danger';
                }
                $data['habitaciones'] = $this->model->getHabitaciones();
                $data['habitacion'] = $this->model->getHabitacion($habitacion);
                $this->views->getView('principal/reservas', $data);
            }
        }
    }
    public function listar($parametros)
    {
        $array = explode(',', $parametros);
        $f_llegada = (!empty($array[0])) ? $array[0] : null;
        $f_salida = (!empty($array[1])) ? $array[1] : null;
        $habitacion = (!empty($array[2])) ? $array[2] : null;
        $results = [];

        if ($f_llegada != null && $f_salida != null && $habitacion != null) {
            // OBTENER RESERVAS DE LA HABITACIÓN
            $reservas = $this->model->getReservasHabitacion($habitacion);

            foreach ($reservas as $reserva) {
                $results[] = [
                    'id' => $reserva['id'],
                    'title' => 'OCUPADO',
                    'start' => $reserva['fecha_ingreso'],
                    'end' => $reserva['fecha_salida'],
                    'color' => '#ff0000'
                ];
            }

            // RANGO DE FECHAS SELECCIONADO
            $results[] = [
                'id' => 'seleccion',
                'title' => 'COMPROBANDO',
                'start' => $f_llegada,
                'end' => $f_salida,
                'color' => '#00ff00'
            ];

            header('Content-Type: application/json');
            echo json_encode($results, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function guardarPublica()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre']);
            $correo = trim($_POST['correo']);
            $f_llegada = trim($_POST['f_llegada']);
            $f_salida = trim($_POST['f_salida']);
            $habitacion_id = intval($_POST['habitacion']);

            // Validar campos requeridos
            if (empty($nombre) || empty($correo) || empty($f_llegada) || empty($f_salida) || empty($habitacion_id)) {
                $res = ['tipo' => 'danger', 'mensaje' => 'Todos los campos son requeridos'];
                $this->views->getView($this, "publica", $res);
                return;
            }

            // Verificar si el usuario ya existe
            $usuario = $this->model->getUsuarioBycorreo($correo);
            if (!$usuario) {
                $clave = password_hash("123456", PASSWORD_DEFAULT); // clave por defecto
                $idUsuario = $this->model->crearUsuario($nombre, $correo, $clave);
            } else {
                $idUsuario = $usuario['id'];
            }

            // Insertar reserva
            $data = [
                'habitacion_id' => $habitacion_id,
                'usuario_id' => $idUsuario,
                'fecha_ingreso' => $f_llegada,
                'fecha_salida' => $f_salida,
                'estado' => 1 // Activa por defecto
            ];

            $idReserva = $this->model->insertReservaPublica($data);

            if ($idReserva) {
                // Crear factura
                $this->model->crearFactura($idReserva);

                $res = [
                    'tipo' => 'success',
                    'mensaje' => 'Reserva creada correctamente. Revisa tu correo electrónico.'
                ];
            } else {
                $res = [
                    'tipo' => 'danger',
                    'mensaje' => 'Error al registrar la reserva.'
                ];
            }

            $this->views->getView($this, "publica", $res);
        } else {
            header('Location: ' . RUTA_PRINCIPAL);
            exit;
        }


    }
    public function confirmacion()
    {
        // Suponemos que guardaste el ID de la última reserva en sesión
        $idReserva = $_SESSION['ultima_reserva'] ?? null;
        if (!$idReserva) {
            header("Location: " . RUTA_PRINCIPAL);
            exit;
        }

        // Datos de la reserva
        $reserva = $this->model->getReservaById($idReserva);
        $usuario = $this->model->getUsuarioById($reserva['id_usuario']);
        $habitacion = $this->model->getHabitacion($reserva['id_habitacion']);
        $factura = $this->model->getFacturaByReserva($idReserva);

        $data = [
            'reserva' => $reserva,
            'usuario' => $usuario,
            'habitacion' => $habitacion,
            'factura' => $factura
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
