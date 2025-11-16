<?php
require_once 'helpers/seguridad.php';

class Perfil extends Controller
{
    public function __construct()
    {
        session_start();
        verificarSesion(1);
        $this->cargarModel('UsuariosModel');
    }

    public function index()
    {
        $idUsuario = $_SESSION['usuario']['id'] ?? 0;
        $usuario = $this->model->getUsuarioPorId($idUsuario);
        $data['title'] = 'Mi Perfil';
        $data['usuario'] = $usuario;
        $this->views->getView('admin/Perfil/Index', $data);
    }

    public function editar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idUsuario = $_SESSION['usuario']['id'] ?? 0;
            $nombre = trim($_POST['nombre'] ?? '');
            $correo = trim($_POST['correo'] ?? '');

            if (empty($nombre) || empty($correo) || $idUsuario == 0) {
                $response = ['tipo' => 'error', 'msg' => 'Todos los campos son requeridos.'];
            } else {
                $resultado = $this->model->actualizarPerfil($idUsuario, $nombre, $correo);

                if ($resultado === 'existe') {
                    $response = ['tipo' => 'error', 'msg' => 'El correo electrónico ya está en uso.'];
                } elseif ($resultado) {
                    $_SESSION['usuario']['nombre'] = $nombre;
                    $response = ['tipo' => 'success', 'msg' => 'Perfil actualizado con éxito.'];
                } else {
                    $response = ['tipo' => 'error', 'msg' => 'No se pudo actualizar el perfil.'];
                }
            }
        } else {
            $response = ['tipo' => 'error', 'msg' => 'Método no permitido.'];
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function cambiarClave()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idUsuario = $_SESSION['usuario']['id'] ?? 0;
            $claveActual = trim($_POST['current_clave'] ?? '');
            $nuevaClave = trim($_POST['clave'] ?? '');

            if (empty($claveActual) || empty($nuevaClave) || $idUsuario == 0) {
                $response = ['tipo' => 'error', 'msg' => 'Todos los campos son requeridos.'];
                echo json_encode($response, JSON_UNESCAPED_UNICODE);
                die();
            }

            $hashClaveActual = $this->model->getClaveActual($idUsuario);

            if ($hashClaveActual && password_verify($claveActual, $hashClaveActual)) {
                $resultado = $this->model->actualizarClave($idUsuario, $nuevaClave);
                if ($resultado) {
                    $response = ['tipo' => 'success', 'msg' => 'Contraseña actualizada con éxito.'];
                } else {
                    $response = ['tipo' => 'error', 'msg' => 'No se pudo actualizar la contraseña.'];
                }
            } else {
                $response = ['tipo' => 'error', 'msg' => 'La contraseña actual es incorrecta.'];
            }
        } else {
            $response = ['tipo' => 'error', 'msg' => 'Método no permitido.'];
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }
}
