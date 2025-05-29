<?php
class Reserva extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function verify()
    {
        $data['title'] = 'Reservas';
        $data['subtitle'] = 'Verificar Disponibilidad';
        $this->views->getView('principal/reservas', $data);
    }
}
