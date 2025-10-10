<?php
class Pago extends Controller
{
    public function __construct() {
        parent::__construct();
        $this->cargarModel('ReservaModel');
    }

    public function reserva($id_reserva) {
        $reserva = $this->model->getReservaById($id_reserva);
        if (!$reserva) header("Location: ".RUTA_PRINCIPAL);

        $pago = $this->model->getPagoByReserva($id_reserva);
        if (!$pago) $this->model->crearPagoPendiente($id_reserva);

        $habitacion = $this->model->getHabitacion($reserva['id_habitacion']);
        $data = [
            'title'=>'Realizar Pago',
            'reserva'=>$reserva,
            'pago'=>$pago,
            'habitacion'=>$habitacion
        ];
        $this->views->getView('principal/pago',$data);
    }

    public function capturarPago() {
        $json = file_get_contents('php://input');
        $data = json_decode($json,true);
        if (!$data || !$data['details'] || !$data['id_reserva']) exit(json_encode(['status'=>'error']));

        $details = $data['details'];
        $id_reserva = $data['id_reserva'];
        $id_transaccion = $details['id'];

        if ($details['status']==='COMPLETED') {
            $this->model->actualizarPago($id_reserva,$id_transaccion);
            echo json_encode(['status'=>'success','redirect'=>RUTA_PRINCIPAL."pago/confirmacion/".$id_reserva]);
        } else {
            echo json_encode(['status'=>'failed','msg'=>'Pago no completado']);
        }
        exit;
    }

    public function confirmacion($id_reserva) {
        $reserva = $this->model->getReservaById($id_reserva);
        $pago = $this->model->getPagoByReserva($id_reserva);
        $habitacion = $this->model->getHabitacion($reserva['id_habitacion']);
        $data = [
            'title'=>'Confirmación de Pago',
            'reserva'=>$reserva,
            'pago'=>$pago,
            'habitacion'=>$habitacion
        ];
        $this->views->getView('principal/confirmacion',$data);
    }
}
?>
