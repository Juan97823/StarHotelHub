<?php
require_once 'helpers/seguridad.php';

class Admin extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Validar acceso solo para administradores
        $url = $_SERVER['REQUEST_URI'];
        if (strpos($url, 'admin/login') === false) {
            if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 1) {
                header('Location: ' . RUTA_PRINCIPAL . 'login');
                exit;
            }
        }

        // Cargar modelo del dashboard
        $this->cargarModel('DashboardModel');

        if (!$this->model) {
            die("Error: DashboardModel no se pudo cargar.");
        }
    }

    /**
     * Vista principal del dashboard
     */
    public function dashboard()
    {
        $data['title'] = 'Panel de Administrador';
        $data['nombre_usuario'] = $_SESSION['usuario']['nombre'] ?? 'Administrador';
        $this->views->getView('admin/dashboard', $data);
    }

    /**
     * Endpoint JSON con los datos del dashboard
     */
    public function getData()
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 1) {
            http_response_code(403);
            echo json_encode(['error' => 'Acceso no autorizado'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $datos = [
            'reservasHoy' => (int) ($this->model->getReservasHoy()['total'] ?? 0),
            'habitacionesDisponibles' => (int) ($this->model->getHabitacionesDisponibles()['total'] ?? 0),
            'ingresosMes' => number_format((float) ($this->model->getIngresosMes()['total'] ?? 0), 0, ',', '.'),
            'totalClientes' => (int) ($this->model->getTotalClientes()['total'] ?? 0),
        ];

        // Gráfico últimas 7 reservas
        $reservasSemana = $this->model->getReservasUltimaSemana() ?? [];
        $reservasPorDia = [];
        for ($i = 6; $i >= 0; $i--) {
            $fecha = date('Y-m-d', strtotime("-$i days"));
            $reservasPorDia[$fecha] = 0;
        }
        foreach ($reservasSemana as $reserva) {
            if (isset($reservasPorDia[$reserva['fecha']])) {
                $reservasPorDia[$reserva['fecha']] = (int) $reserva['total'];
            }
        }
        $datos['grafico'] = [
            'etiquetas' => array_keys($reservasPorDia),
            'valores' => array_values($reservasPorDia)
        ];

        // Últimas reservas
        $datos['ultimasReservas'] = $this->model->getUltimasReservas() ?? [];

        // Respuesta JSON
        header('Content-Type: application/json');
        echo json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
        exit;
    }

    /**
     * Cerrar sesión
     */
    public function salir()
    {
        session_unset();
        session_destroy();
        session_regenerate_id(true);
        header('Location: ' . RUTA_PRINCIPAL . 'login');
        exit;
    }
}
