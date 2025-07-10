<?php
class Admin extends Controller
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 1) {
            header('Location: ' . RUTA_PRINCIPAL . 'login');
            exit;
        }

        parent::__construct();
    }

    public function dashboard()
    {
        $data['title'] = 'Panel de Administrador';
        $data['nombre_usuario'] = $_SESSION['usuario']['nombre'];
        $this->views->getView('admin/dashboard', $data);
    }


    public function dashboardData()
    {
        require_once 'models/DashboardModel.php';
        $model = new DashboardModel();

        $data = [
            'reservasHoy' => $model->getReservasHoy()['total'],
            'habitacionesDisponibles' => $model->getHabitacionesDisponibles()['total'],
            'ingresosMes' => number_format($model->getIngresosMes()['total'], 0, ',', '.'),
            'totalClientes' => $model->getTotalClientes()['total'],
            'reservasMensuales' => $model->getReservasMensuales(),
            'ultimasReservas' => $model->getUltimasReservas(),
        ];

        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
