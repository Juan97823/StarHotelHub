<?php
require_once 'models/admin/DashboardModel.php';

class Admin extends Controller
{
    private $dashboardModel;

    public function __construct()
    {
        parent::__construct();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // La verificación de sesión se mueve a cada método para permitir acceso público a la API

        $this->dashboardModel = new DashboardModel();
    }

    private function verificarSesionAdmin()
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 1) {
            header('Location: ' . RUTA_PRINCIPAL . 'login');
            exit;
        }
    }

    public function dashboard()
    {
        $this->verificarSesionAdmin(); // Proteger el dashboard principal

        $data['title'] = 'Panel de Administrador';
        $data['nombre_usuario'] = $_SESSION['usuario']['nombre'];

        // Cargar todas las métricas desde el modelo
        $data['total_clientes'] = $this->dashboardModel->getTotalClientes()['total'] ?? 0;
        $data['total_habitaciones'] = $this->dashboardModel->getTotalHabitaciones()['total'] ?? 0;
        $data['total_reservas'] = $this->dashboardModel->getTotalReservas()['total'] ?? 0;
        $ingresos = $this->dashboardModel->getIngresosTotales()['total'];
        $data['ingresos_totales'] = number_format($ingresos ?? 0, 2);

        // Datos para tablas y gráficos
        $data['ultimas_reservas'] = $this->dashboardModel->getUltimasReservas();
        $reservasMensuales = $this->dashboardModel->getReservasMensuales();

        // Formatear datos para el gráfico de barras
        $labels = [];
        $values = [];
        foreach ($reservasMensuales as $reserva) {
            $labels[] = $reserva['mes'];
            $values[] = $reserva['total'];
        }
        $data['chart_labels'] = json_encode($labels);
        $data['chart_values'] = json_encode($values);

        $this->views->getView('admin/dashboard', $data);
    }

    // --- NUEVO ENDPOINT PARA MÉTRICAS EN TIEMPO REAL ---
    public function metricasEnTiempoReal()
    {
        $datosRaw = $this->dashboardModel->getConteoEstadoReservas();
        
        // Inicializar conteos
        $metricas = [
            'pendientes' => 0,
            'completadas' => 0,
            'canceladas' => 0
        ];

        // Procesar datos de la consulta
        foreach ($datosRaw as $dato) {
            if ($dato['estado'] == 1) { // Asumiendo 1 = pendiente
                $metricas['pendientes'] = (int)$dato['total'];
            } elseif ($dato['estado'] == 2) { // Asumiendo 2 = completada
                $metricas['completadas'] = (int)$dato['total'];
            } else { // Asumiendo cualquier otro valor (ej. 0 o 3) = cancelada
                 $metricas['canceladas'] += (int)$dato['total'];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($metricas);
        exit;
    }
}
