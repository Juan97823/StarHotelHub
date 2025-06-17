<?php
class Registro extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $data['title'] = 'Registro'; 
        $data['subtitle'] = 'Regístrate en nuestra plataforma'; 

        $this->views->getView('principal/Registro', $data);

    }
    public function crear(){
        print_r($_POST);
    }
}
