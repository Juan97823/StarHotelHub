<?php 

class detalle_habitacion extends Controller{
    public function __construct(){
        parent::__construct();
        $this->cargarModel('Principal');
    }
    public function index(){
        $data['title'] = 'Detalle Habitación';
        $data['subtitle'] = 'Detalles de la Habitación';
        $this->views->getView('principal/habitacion/detalle', $data);
    }
}      