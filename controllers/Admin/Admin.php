<?php
require_once 'helpers/seguridad.php';

class Admin extends Controller
{
    public function __construct()
    {
        // No llamar a parent::__construct() para evitar cargar AdminModel
        require_once 'config/app/Query.php';
        $this->views = new Views();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Validar acceso solo para administradores
        $url = $_SERVER['REQUEST_URI'];
        if (strpos($url, 'admin/login') === false) {
            if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 1) {
                header('Location: ' . RUTA_PRINCIPAL . 'login');
                exit;
            }
        }
    }

    /**
     * Vista principal del dashboard
     */
    public function dashboard()
    {
        $data['title'] = 'Panel de Administrador';
        $data['nombre_usuario'] = $_SESSION['usuario']['nombre'] ?? 'Administrador';
        $this->views->getView('admin/dashboard', $data);
    }

    /**
     * Cerrar sesión
     */
    public function salir()
    {
        session_unset();
        session_destroy();
        session_regenerate_id(true);
        header('Location: ' . RUTA_PRINCIPAL . 'login');
        exit;
    }
}
