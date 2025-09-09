<?php
require_once 'models/principal/ReservaModel.php'; // Incluir el modelo

class Cliente extends Controller
{
    private $reservaModel; // Propiedad para el modelo

    public function __construct()
    {
        parent::__construct();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Se verifica que el rol sea de cliente (ID 3)
        if (empty($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 3) {
            header('Location: ' . RUTA_PRINCIPAL . 'login');
            exit;
        }
        $this->reservaModel = new ReservaModel(); // Instanciar el modelo
    }

    public function dashboard()
    {
        $data['title'] = 'Mi Perfil';
        $idUsuario = $_SESSION['usuario']['id'];

        // Obtener datos usando el modelo
        $totalReservas = $this->reservaModel->getCantidadReservas($idUsuario);
        // Usar 1 para 'pendiente' y 2 para 'completada'
        $reservasPendientes = $this->reservaModel->getCantidadReservasByEstado($idUsuario, 1);
        $reservasCompletadas = $this->reservaModel->getCantidadReservasByEstado($idUsuario, 2);
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