<?php
require_once 'helpers/seguridad.php';

class Dashboard extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        verificarSesion('Administrador'); // ✅ Solo admins acceden

        $data['title'] = 'Panel de Administrador';
        $this->views->getView('admin/dashboard', $data);
    }

    public function salir()
    {
        session_start();
        session_destroy();
        redirect(RUTA_PRINCIPAL . 'login');
    }
}
