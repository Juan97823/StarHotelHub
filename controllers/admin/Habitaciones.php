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
        $this->views->getView('admin/habitaciones/index', $data);
    }

    public function listar()
    {
        $data = $this->model->getHabitaciones();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function crear()
    {
        $data['title'] = 'Nueva Habitación';
        $this->views->getView('admin/habitaciones/crear', $data);
    }

    public function editar($id)
    {
        $data['title'] = 'Editar Habitación';
        $data['habitacion'] = $this->model->getHabitacion($id);
        // Nueva línea: obtenemos también la galería
        $data['galeria'] = $this->model->getGaleria($id);
        if ($data['habitacion']) {
            $this->views->getView('admin/habitaciones/editar', $data);
        } else {
            header('Location: ' . RUTA_PRINCIPAL . 'admin/habitaciones');
        }
    }

    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? null;
            $estilo = $_POST['estilo'];
            $capacidad = $_POST['capacidad'];
            $precio = $_POST['precio'];
            $descripcion = $_POST['descripcion'];
            $servicios = $_POST['servicios'];
            $foto_actual = $_POST['foto_actual'] ?? '';
            $foto = $_FILES['foto'];

            $nombre_foto = $foto_actual;
            if ($foto['name'] != '') {
                $destino = 'assets/img/habitaciones/';
                $nombre_foto = date('YmdHis') . $foto['name'];
                if (move_uploaded_file($foto['tmp_name'], $destino . $nombre_foto)) {
                    // Si la subida es exitosa y había una foto anterior, la eliminamos
                    if (!empty($foto_actual) && file_exists($destino . $foto_actual)) {
                        unlink($destino . $foto_actual);
                    }
                } else {
                    $nombre_foto = $foto_actual;
                }
            }

            if (empty($id)) {
                $this->model->registrarHabitacion($estilo, $capacidad, $precio, $descripcion, $servicios, $nombre_foto);
            } else {
                $this->model->actualizarHabitacion($estilo, $capacidad, $precio, $descripcion, $servicios, $nombre_foto, $id);
            }

            header('Location: ' . RUTA_PRINCIPAL . 'admin/habitaciones');
            exit;
        }
    }

    public function subirFotos()
    {
        if (isset($_POST['id_habitacion']) && !empty($_FILES['imagenes'])) {
            $id_habitacion = $_POST['id_habitacion'];
            $imagenes = $_FILES['imagenes'];
            $destino = 'assets/img/habitaciones/';

            for ($i = 0; $i < count($imagenes['name']); $i++) {
                $nombre_imagen = date('YmdHis') . $i . '_' . $imagenes['name'][$i];
                $tmp_name = $imagenes['tmp_name'][$i];
                
                if (move_uploaded_file($tmp_name, $destino . $nombre_imagen)) {
                    $this->model->insertarImagenGaleria($nombre_imagen, $id_habitacion);
                }
            }
        }
        // Redirigir de vuelta a la página de edición
        header('Location: ' . RUTA_PRINCIPAL . 'admin/habitaciones/editar/' . $id_habitacion);
        exit;
    }

    public function eliminarFoto($id_foto)
    {
        $foto = $this->model->getFoto($id_foto);
        if ($foto) {
            $ruta_foto = 'assets/img/habitaciones/' . $foto['imagen'];
            if (file_exists($ruta_foto)) {
                unlink($ruta_foto);
            }
            $this->model->eliminarFotoGaleria($id_foto);
            $res = array('msg' => 'Imagen eliminada', 'icono' => 'success');
        } else {
            $res = array('msg' => 'Error, la foto no existe', 'icono' => 'error');
        }
         echo json_encode($res, JSON_UNESCAPED_UNICODE);
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