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

        // Redirigir si no es un administrador logueado
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 1) { 
            header('Location: ' . RUTA_PRINCIPAL . 'login');
            exit;
        }
    }

    // Muestra la vista principal del dashboard
    public function dashboard()
    {
        $data['title'] = 'Panel de Administrador';
        $this->views->getView('admin/dashboard', $data);
    }

    /**
     * Endpoint para obtener todos los datos del dashboard en formato JSON.
     */
    public function getData()
    {
        // Corrección: Usar el nombre de método correcto del framework
        $this->cargarModel('admin/DashboardModel');
        
        // No es necesario instanciar de nuevo, cargarModel ya lo hace en $this->model
        $dashboardModel = $this->model;

        $datos = [];

        // 1. Datos para las tarjetas (KPIs)
        $datos['reservasHoy'] = $dashboardModel->getReservasHoy()['total'] ?? 0;
        $datos['habitacionesDisponibles'] = $dashboardModel->getHabitacionesDisponibles();
        $datos['ingresosMes'] = $dashboardModel->getIngresosMes();
        $datos['totalClientes'] = $dashboardModel->getTotalClientes()['total'] ?? 0;

        // 2. Datos para el gráfico de la última semana
        $reservasSemana = $dashboardModel->getReservasUltimaSemana();
        $reservasPorDia = [];
        for ($i = 6; $i >= 0; $i--) {
            $fecha = date('Y-m-d', strtotime("-$i days"));
            $reservasPorDia[$fecha] = 0;
        }
        
        foreach ($reservasSemana as $reserva) {
            if (isset($reservasPorDia[$reserva['fecha']])) {
                $reservasPorDia[$reserva['fecha']] = $reserva['total'];
            }
        }

        $datos['grafico'] = [
            'etiquetas' => array_keys($reservasPorDia),
            'valores' => array_values($reservasPorDia)
        ];

        // 3. Datos para la tabla de últimas reservas
        $datos['ultimasReservas'] = $dashboardModel->getUltimasReservas();

        // Servir los datos como JSON
        header('Content-Type: application/json');
        echo json_encode($datos, JSON_NUMERIC_CHECK);
        die();
    }

    public function salir()
    {
        session_destroy();
        redirect(RUTA_PRINCIPAL . 'login');
    }
}
?>