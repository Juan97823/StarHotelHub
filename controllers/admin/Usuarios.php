<?php
class Usuarios extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = 'Gestión de usuarios';
        $data['usuarios'] = $this->model->getUsuarios();
        $this->views->getView('admin/usuarios/index', $data);
    }

    public function obtener($id)
    {
        $usuario = $this->model->getUsuarioPorId($id);
        if ($usuario) {
            echo json_encode($usuario);
        } else {
            echo json_encode(['tipo' => 'error', 'msg' => 'No se encontró el usuario.']);
        }
        die();
    }

    public function registrar()
    {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $clave = $_POST['clave'];
        $rolNombre = $_POST['rol'];

        if (empty($nombre) || empty($email) || empty($clave) || empty($rolNombre)) {
            $response = ['tipo' => 'error', 'msg' => 'Todos los campos son obligatorios.'];
        } else {
            $rolId = $this->model->getRolIdPorNombre($rolNombre);
            if (!$rolId) {
                $response = ['tipo' => 'error', 'msg' => 'El rol especificado no es válido.'];
            } else {
                $id = $this->model->registrarUsuario($nombre, $email, $clave, $rolId);
                if ($id) {
                    $response = ['tipo' => 'success', 'msg' => 'Usuario registrado con éxito.', 'id' => $id];
                } else {
                    $response = ['tipo' => 'error', 'msg' => 'Error al registrar el usuario.'];
                }
            }
        }
        echo json_encode($response);
        die();
    }

    public function editar($id)
    {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $rolNombre = $_POST['rol'];
        $clave = $_POST['clave'] ?? null;

        if (empty($nombre) || empty($email) || empty($rolNombre)) {
            $response = ['tipo' => 'error', 'msg' => 'Todos los campos, excepto la contraseña, son obligatorios.'];
        } else {
            $rolId = $this->model->getRolIdPorNombre($rolNombre);
            if (!$rolId) {
                $response = ['tipo' => 'error', 'msg' => 'El rol especificado no es válido.'];
            } else {
                if ($this->model->actualizarUsuario($id, $nombre, $email, $rolId, $clave)) {
                    $response = ['tipo' => 'success', 'msg' => 'Usuario actualizado con éxito.'];
                } else {
                    $response = ['tipo' => 'error', 'msg' => 'Error al actualizar el usuario.'];
                }
            }
        }
        echo json_encode($response);
        die();
    }

    public function cambiarEstado($id, $estado)
    {
        $nuevoEstado = intval($estado);
        if ($this->model->cambiarEstadoUsuario($id, $nuevoEstado)) {
            $mensaje = ($nuevoEstado == 1) ? 'Usuario habilitado correctamente.' : 'Usuario inhabilitado correctamente.';
            echo json_encode(['tipo' => 'success', 'msg' => $mensaje]);
        } else {
            echo json_encode(['tipo' => 'error', 'msg' => 'Error al cambiar el estado del usuario.']);
        }
        die();
    }
}
?>
