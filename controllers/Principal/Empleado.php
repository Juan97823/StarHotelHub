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
        $data['checkins_hoy'] = $this->model->contarReservasPorFecha('fecha_ingreso', 1)['total'] ?? 0;
        $data['checkouts_hoy'] = $this->model->contarReservasPorFecha('fecha_salida', 2)['total'] ?? 0;
        $data['habitaciones_ocupadas'] = $this->model->contarHabitacionesOcupadas()['total'] ?? 0;
        $data['habitaciones_disponibles'] = $this->model->contarHabitacionesDisponibles()['total'] ?? 0;
        $data['llegadas_hoy'] = $this->model->getLlegadasHoy();
        $data['salidas_hoy'] = $this->model->getSalidasHoy();
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

            case 'guardar':
                $this->guardar();
                break;

            case 'obtener':
                $this->obtener();
                break;

            case 'verificar':
                $this->verificar();
                break;

            case 'confirmar':
                $this->confirmar();
                break;

            case 'activar':
                $this->activar();
                break;

            case 'checkout':
                $this->checkout();
                break;

            case 'eliminar':
                $this->eliminar();
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
            <div class="btn-group btn-group-sm" role="group">
                <button class="btn btn-primary" title="Editar" onclick="btnEditarReserva(' . $r['id'] . ')">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-success" title="Check-In" onclick="btnActivarReserva(' . $r['id'] . ')">
                    <i class="fas fa-sign-in-alt"></i>
                </button>
                <button class="btn btn-warning" title="Check-Out" onclick="btnCheckOutReserva(' . $r['id'] . ')">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
                <button class="btn btn-danger" title="Cancelar" onclick="btnCancelarReserva(' . $r['id'] . ')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
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

    /** GUARDAR RESERVA (CREAR O ACTUALIZAR) **/
    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['msg' => 'error'], JSON_UNESCAPED_UNICODE);
            die();
        }

        $idReserva = intval($_POST['idReserva'] ?? 0);
        $idHabitacion = intval($_POST['habitacion'] ?? 0);
        $idCliente = intval($_POST['cliente'] ?? 0);
        $fechaIngreso = $_POST['fecha_ingreso'] ?? '';
        $fechaSalida = $_POST['fecha_salida'] ?? '';
        $montoEnviado = floatval($_POST['monto'] ?? 0);

        // Validar campos requeridos
        if (empty($idHabitacion) || empty($idCliente) || empty($fechaIngreso) || empty($fechaSalida)) {
            echo json_encode(['msg' => 'Todos los campos son obligatorios'], JSON_UNESCAPED_UNICODE);
            die();
        }

        // Validar fechas
        try {
            $fecha1 = new DateTime($fechaIngreso);
            $fecha2 = new DateTime($fechaSalida);
            if ($fecha2 <= $fecha1) {
                echo json_encode(['msg' => 'La fecha de salida debe ser posterior a la de ingreso'], JSON_UNESCAPED_UNICODE);
                die();
            }
        } catch (Exception $e) {
            echo json_encode(['msg' => 'Fechas inválidas'], JSON_UNESCAPED_UNICODE);
            die();
        }

        // Verificar disponibilidad (excepto si es actualización de la misma reserva)
        $sql = "SELECT * FROM reservas
                WHERE id_habitacion = ?
                AND fecha_ingreso < ?
                AND fecha_salida > ?
                AND estado != 0";

        if ($idReserva > 0) {
            $sql .= " AND id != ?";
            $params = [$idHabitacion, $fechaSalida, $fechaIngreso, $idReserva];
        } else {
            $params = [$idHabitacion, $fechaSalida, $fechaIngreso];
        }

        $reservasConflicto = $this->model->select($sql, $params);
        if (!empty($reservasConflicto)) {
            echo json_encode(['msg' => 'La habitación no está disponible en esas fechas'], JSON_UNESCAPED_UNICODE);
            die();
        }

        // Obtener datos de la habitación
        $habitacion = $this->model->select("SELECT * FROM habitaciones WHERE id = ?", [$idHabitacion]);
        if (empty($habitacion)) {
            echo json_encode(['msg' => 'Habitación no encontrada'], JSON_UNESCAPED_UNICODE);
            die();
        }

        // Calcular monto: días × precio por noche
        $dias = $fecha1->diff($fecha2)->days;
        $monto = $dias * $habitacion['precio'];

        if ($idReserva > 0) {
            // Actualizar
            $resultado = $this->model->actualizarReserva($idReserva, $idHabitacion, $idCliente, $fechaIngreso, $fechaSalida, $monto);
        } else {
            // Crear
            $resultado = $this->model->crearReserva($idHabitacion, $idCliente, $fechaIngreso, $fechaSalida, $monto, 'Confirmada');
        }

        $res = ($resultado > 0) ? ['msg' => 'ok'] : ['msg' => 'Error al guardar'];
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    /** OBTENER RESERVA POR ID **/
    public function obtener()
    {
        $id = intval($_GET['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['error' => 'ID inválido'], JSON_UNESCAPED_UNICODE);
            die();
        }

        $sql = "SELECT * FROM reservas WHERE id = ?";
        $reserva = $this->model->select($sql, [$id]);
        echo json_encode($reserva, JSON_UNESCAPED_UNICODE);
        die();
    }

    /** VERIFICAR DISPONIBILIDAD **/
    public function verificar()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['disponible' => false], JSON_UNESCAPED_UNICODE);
            die();
        }

        $idHabitacion = intval($_POST['habitacion'] ?? 0);
        $fechaIngreso = $_POST['fecha_ingreso'] ?? '';
        $fechaSalida = $_POST['fecha_salida'] ?? '';
        $idReserva = intval($_POST['id_reserva'] ?? 0);

        if (empty($idHabitacion) || empty($fechaIngreso) || empty($fechaSalida)) {
            echo json_encode(['disponible' => false], JSON_UNESCAPED_UNICODE);
            die();
        }

        // Buscar conflictos de reservas
        $sql = "SELECT * FROM reservas
                WHERE id_habitacion = ?
                AND fecha_ingreso < ?
                AND fecha_salida > ?
                AND estado != 0";

        if ($idReserva > 0) {
            $sql .= " AND id != ?";
            $params = [$idHabitacion, $fechaSalida, $fechaIngreso, $idReserva];
        } else {
            $params = [$idHabitacion, $fechaSalida, $fechaIngreso];
        }

        $conflictos = $this->model->select($sql, $params);
        $disponible = empty($conflictos);

        echo json_encode(['disponible' => $disponible], JSON_UNESCAPED_UNICODE);
        die();
    }

    /** CONFIRMAR RESERVA **/
    public function confirmar()
    {
        $id = intval($_GET['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['msg' => 'error'], JSON_UNESCAPED_UNICODE);
            die();
        }

        $resultado = $this->model->cambiarEstadoReserva($id, 'Confirmada');
        $res = ($resultado > 0) ? ['msg' => 'ok'] : ['msg' => 'error'];
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    /** ACTIVAR RESERVA (CHECK-IN) **/
    public function activar()
    {
        $id = intval($_GET['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['msg' => 'error'], JSON_UNESCAPED_UNICODE);
            die();
        }

        $resultado = $this->model->cambiarEstadoReserva($id, 'Activa');
        $res = ($resultado > 0) ? ['msg' => 'ok'] : ['msg' => 'error'];
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    /** CHECK-OUT RESERVA (COMPLETADA) **/
    public function checkout()
    {
        $id = intval($_GET['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['msg' => 'error'], JSON_UNESCAPED_UNICODE);
            die();
        }

        $resultado = $this->model->cambiarEstadoReserva($id, 'Completada');
        $res = ($resultado > 0) ? ['msg' => 'ok'] : ['msg' => 'error'];
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    /** ELIMINAR RESERVA (CANCELAR) **/
    public function eliminar()
    {
        $id = intval($_GET['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['msg' => 'error'], JSON_UNESCAPED_UNICODE);
            die();
        }

        $resultado = $this->model->cambiarEstadoReserva($id, 'Cancelada');
        $res = ($resultado > 0) ? ['msg' => 'ok'] : ['msg' => 'error'];
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
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