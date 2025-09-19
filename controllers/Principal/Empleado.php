<?php

class Empleado extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Cargar el modelo específico para este controlador
        $this->cargarModel('EmpleadoModel');

        // Validar acceso solo para empleados (rol = 2)
        if (empty($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 2) {
            header('Location: ' . RUTA_PRINCIPAL . 'login');
            exit;
        }

        // Verificación de que el modelo se cargó correctamente
        if (!$this->model) {
            die("Error: EmpleadoModel no se pudo cargar.");
        }
    }

    public function dashboard()
    {
        $data['title'] = 'Panel de Empleado';
        // Acceso correcto a los datos del array
        $data['checkins_hoy'] = $this->model->contarReservasPorFecha('fecha_ingreso', 1)['total'];
        $data['checkouts_hoy'] = $this->model->contarReservasPorFecha('fecha_salida', 2)['total'];
        $data['habitaciones_ocupadas'] = $this->model->contarHabitacionesOcupadas()['total'];
        $data['actividad_dia'] = $this->model->getActividadDia();

        // Ruta correcta para la vista
        $this->views->getView('empleado/dashboard', $data);
    }

    public function reservas()
    {
        $data['title'] = 'Gestión de Reservas';
        $data['habitaciones'] = $this->model->getDatos('habitaciones');
        $data['clientes'] = $this->model->getDatos('clientes');
        // Ruta correcta para la vista
        $this->views->getView('empleado/reservas', $data);
    }

    // --- API ENDPOINTS PARA AJAX ---

    public function listarReservas()
    {
        $data = $this->model->getReservas();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrarReserva()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idReserva = !empty($_POST['idReserva']) ? intval($_POST['idReserva']) : null;
            $idHabitacion = intval($_POST['habitacion']);
            $idCliente = intval($_POST['cliente']);
            $fechaIngreso = $_POST['fecha_ingreso'];
            $fechaSalida = $_POST['fecha_salida'];
            $monto = floatval($_POST['monto']);

            if (empty($idHabitacion) || empty($idCliente) || empty($fechaIngreso) || empty($fechaSalida) || empty($monto)) {
                $res = ['status' => false, 'msg' => 'Todos los campos son obligatorios'];
            } else {
                if ($idReserva) {
                    $data = $this->model->actualizarReserva($idReserva, $idHabitacion, $idCliente, $fechaIngreso, $fechaSalida, $monto);
                    $res = ($data > 0)
                        ? ['status' => true, 'msg' => 'Reserva actualizada con éxito']
                        : ['status' => false, 'msg' => 'Error al actualizar la reserva'];
                } else {
                    $data = $this->model->crearReserva($idHabitacion, $idCliente, $fechaIngreso, $fechaSalida, $monto, 'Confirmada');
                    $res = ($data > 0)
                        ? ['status' => true, 'msg' => 'Reserva registrada con éxito']
                        : ['status' => false, 'msg' => 'Error al registrar la reserva'];
                }
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