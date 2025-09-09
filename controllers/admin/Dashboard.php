<?php

class Dashboard extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // Se utiliza el helper 'verificarRol' para consistencia y seguridad.
        // Se asume que el rol de administrador es 1.
        verificarRol(1);
    }

    public function index()
    {
        $data['title'] = 'Panel de Administrador';
        // La vista del dashboard se carga, y los datos se obtienen vía AJAX con el método getData().
        $this->views->getView('admin/dashboard', $data);
    }

    public function getData()
    {
        // Se utiliza el nuevo método 'cargarmodel' con el nombre del modelo.
        $this->cargarModel('DashboardModel');

        $datos = [];

        // Se utiliza directamente $this->model, que ya contiene la instancia.
        $datos['reservasHoy'] = $this->model->getReservasHoy()['total'] ?? 0;
        $datos['habitacionesDisponibles'] = $this->model->getHabitacionesDisponibles();
        $datos['ingresosMes'] = $this->model->getIngresosMes();
        $datos['totalClientes'] = $this->model->getTotalClientes()['total'] ?? 0;

        // Datos para el gráfico
        $reservasSemana = $this->model->getReservasUltimaSemana();
        $reservasPorDia = [];
        for ($i = 6; $i >= 0; $i--) {
            $fecha = date('Y-m-d', strtotime("-$i days"));
            $reservasPorDia[$fecha] = 0;
        }
        foreach ($reservasSemana as $reserva) {
            if (isset($reservasPorDia[$reserva['fecha']])) {
                $reservasPorDia[$reserva['fecha']] = (int)$reserva['total'];
            }
        }
        $datos['grafico'] = [
            'etiquetas' => array_keys($reservasPorDia),
            'valores' => array_values($reservasPorDia)
        ];

        // Últimas reservas
        $datos['ultimasReservas'] = $this->model->getUltimasReservas();

        header('Content-Type: application/json');
        echo json_encode($datos, JSON_NUMERIC_CHECK);
        die();
    }

    // El método salir() ha sido eliminado de aquí.
    // La funcionalidad de logout ahora es manejada exclusivamente
    // por el controlador de Login para mayor seguridad y centralización.
}
?>