<?php
class Contacto extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cargarModel('Contacto', 'admin');
    }

    // Mostrar vista de mensajes
    public function index()
    {
        $data['title'] = 'Mensajes de Contacto';
        $this->views->getView('admin/contacto/index', $data);
    }

    // Listar mensajes en JSON para DataTables
    public function listarMensajes()
    {
        header('Content-Type: application/json; charset=utf-8');
        $data = $this->model->getMensajes();
        echo json_encode(['data' => $data], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Ver mensaje específico
    public function verMensaje($id)
    {
        header('Content-Type: application/json; charset=utf-8');
        $mensaje = $this->model->getMensaje($id);
        if ($mensaje) {
            echo json_encode(['status' => 'success', 'mensaje' => $mensaje], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['status' => 'error', 'mensaje' => 'Mensaje no encontrado']);
        }
        exit;
    }

    // Cambiar estado del mensaje (leído/no leído)
    public function cambiarEstado($param)
    {
        header('Content-Type: application/json; charset=utf-8');
        $parts = explode(",", $param);
        $id = $parts[0] ?? null;
        $nuevoEstado = $parts[1] ?? null;

        if ($id && ($nuevoEstado == 1 || $nuevoEstado == 2)) {
            $result = $this->model->cambiarEstado($nuevoEstado, $id);
            if ($result) {
                echo json_encode(['status' => 'success', 'mensaje' => 'Estado actualizado']);
            } else {
                echo json_encode(['status' => 'error', 'mensaje' => 'No se pudo actualizar']);
            }
        } else {
            echo json_encode(['status' => 'error', 'mensaje' => 'Parámetros no válidos']);
        }
        exit;
    }

    // Eliminar mensaje
    public function eliminarMensaje($id)
    {
        header('Content-Type: application/json; charset=utf-8');
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $result = $this->model->eliminarMensaje($id);
            if ($result) {
                echo json_encode(['status' => 'success', 'mensaje' => 'Mensaje eliminado']);
            } else {
                echo json_encode(['status' => 'error', 'mensaje' => 'No se pudo eliminar']);
            }
        }
        exit;
    }
}

