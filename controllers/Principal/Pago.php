<?php
class Pago extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // Cargamos los modelos que vamos a necesitar
        $this->cargarModel('Reserva');
    }

    /**
     * Muestra la página de pago para una reserva específica.
     * Ahora también gestiona la creación de la factura.
     */
    public function reserva($id_reserva)
    {
        if (!is_numeric($id_reserva)) {
            header("Location: " . RUTA_PRINCIPAL . "cliente/reservas");
            exit;
        }

        // 1. Obtener los detalles de la reserva
        $reserva = $this->model->getReservaById($id_reserva);

        if (empty($reserva) || $reserva['id_usuario'] != $_SESSION['usuario']['id']) {
            // Manejo de error si la reserva no es válida o no pertenece al usuario
            header("Location: " . RUTA_PRINCIPAL . "cliente/reservas");
            exit;
        }

        // 2. Comprobar si ya existe una factura para esta reserva
        $factura = $this->model->getFacturaByReserva($id_reserva);
        if (empty($factura)) {
            // Si no hay factura, la creamos
            $this->model->crearFactura($id_reserva);
            // Y la volvemos a obtener para tener los datos correctos
            $factura = $this->model->getFacturaByReserva($id_reserva);
        }

        // Si la factura ya está pagada, no tiene sentido volver a mostrar la pasarela
        if ($factura['estado'] == 'Pagada') {
            header("Location: " . RUTA_PRINCIPAL . "cliente/reservas?pago=existente");
            exit;
        }
        
        // 3. Obtener los detalles de la habitación
        $habitacion = $this->model->getHabitacion($reserva['id_habitacion']);

        // 4. Preparar todos los datos para la vista
        $data['title'] = 'Realizar Pago';
        $data['reserva'] = $reserva;
        $data['factura'] = $factura;
        $data['habitacion'] = $habitacion;
        
        // Cargar la vista de pago
        $this->views->getView('principal/pago', $data);
    }

    /**
     * Endpoint para capturar la información del pago de PayPal.
     * Se llama mediante fetch() desde el JavaScript de la vista de pago.
     */
    public function capturarPago()
    {
        // Leer el cuerpo de la solicitud (que es un JSON)
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        // Verificar que los datos necesarios están presentes
        if (empty($data) || empty($data['details']) || empty($data['id_reserva'])) {
            echo json_encode(['status' => 'error', 'msg' => 'Datos incompletos']);
            exit;
        }

        $details = $data['details'];
        $id_reserva = $data['id_reserva'];
        $id_transaccion = $details['id']; // ID de la transacción de PayPal

        // Comprobar el estado del pago en PayPal
        if ($details['status'] == 'COMPLETED') {
            // El pago fue exitoso. Actualizamos nuestra base de datos.
            // Aquí llamaremos a un método del modelo para hacer el UPDATE
            $resultado = $this->model->actualizarPago($id_reserva, $id_transaccion);

            if ($resultado) {
                $response = ['status' => 'success', 'msg' => 'Pago completado y registrado.'];
            } else {
                $response = ['status' => 'error', 'msg' => 'Error al actualizar la base de datos.'];
            }
        } else {
            // El pago no se completó en PayPal
            $response = ['status' => 'failed', 'msg' => 'El pago no fue completado.'];
        }

        // Devolver la respuesta como JSON al script de PayPal
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
?>