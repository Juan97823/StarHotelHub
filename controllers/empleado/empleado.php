<?php

class Empleado extends Controller
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 2) {
            header('Location: ' . RUTA_PRINCIPAL . 'login');
            exit;
        }

        parent::__construct();
    }

    public function dashboard()
    {
        $data['title'] = 'Panel de Empleado';
        $data['nombre_usuario'] = $_SESSION['usuario']['nombre'];
        $this->views->getView('empleado/dashboard', $data);
    }
}
