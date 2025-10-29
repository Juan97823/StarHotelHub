<?php
class Principal extends Controller{
    public function __construct(){
        parent::__construct();
        $this->cargarModel('Principal');
    }
    public function index(){
        $data['title'] = 'Página Principal';
        //TRAER SLIDERS
        $data['sliders'] = $this->model->getSliders();
        //TRAER HABITACIONES
        $data['habitaciones'] = $this->model->getHabitaciones();
        //TRAER ENTRADAS DEL BLOG
        $data['entradas'] = $this->model->getEntradasRecientes();
        $this->views->getView('index', $data);
    }

    
}
?>