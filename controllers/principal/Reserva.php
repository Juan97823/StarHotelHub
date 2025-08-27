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
                $reserva = $this->model->getDisponible($f_llegada, $f_salida, $habitacion);
                $data['title'] = 'Reservas';
                $data['subtitle'] = 'Verificar Disponibilidad';
                $data['disponible'] = [
                    'f_llegada' => $f_llegada,
                    'f_salida' => $f_salida,
                    'habitacion' => $habitacion
                ];
                if (empty($reserva)) {
                    $data['mensaje'] = 'La habitacion esta disponible';
                    $data['tipo'] = 'success';
                } else {
                    $data['mensaje'] = 'La habitacion no esta disponible';
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
            // OBTENER RESERVAS DE LA HABITACIÓN
            $reservas = $this->model->getReservasHabitacion($habitacion);

            foreach ($reservas as $reserva) {
                $results[] = [
                    'id' => $reserva['id'],
                    'title' => 'OCUPADO',
                    'start' => $reserva['fecha_ingreso'],
                    'end' => $reserva['fecha_salida'],
                    'color' => '#ff0000'
                ];
            }

            // RANGO DE FECHAS SELECCIONADO
            $results[] = [
                'id' => 'seleccion',
                'title' => 'COMPROBANDO',
                'start' => $f_llegada,
                'end' => $f_salida,
                'color' => '#00ff00'
            ];

            header('Content-Type: application/json');
            echo json_encode($results, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function pendiente(){
         $data['title'] = 'Reserva Pendiente';
        $this->views->getView('principal/clientes/reservas/pendiente', $data);
        $this->views->getView('admin/reservas/pendiente', $data);
    }
}
