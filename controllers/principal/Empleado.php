<?php
class Empleado extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // Se verifica que el rol sea de empleado (ID 2)
        verificarSesion(2);
    }

    public function dashboard()
    {
        $data['title'] = 'Panel de Empleado';
        $data['nombre_usuario'] = $_SESSION['usuario']['nombre'];
        $this->views->getView('principal/empleado/dashboard', $data);
    }
}
?>