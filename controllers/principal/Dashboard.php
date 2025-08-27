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
        session_start();
        if (!isset($_SESSION['usuario'])) {
            // Redirige si no hay sesión activa
            redirect(RUTA_PRINCIPAL . 'login');
            exit;
        }

        // Validar el rol (por ejemplo, solo clientes pueden entrar aquí)
        if ($_SESSION['usuario']['rol'] !== 'Cliente') {
            // Redirigir a un dashboard distinto o mostrar error
            redirect(RUTA_PRINCIPAL . 'login'); // o puedes mostrar 403
            exit;
        }

        $data['title'] = 'Perfil Cliente';
        $this->views->getView('principal/clientes/index', $data);
    }

    public function salir()
    {
        session_start(); // Asegúrate de iniciar sesión antes de destruirla
        session_destroy();
        redirect(RUTA_PRINCIPAL . 'login');
    }
}
