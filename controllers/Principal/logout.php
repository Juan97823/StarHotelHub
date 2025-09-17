<?php
class Logout extends Controller
{
    public function __construct()
    {
        parent::__construct();
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