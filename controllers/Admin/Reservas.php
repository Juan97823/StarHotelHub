<?php
require_once 'helpers/seguridad.php';
require 'models/admin/HabitacionesModel.php';
require 'models/admin/UsuariosModel.php';

class Reservas extends Controller
{
    private $HabitacionModel;
    private $UsuariosModel;

    public function __construct()
    {
        parent::__construct();
        verificarSesion(1); // Solo administradores
        $this->HabitacionModel = new HabitacionesModel();
        $this->UsuariosModel = new UsuariosModel();
    }

    public function index()
    {
        $habitaciones = $this->HabitacionModel->getHabitaciones(false);
        $usuarios = $this->UsuariosModel->getUsuarios();

        $data['title'] = 'Reservas';
        $data['habitaciones'] = $habitaciones;
        $data['clientes'] = $usuarios;
        $this->views->getView('admin/Reservas/index', $data);
    }

    // Listar todas las reservas (JSON para DataTables)
    public function listar()
    {
        $reservas = $this->model->getReservas(true);

        foreach ($reservas as $key => $res) {
            // Inicializar acciones por defecto
            $acciones = '<div></div>';

            switch ($res['estado']) {
                case 1: // Pendiente
                    $reservas[$key]['estado'] = '<span class="badge bg-warning">Pendiente</span>';
                    $acciones = '
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-success" onclick="btnConfirmarReserva(' . $res['id'] . ')" title="Confirmar"><i class="fas fa-check"></i></button>
                            <button class="btn btn-danger" onclick="btnCancelarReserva(' . $res['id'] . ')" title="Cancelar"><i class="fas fa-times"></i></button>
                            <button class="btn btn-primary" onclick="imprimirFactura(' . $res['id'] . ')" title="Imprimir Factura"><i class="fas fa-print"></i></button>
                        </div>';
                    break;
                case 2: // Confirmado
                    $reservas[$key]['estado'] = '<span class="badge bg-success">Confirmado</span>';
                    $acciones = '
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-danger" onclick="btnCancelarReserva(' . $res['id'] . ')" title="Cancelar"><i class="fas fa-times"></i></button>
                            <button class="btn btn-primary" onclick="imprimirFactura(' . $res['id'] . ')" title="Imprimir Factura"><i class="fas fa-print"></i></button>
                        </div>';
                    break;
                case 0: // Cancelado
                    $reservas[$key]['estado'] = '<span class="badge bg-danger">Cancelado</span>';
                    $acciones = '
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-info" onclick="btnActivarReserva(' . $res['id'] . ')" title="Reactivar"><i class="fas fa-sync-alt"></i></button>
                            <button class="btn btn-primary" onclick="imprimirFactura(' . $res['id'] . ')" title="Imprimir Factura"><i class="fas fa-print"></i></button>
                        </div>';
                    break;
                default:
                    $reservas[$key]['estado'] = '<span class="badge bg-secondary">Desconocido</span>';
                    $acciones = '
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-primary" onclick="imprimirFactura(' . $res['id'] . ')" title="Imprimir Factura"><i class="fas fa-print"></i></button>
                        </div>';
                    break;
            }

            $reservas[$key]['acciones'] = $acciones;
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

    // Cancelar reserva (Borrado lógico)
    public function eliminar($id)
    {
        $id = intval($id);
        $res = $this->model->cambiarEstadoReserva($id, 0); // 0 = Cancelado

        if ($res) {
            echo json_encode(['msg' => 'ok']);
        } else {
            echo json_encode(['msg' => 'No se pudo cancelar la reserva.']);
        }
        die();
    }

    // Reactivar reserva
    public function activar($id)
    {
        $id = intval($id);
        $res = $this->model->cambiarEstadoReserva($id, 1); // 1 = Pendiente

        if ($res) {
            echo json_encode(['msg' => 'ok']);
        } else {
            echo json_encode(['msg' => 'No se pudo reactivar la reserva.']);
        }
        die();
    }

    // Confirmar reserva
    public function confirmar($id)
    {
        $id = intval($id);
        $res = $this->model->cambiarEstadoReserva($id, 2); // 2 = Confirmado

        if ($res) {
            echo json_encode(['msg' => 'ok']);
        } else {
            echo json_encode(['msg' => 'No se pudo confirmar la reserva.']);
        }
        die();
    }
}
