<?php
class Dashboard extends Controller
{
    public function __construct()
    {
        parent::__construct();
        verificarRol(1); // Solo administradores
        $this->cargarModel('DashboardModel');

        if (!$this->model) {
            die("Error: DashboardModel no se pudo cargar.");
        }
    }

    /**
     * Vista principal del panel de administración
     */
    public function index()
    {
        $data['title'] = 'Panel de Administración';
        $data['nombre_usuario'] = $_SESSION['usuario']['nombre'] ?? 'Administrador';
        $this->views->getView('admin/dashboard', $data);
    }

    /**
     * Endpoint JSON para AJAX: devuelve todos los datos del dashboard
     */
    public function getData()
    {
        error_log("Dashboard::getData() - Iniciando");

        $this->cargarModel('DashboardModel');

        if (!$this->model) {
            error_log("ERROR Dashboard::getData() - Model no esta cargado");
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Model no cargado'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        error_log("Dashboard::getData() - Model cargado correctamente");

        try {
            // --- Indicadores ---
            $reservasHoy = $this->model->getReservasHoy()['total'] ?? 0;
            $habitacionesDisponibles = $this->model->getHabitacionesDisponibles()['total'] ?? 0;
            $ingresosMes = $this->model->getIngresosMes()['total'] ?? 0.00;
            $totalClientes = $this->model->getTotalClientes()['total'] ?? 0;

            error_log("Dashboard::getData() - Indicadores obtenidos");
        } catch (Exception $e) {
            error_log("ERROR Dashboard::getData() - Error al obtener indicadores: " . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // --- Últimas reservas ---
        $ultimasReservasRaw = $this->model->getUltimasReservas(5);
        $ultimasReservas = [];

        foreach ($ultimasReservasRaw as $reserva) {
            // Convertir estado numérico a texto
            switch ($reserva['estado']) {
                case 0:
                    $estado_texto = 'Pendiente';
                    break;
                case 1:
                    $estado_texto = 'Confirmada';
                    break;
                case 2:
                    $estado_texto = 'Completada';
                    break;
                default:
                    $estado_texto = 'Desconocido';
            }

            $ultimasReservas[] = [
                'id' => $reserva['id'],                      // ID de la reserva para la factura
                'cliente' => $reserva['cliente'],            // Nombre del cliente
                'habitacion' => $reserva['habitacion'],      // Estilo de habitación
                'fecha_reserva' => $reserva['fecha_ingreso'], // Fecha de ingreso
                'estado' => $reserva['estado'],              // Estado numérico para el badge
                'estado_texto' => $estado_texto              // Estado en texto
            ];
        }

        // --- Gráfico últimas 7 reservas ---
        $reservasSemanaRaw = $this->model->getReservasUltimaSemana();
        $graficoReservas = ['labels' => [], 'data' => []];

        // Inicializar últimos 7 días con 0 reservas
        for ($i = 6; $i >= 0; $i--) {
            $fecha = date('Y-m-d', strtotime("-$i days"));
            $graficoReservas['labels'][] = $fecha;
            $graficoReservas['data'][] = 0;
        }

        // Llenar datos reales
        foreach ($reservasSemanaRaw as $reserva) {
            $fecha = $reserva['fecha']; // Ajusta según tu campo real
            $index = array_search($fecha, $graficoReservas['labels']);
            if ($index !== false) {
                $graficoReservas['data'][$index] = (int) $reserva['total'];
            }
        }

        // --- Preparar JSON final ---
        $data = [
            'indicadores' => [
                'reservasHoy' => $reservasHoy,
                'habitacionesDisponibles' => $habitacionesDisponibles,
                'ingresosMes' => number_format($ingresosMes, 0, ',', '.'),
                'totalClientes' => $totalClientes
            ],
            'graficoReservas' => $graficoReservas,
            'ultimasReservas' => $ultimasReservas
        ];

        error_log("Dashboard::getData() - Enviando JSON con datos completos");
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
        exit;
    }
}