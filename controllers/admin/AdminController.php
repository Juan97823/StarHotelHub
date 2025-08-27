<?php
require_once 'models/DashboardModel.php';

class AdminController extends Controller
{

    public function __construct()
    {
        session_start();

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 1) {
            header('Location: ' . RUTA_PRINCIPAL . 'login');
            exit;
        }

        $this->model = new DashboardModel();
    }

    public function dashboard()
    {
        $data['title'] = 'Panel de Administrador';
        $data['nombre_usuario'] = $_SESSION['usuario']['nombre'];
        $this->views->getView('admin/dashboard', $data);
    }

    public function dashboardData()
    {
        // Solo acepta solicitudes AJAX autenticadas
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 1) {
            http_response_code(403);
            echo json_encode(['error' => 'Acceso no autorizado']);
            exit;
        }

        // Protege acceso y estructura de datos
        $data = [
            'reservasHoy' => (int) ($this->model->getReservasHoy()['total'] ?? 0),
            'habitacionesDisponibles' => (int) ($this->model->getHabitacionesDisponibles()['total'] ?? 0),
            'ingresosMes' => number_format((float) ($this->model->getIngresosMes()['total'] ?? 0), 0, ',', '.'),
            'totalClientes' => (int) ($this->model->getTotalClientes()['total'] ?? 0),
            'reservasMensuales' => $this->model->getReservasMensuales() ?? [],
            'ultimasReservas' => $this->model->getUltimasReservas() ?? [],
        ];

        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
