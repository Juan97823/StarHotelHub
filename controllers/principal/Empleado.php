<?php
class Empleado extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function dashboard()
    {
        session_start();
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'Empleado') {
            redirect(RUTA_PRINCIPAL . 'login');
            exit;
        }

        $data['title'] = 'Panel del Empleado';
        $this->views->getView('principal/empleado/dashboard', $data);
    }
}
