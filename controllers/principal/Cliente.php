<?php
require_once 'models/principal/ReservaModel.php'; // Incluir el modelo

class Cliente extends Controller
{
    private $reservaModel; // Propiedad para el modelo

    public function __construct()
    {
        parent::__construct();
        // Se verifica que el rol sea de cliente (ID 3)
        verificarSesion(3);
        $this->reservaModel = new ReservaModel(); // Instanciar el modelo
    }

    public function dashboard()
    {
        $data['title'] = 'Mi Perfil';
        $idUsuario = $_SESSION['usuario']['id'];

        // Obtener datos usando el modelo
        $totalReservas = $this->reservaModel->getCantidadReservas($idUsuario);
        $reservasPendientes = $this->reservaModel->getCantidadReservasByEstado($idUsuario, 'pendiente');
        $reservasCompletadas = $this->reservaModel->getCantidadReservasByEstado($idUsuario, 'completada');
        $listaReservas = $this->reservaModel->getReservasCliente($idUsuario);

        // Pasar datos a la vista
        $data['nombre_usuario'] = $_SESSION['usuario']['nombre'];
        $data['total_reservas'] = $totalReservas['total'] ?? 0;
        $data['reservas_pendientes'] = $reservasPendientes['total'] ?? 0;
        $data['reservas_completadas'] = $reservasCompletadas['total'] ?? 0;
        $data['reservas'] = $listaReservas;

        $this->views->getView('principal/clientes/index', $data);
    }
}
?>