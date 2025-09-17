<?php
class Habitaciones extends Controller {
    public function __construct() {
        parent::__construct();
        // Cargar correctamente el modelo HabitacionesModel
        $this->cargarModel('Habitaciones');
    }

    public function index() {
        $data['title'] = 'Habitaciones';
        $data['subtitle'] = 'Habitaciones con estilo';
        $data['style'] = 'habitaciones-page.css'; // Hoja de estilos personalizada
        $data['habitaciones'] = $this->model->getHabitaciones();

        $this->views->getView('principal/habitacion/index', $data);
    }

    public function detalle($slug) {
        $data['habitacion'] = $this->model->getHabitacionBySlug($slug);

        if (empty($data['habitacion'])) {
            header('Location: ' . RUTA_PRINCIPAL . 'habitaciones');
            exit;
        }

        $data['title'] = $data['habitacion']['estilo'];
        $data['subtitle'] = 'Detalles de la Habitación';
        $data['style'] = 'detalle-habitacion.css'; // Hoja de estilos para la página de detalles
        $this->views->getView('principal/habitacion/detalle', $data);
    }
}
?>
