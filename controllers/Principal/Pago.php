<?php
class Pago extends Controller
{
    public function __construct() {
        parent::__construct();
        $this->cargarModel('ReservaModel');
    }

    // Vista de pago
    public function reserva($id_reserva) {
        $reserva = $this->model->getReservaById($id_reserva);
        if (!$reserva) header("Location: ".RUTA_PRINCIPAL);

        $pago = $this->model->getPagoByReserva($id_reserva);
        if (!$pago) $this->model->crearPagoPendiente($id_reserva);

        $habitacion = $this->model->getHabitacion($reserva['id_habitacion']);

        // Calcular noches y total
        $fechaIngreso = new DateTime($reserva['fecha_ingreso']);
        $fechaSalida = new DateTime($reserva['fecha_salida']);
        $noches = $fechaIngreso->diff($fechaSalida)->days;
        $totalPagar = $noches * $habitacion['precio'];

        $data = [
            'title'=>'Pago en efectivo',
            'reserva'=>$reserva,
            'pago'=>$pago,
            'habitacion'=>$habitacion,
            'total_pagar'=>$totalPagar
        ];
        $this->views->getView('principal/pago',$data);
    }

    // Confirmar que el cliente pagará en efectivo al llegar
    public function confirmarEfectivo($id_reserva) {
        $this->model->actualizarPago($id_reserva, null, 'Efectivo');
        $this->model->actualizarEstadoReserva($id_reserva, 'pendiente_efectivo');
        header("Location: ".RUTA_PRINCIPAL."pago/confirmacion/".$id_reserva);
    }

    // Vista de confirmación
    public function confirmacion($id_reserva) {
        $reserva = $this->model->getReservaById($id_reserva);
        $pago = $this->model->getPagoByReserva($id_reserva);
        $habitacion = $this->model->getHabitacion($reserva['id_habitacion']);
        $data = [
            'title'=>'Confirmación de Reserva',
            'reserva'=>$reserva,
            'pago'=>$pago,
            'habitacion'=>$habitacion
        ];
        $this->views->getView('principal/confirmacion',$data);
    }
}
?>
