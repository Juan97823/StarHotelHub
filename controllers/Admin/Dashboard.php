<?php

class Dashboard extends Controller
{
    public function __construct()
    {
        parent::__construct();
        verificarRol(1);
    }

    /**
     * Muestra la página principal del panel de administración.
     */
    public function index()
    {
        $data['title'] = 'Panel de Administración';
        $this->views->getView('admin/dashboard', $data);
    }

    /**
     * Endpoint para obtener los datos del dashboard vía AJAX.
     * Retorna un JSON con todas las estadísticas necesarias.
     */
    public function getData()
    {
        $this->cargarModel('DashboardModel');

        $reservasHoy = $this->model->getReservasHoy()['total'] ?? 0;
        $habitacionesDisponibles = $this->model->getHabitacionesDisponibles()['total'] ?? 0;
        $ingresosMes = $this->model->getIngresosMes()['total'] ?? 0.00;
        $totalClientes = $this->model->getTotalClientes()['total'] ?? 0;
        $ultimasReservas = $this->model->getUltimasReservas(5);

        $reservasSemana = $this->model->getReservasUltimaSemana();
        $graficoReservas = $this->prepararDatosGrafico($reservasSemana);

        $data = [
            'indicadores' => [
                'reservasHoy' => $reservasHoy,
                'habitacionesDisponibles' => $habitacionesDisponibles,
                'ingresosMes' => number_format($ingresosMes, 2),
                'totalClientes' => $totalClientes,
            ],
            'graficoReservas' => $graficoReservas,
            'ultimasReservas' => $ultimasReservas
        ];

        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        die();
    }

    /**
     * Prepara los datos para el gráfico de Chart.js.
     * @param array $datosReservas - Datos de las reservas de la última semana.
     * @return array - Array con etiquetas y valores para el gráfico.
     */
    private function prepararDatosGrafico($datosReservas)
    {
        $dias = [];
        // Inicializar los últimos 7 días con 0 reservas.
        for ($i = 6; $i >= 0; $i--) {
            $fecha = date('Y-m-d', strtotime("-$i days"));
            $dias[date('D', strtotime($fecha))] = 0; // 'Mon', 'Tue', etc.
        }

        // Llenar los días con los totales de las reservas.
        foreach ($datosReservas as $reserva) {
            $diaSemana = date('D', strtotime($reserva['fecha']));
            if (isset($dias[$diaSemana])) {
                $dias[$diaSemana] = (int)$reserva['total'];
            }
        }

        return [
            'labels' => array_keys($dias),
            'data' => array_values($dias)
        ];
    }
}
?>