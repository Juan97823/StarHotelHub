<?php
class Reservas extends Controller
{
    public function __construct()
    {
        parent::__construct();
        verificarSesion(1); // Asegura que solo administradores accedan
        $this->cargarModel('admin/ReservasModel');
    }

    
    public function index()
    {
        $data['title'] = 'Reservas';
        $this->views->getView('admin/reservas', $data);
    }

    // Método para listar las reservas
    public function listar()
    {
        $data = $this->model->getReservas();

        // Bucle para formatear la salida
        for ($i = 0; $i < count($data); $i++) {
            
            // FORMATEO DEL ESTADO
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Completado</span>';
            } else {
                $data[$i]['estado'] = '<span class="badge bg-warning">Pendiente</span>';
            }

            // FORMATEO DE LAS ACCIONES
            $idReserva = $data[$i]['id'];
            $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary btn-sm" onclick="btnEditarReserva('.$idReserva.')" title="Editar"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger btn-sm" onclick="btnEliminarReserva('.$idReserva.')" title="Eliminar"><i class="fas fa-trash"></i></button>
            </div>';
        }

        // Devolver los datos formateados en JSON
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    // ===== INICIO DEL NUEVO MÉTODO =====
    // Método para eliminar una reserva
    public function eliminar($id)
    {
        // Se asegura de que el ID sea un número entero
        $idReserva = intval($id);
        if ($idReserva > 0) {
            // Llama a un futuro método 'deleteReserva' en el modelo
            $resultado = $this->model->deleteReserva($idReserva);
            if ($resultado == 1) { // El modelo debería devolver 1 si la eliminación fue exitosa
                $respuesta = ['msg' => 'ok'];
            } else {
                $respuesta = ['msg' => 'Error: No se pudo eliminar la reserva en la base de datos.'];
            }
        } else {
            $respuesta = ['msg' => 'Error: ID de reserva no válido.'];
        }
        // Envía la respuesta de vuelta al JavaScript
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        die();
    }
    // ===== FIN DEL NUEVO MÉTODO =====
}
?>