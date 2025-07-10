<?php
require_once 'models/DashboardModel.php';

class AdminController
{
    private $model;

    public function __construct()
    {
        $this->model = new DashboardModel();
    }

    public function dashboardData()
    {
        session_start();
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'Administrador') {
            http_response_code(403); // Prohibido
            echo json_encode(['error' => 'Acceso no autorizado']);
            exit;
        }

        $data = [
            'reservasHoy' => $this->model->getReservasHoy()['total'],
            'habitacionesDisponibles' => $this->model->getHabitacionesDisponibles()['total'],
            'ingresosMes' => number_format($this->model->getIngresosMes()['total'], 0, ',', '.'),
            'totalClientes' => $this->model->getTotalClientes()['total'],
            'reservasMensuales' => $this->model->getReservasMensuales(),
            'ultimasReservas' => $this->model->getUltimasReservas(),
        ];

        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
