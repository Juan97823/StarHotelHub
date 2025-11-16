<?php
class logout extends Controller
{
    public function __construct()
    {
        // No llamar a parent::__construct() para evitar cargar logoutModel
        require_once 'config/app/Query.php';
        $this->views = new Views();

        // Asegurarse de que la sesión esté iniciada antes de destruirla
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        // Destruir todos los datos de la sesión
        session_destroy();

        // Redirigir a la página de inicio (login)
        header('Location: ' . RUTA_PRINCIPAL);
        exit();
    }
}
?>