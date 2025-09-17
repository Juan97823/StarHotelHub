<?php

class Usuarios extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        $data['title'] = 'Gestión de usuarios';
        $this->views->getView('admin/usuarios/index', $data);
    }

    public function listar()
    {
        $usuarios = $this->model->getUsuarios();
        if (!is_array($usuarios)) {
            $usuarios = [];
        }

        $data = [];
        foreach ($usuarios as $usuario) {
            $rol_badge = '';
            if ($usuario['rol'] == 'Administrador') {
                $rol_badge = '<span class="badge bg-primary">Administrador</span>';
            } elseif ($usuario['rol'] == 'Empleado') {
                $rol_badge = '<span class="badge bg-info">Empleado</span>';
            } else {
                $rol_badge = '<span class="badge bg-secondary">Cliente</span>';
            }

            $estado_badge = $usuario['estado'] == 1
                ? '<span class="badge bg-success">Activo</span>'
                : '<span class="badge bg-danger">Inactivo</span>';

            $acciones = '<div class="d-flex justify-content-center">' .
                '<button class="btn btn-sm btn-outline-primary me-1" data-action="edit" data-id="' . $usuario['id'] . '" title="Editar"><i class="fas fa-edit"></i></button>';

            if ($usuario['estado'] == 1) {
                $acciones .= '<button class="btn btn-sm btn-danger" data-action="toggle-state" data-id="' . $usuario['id'] . '" title="Inhabilitar"><i class="fas fa-ban"></i></button>';
            } else {
                $acciones .= '<button class="btn btn-sm btn-success" data-action="toggle-state" data-id="' . $usuario['id'] . '" title="Habilitar"><i class="fas fa-check"></i></button>';
            }
            $acciones .= '</div>';

            $data[] = [
                'id' => $usuario['id'],
                'nombre' => $usuario['nombre'],
                'email' => $usuario['correo'],
                'rol' => $rol_badge,
                'estado' => $estado_badge,
                'acciones' => $acciones
            ];
        }

        header('Content-Type: application/json');
        echo json_encode(["data" => $data], JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $clave = $_POST['clave'];
            $rolNombre = filter_var($_POST['rol'], FILTER_SANITIZE_STRING);

            if (empty($nombre) || !$email || empty($rolNombre) || empty($clave)) {
                $response = ['tipo' => 'error', 'msg' => 'Todos los campos son obligatorios.'];
            } else {
                $rolId = $this->model->getRolIdPorNombre($rolNombre);
                if (!$rolId) {
                    $response = ['tipo' => 'error', 'msg' => 'El rol especificado no es válido.'];
                } else {
                    $resultado = $this->model->registrarUsuario($nombre, $email, $clave, $rolId);
                    if ($resultado > 0) {
                        $response = ['tipo' => 'success', 'msg' => 'Usuario registrado con éxito.'];
                    } elseif ($resultado == "existe") {
                        $response = ['tipo' => 'error', 'msg' => 'El correo ya está registrado.'];
                    } else {
                        $response = ['tipo' => 'error', 'msg' => 'Error al registrar el usuario.'];
                    }
                }
            }
        } else {
            $response = ['tipo' => 'error', 'msg' => 'Método no permitido.'];
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = intval($id);
            $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $rolNombre = filter_var($_POST['rol'], FILTER_SANITIZE_STRING);
            $clave = $_POST['clave'];

            if (empty($nombre) || !$email || empty($rolNombre)) {
                $response = ['tipo' => 'error', 'msg' => 'Todos los campos son obligatorios (excepto contraseña).'];
            } else {
                $rolId = $this->model->getRolIdPorNombre($rolNombre);
                if (!$rolId) {
                    $response = ['tipo' => 'error', 'msg' => 'El rol especificado no es válido.'];
                } else {
                    $resultado = $this->model->actualizarUsuario($id, $nombre, $email, $rolId, $clave);
                    if ($resultado > 0) {
                        $response = ['tipo' => 'success', 'msg' => 'Usuario actualizado con éxito.'];
                    } elseif ($resultado == "existe") {
                        $response = ['tipo' => 'error', 'msg' => 'El correo ya pertenece a otro usuario.'];
                    } else {
                        $response = ['tipo' => 'error', 'msg' => 'Error al actualizar el usuario.'];
                    }
                }
            }
        } else {
            $response = ['tipo' => 'error', 'msg' => 'Método no permitido.'];
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function obtener($id)
    {
        $usuario = $this->model->getUsuarioPorId(intval($id));
        if ($usuario) {
            $response = [
                'id' => $usuario['id'],
                'nombre' => $usuario['nombre'],
                'email' => $usuario['correo'],
                'rol' => $usuario['rol']
            ];
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['tipo' => 'error', 'msg' => 'No se encontró el usuario.']);
        }
        die();
    }

    public function cambiarEstado($id, $estado)
    {
        $idUsuario = intval($id);
        $nuevoEstado = intval($estado);

        if ($idUsuario == 0) {
            echo json_encode(['tipo' => 'error', 'msg' => 'ID de usuario no válido.']);
            die();
        }

        if (isset($_SESSION['usuario']['id']) && $idUsuario == $_SESSION['usuario']['id'] && $nuevoEstado == 0) {
            echo json_encode(['tipo' => 'error', 'msg' => 'No puedes inhabilitar a tu propio usuario.']);
            die();
        }

        $usuario = $this->model->getUsuarioPorId($idUsuario);
        if ($usuario && isset($usuario['rol_id']) && $usuario['rol_id'] == 4 && $nuevoEstado == 0) {
            echo json_encode(['tipo' => 'error', 'msg' => 'No se puede inhabilitar a un usuario con este rol.']);
            die();
        }

        // *** CORREGIDO: Usar una comprobación robusta (> 0) ***
        $resultado = $this->model->cambiarEstadoUsuario($idUsuario, $nuevoEstado);

        if ($resultado) {
            $mensaje = ($nuevoEstado == 1)
                ? 'Usuario habilitado correctamente.'
                : 'Usuario inhabilitado correctamente.';
            echo json_encode(['tipo' => 'success', 'msg' => $mensaje]);
        } else {
            echo json_encode(['tipo' => 'error', 'msg' => 'Error al cambiar el estado del usuario.']);
        }
        die();
    }
}
?>
