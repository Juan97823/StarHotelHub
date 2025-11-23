<?php
require_once 'models/principal/RegistroModel.php';

class Perfil extends Controller
{
    private $registroModel;

    public function __construct()
    {
        parent::__construct();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 3) { // Rol 3 = Cliente
            header('Location: ' . RUTA_PRINCIPAL . 'login');
            exit;
        }
        $this->cargarModel('Registro');
        $this->registroModel = new RegistroModel();
    }

    public function index()
    {
        $data['title'] = 'Mi Perfil';
        $data['usuario'] = $this->registroModel->getUsuarioById($_SESSION['usuario']['id']);
        $this->views->getView('principal/clientes/perfil', $data);
    }

    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION['usuario']['id'];
            $nombre = strClean($_POST['nombre'] ?? '');
            $correo = strClean($_POST['correo'] ?? '');
            $password_actual = $_POST['password_actual'] ?? '';
            $password_nueva = $_POST['password_nueva'] ?? '';
            $confirmar_password = $_POST['confirmar_password'] ?? '';

            if (empty($nombre) || empty($correo) || empty($password_actual)) {
                $_SESSION['alerta'] = ['tipo' => 'danger', 'mensaje' => 'Todos los campos marcados con * son obligatorios.'];
                header('Location: ' . RUTA_PRINCIPAL . 'perfil');
                exit;
            }

            $usuario = $this->registroModel->getUsuarioById($id);
            if (!password_verify($password_actual, $usuario['clave'])) {
                $_SESSION['alerta'] = ['tipo' => 'danger', 'mensaje' => 'La contraseña actual es incorrecta.'];
                header('Location: ' . RUTA_PRINCIPAL . 'perfil');
                exit;
            }

            // Validar si la contraseña debe actualizarse
            if (!empty($password_nueva)) {
                if ($password_nueva !== $confirmar_password) {
                    $_SESSION['alerta'] = ['tipo' => 'danger', 'mensaje' => 'Las nuevas contraseñas no coinciden.'];
                    header('Location: ' . RUTA_PRINCIPAL . 'perfil');
                    exit;
                }
                // Actualizar con contraseña
                $this->registroModel->actualizarUsuario($id, $nombre, $correo, password_hash($password_nueva, PASSWORD_DEFAULT));
            } else {
                // Actualizar sin contraseña
                $this->registroModel->actualizarUsuario($id, $nombre, $correo);
            }

            // Actualizar datos de sesión
            $_SESSION['usuario']['nombre'] = $nombre;
            $_SESSION['alerta'] = ['tipo' => 'success', 'mensaje' => 'Perfil actualizado con éxito.'];
            header('Location: ' . RUTA_PRINCIPAL . 'perfil');
            exit;
        }
    }

    /**
     * Página para cambiar contraseña (especialmente para contraseñas temporales)
     */
    public function cambiarContrasena()
    {
        $data['title'] = 'Cambiar Contraseña';
        $data['temp_password'] = $_SESSION['usuario']['temp_password'] ?? 0;
        $this->views->getView('principal/clientes/cambiar-contrasena', $data);
    }

    /**
     * Procesar cambio de contraseña
     */
    public function actualizarContrasena()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION['usuario']['id'];
            $password_actual = $_POST['password_actual'] ?? '';
            $password_nueva = $_POST['password_nueva'] ?? '';
            $confirmar_password = $_POST['confirmar_password'] ?? '';

            if (empty($password_actual) || empty($password_nueva) || empty($confirmar_password)) {
                echo json_encode(['tipo' => 'error', 'msg' => 'Todos los campos son obligatorios.'], JSON_UNESCAPED_UNICODE);
                exit;
            }

            if ($password_nueva !== $confirmar_password) {
                echo json_encode(['tipo' => 'error', 'msg' => 'Las nuevas contraseñas no coinciden.'], JSON_UNESCAPED_UNICODE);
                exit;
            }

            if (strlen($password_nueva) < 6) {
                echo json_encode(['tipo' => 'error', 'msg' => 'La contraseña debe tener al menos 6 caracteres.'], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $usuario = $this->registroModel->getUsuarioById($id);
            if (!password_verify($password_actual, $usuario['clave'])) {
                echo json_encode(['tipo' => 'error', 'msg' => 'La contraseña actual es incorrecta.'], JSON_UNESCAPED_UNICODE);
                exit;
            }

            // Actualizar contraseña (también marca temp_password = 0)
            $hash = password_hash($password_nueva, PASSWORD_DEFAULT);
            $resultado = $this->registroModel->actualizarContrasena($id, $hash);

            if ($resultado) {
                // Actualizar sesión
                $_SESSION['usuario']['temp_password'] = 0;
                echo json_encode(['tipo' => 'success', 'msg' => 'Contraseña actualizada con éxito.'], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(['tipo' => 'error', 'msg' => 'Error al actualizar la contraseña.'], JSON_UNESCAPED_UNICODE);
            }
            exit;
        }
    }
}
?>