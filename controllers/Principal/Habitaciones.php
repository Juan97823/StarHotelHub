<?php
class Habitaciones extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cargarModel('Habitaciones');
    }

    public function index()
    {
        $data['title'] = 'Habitaciones';
        $data['subtitle'] = 'Habitaciones con estilo';
        $data['style'] = 'habitaciones-page.css';
        $data['habitaciones'] = $this->model->getHabitaciones();

        $this->views->getView('principal/habitacion/index', $data);
    }

    // 🔹 Cambiado de "detalle" a "reservar"
    public function reservar($slug)
    {
        $data['habitacion'] = $this->model->getHabitacionBySlug($slug);

        if (empty($data['habitacion'])) {
            header('Location: ' . RUTA_PRINCIPAL . 'habitaciones');
            exit;
        }

        $data['title'] = 'Reserva: ' . $data['habitacion']['estilo'];
        $data['subtitle'] = 'Confirma tu Reserva';
        $data['style'] = 'reservar-habitacion.css';

        // Pasar fechas del formulario si existen
        $data['checkin'] = $_GET['checkin'] ?? null;
        $data['checkout'] = $_GET['checkout'] ?? null;

        // Cargar vista de reserva
        $this->views->getView('principal/habitacion/reservar', $data);
    }
}
?>
