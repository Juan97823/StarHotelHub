<?php
require_once 'helpers/seguridad.php';
require 'models/admin/HabitacionesModel.php';
require 'models/admin/UsuariosModel.php'; // CORREGIDO: Se usa el modelo de Usuarios

class Reservas extends Controller
{
    private $HabitacionModel;
    private $UsuariosModel; // CORREGIDO: Propiedad para el modelo de Usuarios

    public function __construct()
    {
        parent::__construct();
        verificarSesion(1); // Solo administradores
        $this->HabitacionModel = new HabitacionesModel();
        $this->UsuariosModel = new UsuariosModel(); // CORREGIDO: Se instancia el modelo correcto
    }

    public function index()
    {
        $habitaciones = $this->HabitacionModel->getHabitaciones(false);
        $usuarios = $this->UsuariosModel->getUsuarios(); // CORREGIDO: Se obtienen los usuarios

        $data['title'] = 'Reservas';
        $data['habitaciones'] = $habitaciones;
        $data['clientes'] = $usuarios; // Se pasan los usuarios a la vista bajo la clave 'clientes'
        $this->views->getView('admin/Reservas/index', $data);
    }

    // Listar todas las reservas (JSON para DataTables)
    public function listar()
    {
        $reservas = $this->model->getReservas(true);

        foreach ($reservas as $key => $res) {
            if ($res['estado'] == 1) {
                $reservas[$key]['estado'] = '<span class="badge bg-success">Activo</span>';
                $reservas[$key]['acciones'] = '
                    <div>
                        <button class="btn btn-primary btn-sm" onclick="btnEditarReserva(' . $res['id'] . ')" title="Editar"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-warning btn-sm" onclick="btnInhabilitarReserva(' . $res['id'] . ')" title="Inhabilitar"><i class="fas fa-ban"></i></button>
                    </div>';
            } else {
                $reservas[$key]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
                $reservas[$key]['acciones'] = '
                    <div>
                         <button class="btn btn-success btn-sm" onclick="btnActivarReserva(' . $res['id'] . ')" title="Activar"><i class="fas fa-check-circle"></i></button>
                    </div>';
            }
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

    // Borrado lógico (inhabilitar)
    public function eliminar($id)
    {
        $id = intval($id);
        $res = $this->model->inhabilitarReserva($id);

        if ($res) {
            echo json_encode(['msg' => 'ok']);
        } else {
            echo json_encode(['msg' => 'No se pudo inhabilitar la reserva.']);
        }
        die();
    }

    // Activar reserva
    public function activar($id)
    {
        $id = intval($id);
        $res = $this->model->activarReserva($id);

        if ($res) {
            echo json_encode(['msg' => 'ok']);
        } else {
            echo json_encode(['msg' => 'No se pudo activar la reserva.']);
        }
        die();
    }
}
