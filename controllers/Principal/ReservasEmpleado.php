<?php
require_once 'helpers/seguridad.php';
require 'models/admin/HabitacionesModel.php';
require_once 'models/principal/ReservasModelEmpleado.php';

class ReservasEmpleado extends Controller
{
    private $HabitacionModel;
    private $ReservaModel;

    public function __construct()
    {
        parent::__construct();
        verificarSesion(2); // Solo empleados
        $this->HabitacionModel = new HabitacionesModel();
        $this->ReservaModel = new ReservasModelEmpleado();
    }

    public function index()
    {
        $habitaciones = $this->HabitacionModel->getHabitaciones(false);

        $data['title'] = 'Reservas (Empleado)';
        $data['habitaciones'] = $habitaciones;
        $this->views->getView('empleado/reservas/index', $data);
    }

    // Listar reservas (JSON para DataTables)
    private function listar()
    {
        ini_set('display_errors', 0);
        error_reporting(0);

        $reservas = $this->model->getReservas();
        $eventos = [];

        foreach ($reservas as $reserva) {
            $eventos[] = [
                'id' => $reserva['id'],
                'title' => 'Hab. ' . $reserva['habitacion'] . ' - ' . $reserva['cliente'],
                'start' => $reserva['fecha_ingreso'],
                'end' => $reserva['fecha_salida'],
                'extendedProps' => [
                    'id_habitacion' => $reserva['id_habitacion'],
                    'id_usuario' => $reserva['id_cliente'],
                    'monto' => $reserva['monto'],
                    'estado' => $reserva['estado_reserva']
                ]
            ];
        }

        echo json_encode($eventos, JSON_UNESCAPED_UNICODE);
        die();
    }


    // Guardar o actualizar reserva
    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datos = [
                'idReserva' => $_POST['idReserva'] ?? '',
                'habitacion' => $_POST['habitacion'],
                'cliente' => $_POST['cliente'],
                'fecha_ingreso' => $_POST['fecha_ingreso'],
                'fecha_salida' => $_POST['fecha_salida'],
                'monto' => $_POST['monto'],
                'descripcion' => $_POST['descripcion'] ?? null
            ];

            if (!empty($datos['idReserva'])) {
                $res = $this->ReservaModel->actualizarReserva($datos);
            } else {
                $res = $this->ReservaModel->registrarReserva($datos);
            }

            if ($res) {
                echo json_encode(['msg' => 'ok']);
            } else {
                echo json_encode(['msg' => 'Error al guardar la reserva.']);
            }
        }
        die();
    }

    // Obtener una reserva por ID
    public function obtener($id)
    {
        $id = intval($id);
        $reserva = $this->ReservaModel->getReserva($id);
        echo json_encode($reserva, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Cancelar reserva (no eliminar)
    public function cancelar($id)
    {
        $id = intval($id);
        $res = $this->ReservaModel->cancelarReserva($id);

        if ($res) {
            echo json_encode(['msg' => 'ok']);
        } else {
            echo json_encode(['msg' => 'No se pudo cancelar la reserva.']);
        }
        die();
    }
}
