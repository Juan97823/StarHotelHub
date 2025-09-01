<?php
class Habitaciones extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = 'Gestión de Habitaciones';
        $data['subtitle'] = 'Administra las habitaciones';
        $this->views->getView('admin/habitaciones/index', $data);
    }

    public function listar()
    {
        // Obtener la lista de habitaciones desde el modelo
        $data = $this->model->getHabitaciones();
        // Devolver los datos en formato JSON para DataTables
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {
        if (isset($_POST['estilo']) && isset($_POST['capacidad'])) {
            $id = $_POST['id'];
            $estilo = $_POST['estilo'];
            $capacidad = $_POST['capacidad'];
            $precio = $_POST['precio'];
            $descripcion = $_POST['descripcion'];
            $servicios = $_POST['servicios'];
            $foto_actual = $_POST['foto_actual'];
            $foto = $_FILES['foto'];

            $nombre_foto = $foto_actual;
            if ($foto['name'] != '') {
                $destino = 'assets/img/habitaciones/';
                $nombre_foto = date('YmdHis') . $foto['name'];
                move_uploaded_file($foto['tmp_name'], $destino . $nombre_foto);
            }

            if (empty($id)) {
                $data = $this->model->registrarHabitacion($estilo, $capacidad, $precio, $descripcion, $servicios, $nombre_foto);
                if ($data > 0) {
                    $res = array('msg' => 'Habitación registrada', 'icono' => 'success');
                } else {
                    $res = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } else {
                $data = $this->model->actualizarHabitacion($estilo, $capacidad, $precio, $descripcion, $servicios, $nombre_foto, $id);
                if ($data > 0) {
                    $res = array('msg' => 'Habitación actualizada', 'icono' => 'success');
                } else {
                    $res = array('msg' => 'Error al actualizar', 'icono' => 'error');
                }
            }
        } else {
            $res = array('msg' => 'Todos los campos son requeridos', 'icono' => 'warning');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar($id)
    {
        $data = $this->model->getHabitacion($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar($id)
    {
        $data = $this->model->eliminarHabitacion($id);
        if ($data == 1) {
            $res = array('msg' => 'Habitación eliminada', 'icono' => 'success');
        } else {
            $res = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>
