<?php
require_once 'helpers/seguridad.php';
require 'models/admin/HabitacionesModel.php';

class Reservas extends Controller
{
    private $HabitacionModel;
    public function __construct()
    {
        parent::__construct();
        verificarSesion(1); // Solo administradores
        $this->HabitacionModel = new HabitacionesModel();
    }

    public function index()
    {   $habitaciones = $this->HabitacionModel->getHabitaciones(false);

        $data['title'] = 'Reservas';
        $data['habitaciones'] = $habitaciones;
        $this->views->getView('admin/Reservas/index', $data);
    }

    // Listar todas las reservas (JSON para DataTables)
    public function listar()
    {
        $reservas = $this->model->getReservas(false);

        foreach ($reservas as $key => $res) {
            // Formatear estado
            $reservas[$key]['estado'] = $res['estado'] == 1
                ? '<span class="badge bg-success">Completado</span>'
                : '<span class="badge bg-warning">Pendiente</span>';

            // Acciones
            $id = $res['id'];
            $reservas[$key]['acciones'] = '
                <div>
                    <button class="btn btn-primary btn-sm" onclick="btnEditarReserva('.$id.')" title="Editar"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm" onclick="btnEliminarReserva('.$id.')" title="Eliminar"><i class="fas fa-trash"></i></button>
                </div>';
        }

        echo json_encode($reservas, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Guardar o actualizar reserva
    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datos = [
                'idReserva'     => $_POST['idReserva'] ?? '',
                'habitacion'    => $_POST['habitacion'],
                'cliente'       => $_POST['cliente'],
                'fecha_ingreso' => $_POST['fecha_ingreso'],
                'fecha_salida'  => $_POST['fecha_salida'],
                'monto'         => $_POST['monto']
            ];

            $res = $this->model->guardarReserva($datos);

            if ($res) {
                echo json_encode(['msg' => 'ok']);
            } else {
                echo json_encode(['msg' => 'Error al guardar la reserva.']);
            }
        }
        die();
    }

    // Obtener datos de una reserva
    public function obtener($id)
    {
        $id = intval($id);
        $reserva = $this->model->getReserva($id);
        echo json_encode($reserva, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Eliminar reserva permanentemente
    public function eliminar($id)
    {
        $id = intval($id);
        $res = $this->model->eliminarReserva($id);

        if ($res) {
            echo json_encode(['msg' => 'ok']);
        } else {
            echo json_encode(['msg' => 'No se pudo eliminar la reserva.']);
        }
        die();
    }
}
