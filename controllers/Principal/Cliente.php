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
        $reservasPendientes = $this->reservaModel->getCantidadReservasByEstado($idUsuario, 1); // 1 para pendiente
        $reservasCompletadas = $this->reservaModel->getCantidadReservasByEstado($idUsuario, 2); // 2 para completada
        $listaReservas = $this->reservaModel->getReservasCliente($idUsuario);

        // Pasar datos a la vista
        $data['nombre_usuario'] = $_SESSION['usuario']['nombre'];
        $data['total_reservas'] = $totalReservas['total'] ?? 0;
        $data['reservas_pendientes'] = $reservasPendientes['total'] ?? 0;
        $data['reservas_completadas'] = $reservasCompletadas['total'] ?? 0;
        $data['reservas'] = $listaReservas;

        $this->views->getView('principal/clientes/index', $data);
    }

    public function reservas()
    {
        $data['title'] = 'Gestionar Mis Reservas';
        $idUsuario = $_SESSION['usuario']['id'];
        
        // Obtener todas las reservas del cliente
        $listaReservas = $this->reservaModel->getReservasCliente($idUsuario);
        $data['reservas'] = $listaReservas;

        // Cargar la nueva vista de gestión de reservas
        $this->views->getView('principal/clientes/Reservas', $data);
    }

    public function cancelar($idReserva)
    {
        $reserva = $this->reservaModel->getReservaById($idReserva);

        if (!$reserva || $reserva['id_usuario'] != $_SESSION['usuario']['id']) {
            echo json_encode(['estado' => false, 'msg' => 'No tienes permiso para cancelar esta reserva.']);
            exit;
        }

        if ($reserva['estado'] != 1) { // 1 = pendiente
            echo json_encode(['estado' => false, 'msg' => 'Solo puedes cancelar reservas pendientes.']);
            exit;
        }

        $result = $this->reservaModel->cancelarReserva($idReserva);

        if ($result) {
            echo json_encode(['estado' => true, 'msg' => 'Reserva cancelada con éxito.']);
        } else {
            echo json_encode(['estado' => false, 'msg' => 'Error al cancelar la reserva.']);
        }
    }
}
?>