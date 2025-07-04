<?php
class Admin extends Controller
{
    public function __construct()
    {
        session_start(); // Necesario si no lo has iniciado en el index
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
            header('Location: ' . RUTA_PRINCIPAL . 'login');
            exit;
        }
        parent::__construct();
    }

    public function dashboard()
    {
        $data['title'] = 'Panel de Administrador';
        $data['nombre_usuario'] = $_SESSION['nombre'];
        $this->views->getView('admin/dashboard', $data);
    }
}
