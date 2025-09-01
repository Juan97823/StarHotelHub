<?php
class Dashboard extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Proteger la ruta del dashboard
        if (empty($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 3) { 
            header('Location: ' . RUTA_PRINCIPAL . 'login');
            exit;
        }
    }

    public function index()
    {
        $data['title'] = 'Tu Perfil';
        $this->views->getView('principal/dashboard', $data);
    }
}
?>