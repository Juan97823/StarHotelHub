<?php
require_once 'helpers/seguridad.php';

class Habitaciones extends Controller
{
    public function __construct()
    {
        parent::__construct();
        verificarSesion(1); // Solo administradores
        $this->cargarModel('Habitaciones');
    }

    public function index()
    {
        $data['title'] = 'Gestión de Habitaciones';
        $this->views->getView('admin/habitaciones/index', $data);
    }

    public function listar()
    {
        error_log("Habitaciones::listar() - Iniciando");

        if (!$this->model) {
            error_log("ERROR Habitaciones::listar() - Model no esta cargado");
            echo json_encode(['error' => 'Model no cargado'], JSON_UNESCAPED_UNICODE);
            die();
        }

        try {
            $data = $this->model->getHabitaciones(false);
            error_log("Habitaciones::listar() - Obtenidas " . count($data) . " habitaciones");
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            error_log("ERROR Habitaciones::listar() - Error: " . $e->getMessage());
            echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function crear()
    {
        $data['title'] = 'Nueva Habitación';
        $this->views->getView('admin/habitaciones/crear', $data);
    }

    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("=== GUARDAR HABITACIÓN ===");
            error_log("POST data: " . print_r($_POST, true));
            error_log("FILES data: " . print_r($_FILES, true));

            // Convertir string vacío a null para el ID
            $id          = !empty($_POST['id']) ? $_POST['id'] : null;
            $estilo      = $_POST['estilo'] ?? '';
            $numero      = $_POST['numero'] ?? 0;
            $capacidad   = $_POST['capacidad'] ?? 1;
            $precio      = $_POST['precio'] ?? 0.00;
            $descripcion = $_POST['descripcion'] ?? '';
            $servicios   = $_POST['servicios'] ?? '';
            $foto_actual = $_POST['foto_actual'] ?? '';
            $foto        = $_FILES['foto'] ?? null;

            error_log("ID: " . ($id ?? 'NULL') . ", Estilo: $estilo, Numero: $numero, Capacidad: $capacidad, Precio: $precio");

            $nombre_foto = $foto_actual;
            if ($foto && $foto['name'] !== '') {
                $destino = 'assets/img/habitaciones/';
                if (!file_exists($destino)) {
                    mkdir($destino, 0777, true);
                }
                $nombre_foto = date('YmdHis') . '_' . basename($foto['name']);
                error_log("Intentando subir foto: $nombre_foto");
                if (move_uploaded_file($foto['tmp_name'], $destino . $nombre_foto)) {
                    error_log("Foto subida exitosamente");
                    if (!empty($foto_actual) && file_exists($destino . $foto_actual)) {
                        unlink($destino . $foto_actual);
                    }
                } else {
                    error_log("Error al subir foto");
                    $nombre_foto = $foto_actual;
                }
            }

            try {
                if (is_null($id)) {
                    error_log("Registrando nueva habitación...");
                    $resultado = $this->model->registrarHabitacion($estilo, $numero, $capacidad, $precio, $descripcion, $servicios, $nombre_foto);
                    error_log("Resultado de registrarHabitacion: " . print_r($resultado, true));
                    $mensaje = ['tipo' => 'success', 'mensaje' => 'Habitación registrada con éxito.'];
                } else {
                    error_log("Actualizando habitación ID: $id");
                    $resultado = $this->model->actualizarHabitacion($estilo, $numero, $capacidad, $precio, $descripcion, $servicios, $nombre_foto, $id);
                    error_log("Resultado de actualizarHabitacion: " . print_r($resultado, true));
                    $mensaje = ['tipo' => 'success', 'mensaje' => 'Habitación actualizada con éxito.'];
                }
            } catch (Exception $e) {
                error_log("ERROR al guardar habitación: " . $e->getMessage());
                $mensaje = ['tipo' => 'error', 'mensaje' => 'Error al guardar: ' . $e->getMessage()];
            }

            $_SESSION['alerta'] = $mensaje;
            header('Location: ' . RUTA_PRINCIPAL . 'admin/habitaciones');
            exit;
        }
    }

    public function editar($id)
    {
        $data['title']      = 'Editar Habitación';
        $data['habitacion'] = $this->model->getHabitacion($id);
        $data['galeria']    = $this->model->getGaleria($id, false);

        if ($data['habitacion']) {
            $this->views->getView('admin/habitaciones/editar', $data);
        } else {
            header('Location: ' . RUTA_PRINCIPAL . 'admin/habitaciones');
            exit;
        }
    }

    public function eliminar($id)
    {
        $data = $this->model->inhabilitarHabitacion($id);
        $res  = $data >= 1
            ? ['msg' => 'Habitación dada de baja', 'icono' => 'success']
            : ['msg' => 'Error al dar de baja', 'icono' => 'error'];
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresar($id)
    {
        $data = $this->model->reingresarHabitacion($id);
        $res  = $data >= 1
            ? ['msg' => 'Habitación reingresada', 'icono' => 'success']
            : ['msg' => 'Error al reingresar', 'icono' => 'error'];
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    // --- GALERÍA ---

    public function subirFotos()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_habitacion = $_POST['id_habitacion'];
            $imagenes      = $_FILES['imagenes'];
            $destino       = 'assets/img/habitaciones/';

            foreach ($imagenes['tmp_name'] as $key => $tmp_name) {
                if (!empty($tmp_name)) {
                    $nombre_imagen = date('YmdHis') . '_' . basename($imagenes['name'][$key]);
                    if (move_uploaded_file($tmp_name, $destino . $nombre_imagen)) {
                        $this->model->insertarImagenGaleria($nombre_imagen, $id_habitacion);
                    }
                }
            }

            $_SESSION['alerta'] = ['tipo' => 'success', 'mensaje' => 'Imágenes añadidas a la galería.'];
            header('Location: ' . RUTA_PRINCIPAL . 'admin/habitaciones/editar/' . $id_habitacion);
            exit;
        }
    }

    public function eliminarFoto($id_foto)
    {
        $foto = $this->model->getFoto($id_foto);
        if ($foto) {
            $data = $this->model->inhabilitarFotoGaleria($id_foto);
            if ($data >= 1) {
                $ruta = 'assets/img/habitaciones/' . $foto['nombre'];
                if (file_exists($ruta)) {
                    unlink($ruta);
                }
                $res = ['msg' => 'Foto eliminada de la galería', 'icono' => 'success'];
            } else {
                $res = ['msg' => 'Error al eliminar la foto', 'icono' => 'error'];
            }
        } else {
            $res = ['msg' => 'La foto no existe', 'icono' => 'error'];
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresarFoto($id)
    {
        $data = $this->model->reingresarFotoGaleria($id);
        $res  = $data >= 1
            ? ['msg' => 'Foto reingresada', 'icono' => 'success']
            : ['msg' => 'Error al reingresar la foto', 'icono' => 'error'];
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}
