<?php

class Empleado extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->cargarModel('EmpleadoModel');

        if (empty($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 2) {
            header('Location: ' . RUTA_PRINCIPAL . 'login');
            exit;
        }

        if (!$this->model) {
            die("Error: EmpleadoModel no se pudo cargar.");
        }
    }

    public function dashboard()
    {
        $data['title'] = 'Panel de Empleado';
        $data['checkins_hoy'] = $this->model->contarReservasPorFecha('fecha_ingreso', 1)['total'];
        $data['checkouts_hoy'] = $this->model->contarReservasPorFecha('fecha_salida', 2)['total'];
        $data['habitaciones_ocupadas'] = $this->model->contarHabitacionesOcupadas()['total'];
        $data['actividad_dia'] = $this->model->getActividadDia();
        $this->views->getView('empleado/dashboard', $data);
    }

    public function reservas($params = 'reservas')
    {
        if ($params == 'reservas') {
            $data['title'] = 'Gestión de Reservas';
            $data['habitaciones'] = $this->model->getDatos('habitaciones');
            $data['clientes'] = $this->model->getDatos('clientes');
            $this->views->getView('empleado/Reservas', $data);
        } elseif ($params == 'listar') {
            $this->listar();
        } elseif ($params == 'crear') {
            $this->crear();
        } elseif (strpos($params, 'actualizar/') === 0) {
            $id = str_replace('actualizar/', '', $params);
            $this->actualizar($id);
        }
    }

    public function listar()
    {
        $reservas = $this->model->getReservas();
        $data = [];

        foreach ($reservas as $r) {
            $data[] = [
                $r['id'],
                $r['estilo_habitacion'],
                $r['nombre_cliente'],
                $r['fecha_ingreso'],
                $r['fecha_salida'],
                '$' . number_format($r['monto'], 0, ',', '.'),
                $r['estado'],
                '<button class="btn btn-sm btn-info">Ver</button>
             <button class="btn btn-sm btn-warning">Editar</button>'
            ];
        }

        echo json_encode(['data' => $data], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        die();
    }
    private function crear()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idHabitacion = intval($_POST['habitacion']);
            $idCliente = intval($_POST['cliente']);
            $fechaIngreso = $_POST['fecha_ingreso'];
            $fechaSalida = $_POST['fecha_salida'];
            $monto = floatval($_POST['monto']);

            if (empty($idHabitacion) || empty($idCliente) || empty($fechaIngreso) || empty($fechaSalida) || empty($monto)) {
                $res = ['status' => false, 'msg' => 'Todos los campos son obligatorios'];
            } else {
                $data = $this->model->crearReserva($idHabitacion, $idCliente, $fechaIngreso, $fechaSalida, $monto, 'Confirmada');
                $res = ($data > 0)
                    ? ['status' => true, 'msg' => 'Reserva registrada con éxito']
                    : ['status' => false, 'msg' => 'Error al registrar la reserva'];
            }
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    private function actualizar($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $id > 0) {
            $idHabitacion = intval($_POST['habitacion']);
            $idCliente = intval($_POST['cliente']);
            $fechaIngreso = $_POST['fecha_ingreso'];
            $fechaSalida = $_POST['fecha_salida'];
            $monto = floatval($_POST['monto']);

            if (empty($idHabitacion) || empty($idCliente) || empty($fechaIngreso) || empty($fechaSalida) || empty($monto)) {
                $res = ['status' => false, 'msg' => 'Todos los campos son obligatorios'];
            } else {
                $data = $this->model->actualizarReserva($id, $idHabitacion, $idCliente, $fechaIngreso, $fechaSalida, $monto);
                $res = ($data > 0)
                    ? ['status' => true, 'msg' => 'Reserva actualizada con éxito']
                    : ['status' => false, 'msg' => 'Error al actualizar la reserva'];
            }
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getReserva($idReserva)
    {
        $id = intval($idReserva);
        $data = $this->model->getReserva($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function actualizarEstadoReserva($idReserva, $nuevoEstado)
    {
        $id = intval($idReserva);
        $estadosPermitidos = ['Activa', 'Completada', 'Cancelada'];
        if (in_array($nuevoEstado, $estadosPermitidos)) {
            $data = $this->model->cambiarEstadoReserva($id, $nuevoEstado);
            $res = ($data == 1)
                ? ['status' => true, 'msg' => 'Estado de la reserva actualizado']
                : ['status' => false, 'msg' => 'Error al actualizar el estado'];
        } else {
            $res = ['status' => false, 'msg' => 'Estado no válido'];
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>