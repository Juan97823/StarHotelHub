<?php
require_once 'helpers/seguridad.php';

class Empleado extends Controller
{
    private $reservaModel;

    public function __construct()
    {
        parent::__construct();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Solo empleados (rol = 2)
        if (empty($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 2) {
            header('Location: ' . RUTA_PRINCIPAL . 'login');
            exit;
        }

        $this->reservaModel = new ReservasModelEmpleado();
    }

    public function dashboard()
    {
        $data['title'] = 'Panel de Empleado';
        $idEmpleado = $_SESSION['usuario']['id'];

        // Datos de reservas
        $totalReservas = $this->reservaModel->getCantidadReservas();
        $reservasActivas = $this->reservaModel->getCantidadReservasByEstado(1); // Activas
        $reservasCanceladas = $this->reservaModel->getCantidadReservasByEstado(0); // Canceladas
        $ultimasReservas = $this->reservaModel->getUltimasReservas();

        // Datos para la vista
        $data['nombre_usuario'] = $_SESSION['usuario']['nombre'];
        $data['total_reservas'] = $totalReservas['total'] ?? 0;
        $data['reservas_activas'] = $reservasActivas['total'] ?? 0;
        $data['reservas_canceladas'] = $reservasCanceladas['total'] ?? 0;
        $data['reservas'] = $ultimasReservas;

        $this->views->getView('empleado/dashboard', $data);
    }
    public function reservas()
    {
        require_once 'controllers/principal/ReservasEmpleado.php';

        $reservasController = new ReservasEmpleado();
        $reservasController->index();
    }

}
?>