<?php
class Principal extends Controller{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        $data['title'] = 'Página Principal';
        //TRAER SLIDERS
        $data['sliders'] = $this->model->getSliders();
        $this->views->getView('index', $data);
        //TRAER HABITACIONES
        $data['habitaciones'] = $this->model->getHabitaciones();
        $this->views->getView('index', $data);
    }

    public function verify(){
        $f_llegada = strClean($_GET['f_llegada']);
        $f_salida = strClean($_GET['f_salida']);
        $habitacion = strClean($_GET['habitacion']);

        $data = $this->model->getDisponible($f_llegada, $f_salida, $habitacion);
        
        print_r($data);
    }
}
?>