<?php
class Reserva extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function verify()
    {
        if (isset($_GET['f_llegada']) && isset($_GET['f_salida']) && isset($_GET['habitacion'])) {
            $f_llegada = strClean($_GET['f_llegada']);
            $f_salida = strClean($_GET['f_salida']);
            $habitacion = strClean($_GET['habitacion']);

            if (empty($f_llegada) || empty($f_salida) || empty($habitacion)) {
                header('Location:' . RUTA_PRINCIPAL . '?respuesta=warning');
            } else {
                // Obtener reservas de esa habitación
                $reserva = $this->model->getDisponible($f_llegada, $f_salida, $habitacion);

                $data['title'] = 'Reservas';
                $data['subtitle'] = 'Verificar Disponibilidad';
                $data['disponible'] = [
                    'f_llegada' => $f_llegada,
                    'f_salida' => $f_salida,
                    'habitacion' => $habitacion
                ];

                // Evaluar correctamente si hay conflicto
                if (empty($reserva)) {
                    $data['mensaje'] = '✅ La habitación está disponible.';
                    $data['tipo'] = 'success';
                } else {
                    $data['mensaje'] = '❌ La habitación ya tiene una reserva en esas fechas.';
                    $data['tipo'] = 'danger';
                }

                $data['habitaciones'] = $this->model->getHabitaciones();
                $data['habitacion'] = $this->model->getHabitacion($habitacion);
                $this->views->getView('principal/reservas', $data);
            }
        }
    }

    public function listar($parametros)
    {
        $array = explode(',', $parametros);
        $f_llegada = (!empty($array[0])) ? $array[0] : null;
        $f_salida = (!empty($array[1])) ? $array[1] : null;
        $habitacion = (!empty($array[2])) ? $array[2] : null;
        $results = [];

        if ($f_llegada != null && $f_salida != null && $habitacion != null) {
            $reservas = $this->model->getReservasHabitacion($habitacion);

            // Crear arreglo con días ocupados
            $dias_ocupados = [];

            foreach ($reservas as $res) {
                $inicio = new DateTime($res['fecha_ingreso']);
                $fin = new DateTime($res['fecha_salida']);
                $fin->modify('-1 day'); // evitar solapamiento exacto en salida

                while ($inicio <= $fin) {
                    $dias_ocupados[$inicio->format('Y-m-d')] = true;
                    $inicio->modify('+1 day');
                }

                // Agregar evento rojo
                $results[] = [
                    'title' => 'OCUPADO',
                    'start' => $res['fecha_ingreso'],
                    'end' => $res['fecha_salida'],
                    'color' => '#ff0000',
                ];
            }

            // Generar días disponibles dentro del rango
            $inicio = new DateTime($f_llegada);
            $fin = new DateTime($f_salida);
            $fin->modify('-1 day'); // para evitar incluir salida

            while ($inicio <= $fin) {
                $fecha = $inicio->format('Y-m-d');
                if (!isset($dias_ocupados[$fecha])) {
                    $results[] = [
                        'title' => 'DISPONIBLE',
                        'start' => $fecha,
                        'end' => (new DateTime($fecha))->modify('+1 day')->format('Y-m-d'),
                        'color' => '#00cc66',
                    ];
                }
                $inicio->modify('+1 day');
            }

            header('Content-Type: application/json');
            echo json_encode($results, JSON_UNESCAPED_UNICODE);
        }

        die();
    }
}
