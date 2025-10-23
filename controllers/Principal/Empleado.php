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
            die("Error: No se pudo cargar el modelo EmpleadoModel.");
        }
    }

    /** DASHBOARD **/
    public function dashboard()
    {
        $data['title'] = 'Panel de Empleado';
        $data['checkins_hoy'] = $this->model->contarReservasPorFecha('fecha_ingreso', 1)['total'];
        $data['checkouts_hoy'] = $this->model->contarReservasPorFecha('fecha_salida', 2)['total'];
        $data['habitaciones_ocupadas'] = $this->model->contarHabitacionesOcupadas()['total'];
        $data['actividad_dia'] = $this->model->getActividadDia();
        $this->views->getView('empleado/dashboard', $data);
    }

    /** VISTA PRINCIPAL DE RESERVAS **/
    public function reservas($params = '')
    {
        switch ($params) {
            case '':
            case 'reservas':
                $data['title'] = 'Gestión de Reservas';
                $data['habitaciones'] = $this->model->getDatos('habitaciones');
                $data['clientes'] = $this->model->getDatos('clientes');
                $this->views->getView('empleado/Reservas', $data);
                break;

            case 'listar':
                $this->listar();
                break;

            case 'crear':
                $this->crear();
                break;

            default:
                if (strpos($params, 'actualizar/') === 0) {
                    $id = str_replace('actualizar/', '', $params);
                    $this->actualizar($id);
                }
                break;
        }
    }

    /** LISTAR RESERVAS PARA DATATABLES **/
    public function listar()
    {
        $data = $this->model->getReservas();
        $result = [];

        foreach ($data as $r) {
            $botones = '
            <button class="btn btn-sm btn-success" onclick="actualizarEstado(' . $r['id'] . ', \'Activa\')">Dar Ingreso</button>
            <button class="btn btn-sm btn-danger" onclick="actualizarEstado(' . $r['id'] . ', \'Cancelada\')">Cancelar</button>
            <button class="btn btn-sm btn-secondary" onclick="actualizarEstado(' . $r['id'] . ', \'Completada\')">Finalizar</button>
        ';

            $result[] = [
                $r['id'],
                $r['estilo_habitacion'],
                $r['nombre_cliente'],
                $r['fecha_ingreso'],
                $r['fecha_salida'],
                '$' . number_format($r['monto'], 0, ',', '.'),
                $r['estado'],
                $botones
            ];
        }

        echo json_encode(['data' => $result], JSON_UNESCAPED_UNICODE);
        die();
    }


    /** COLOR SEGÚN ESTADO **/
    private function getColorEstado($estado)
    {
        return match ($estado) {
            'Activa' => 'success',
            'Confirmada' => 'primary',
            'Pendiente de Pago' => 'warning',
            'Cancelada' => 'danger',
            'Completada' => 'secondary',
            default => 'light'
        };
    }

    /** CREAR RESERVA **/
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

    /** ACTUALIZAR RESERVA **/
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

    /** CAMBIAR ESTADO **/
    public function actualizarEstadoReserva()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            $nuevoEstado = trim($_POST['estado']);

            $estadosPermitidos = ['Activa', 'Completada', 'Cancelada'];

            if (in_array($nuevoEstado, $estadosPermitidos)) {
                $data = $this->model->cambiarEstadoReserva($id, $nuevoEstado);
                $res = ($data > 0)
                    ? ['status' => true, 'msg' => 'Estado de la reserva actualizado correctamente.']
                    : ['status' => false, 'msg' => 'No se pudo actualizar el estado.'];
            } else {
                $res = ['status' => false, 'msg' => 'Estado no válido.'];
            }

            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            die();
        }
    }
}