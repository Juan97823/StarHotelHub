<?php
class Login extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        if (!empty($_SESSION['usuario'])) {
            $rol = $_SESSION['usuario']['rol'];
            if ($rol == 1) {
                header('Location: ' . RUTA_PRINCIPAL . 'admin/dashboard');
            } else if ($rol == 2) {
                header('Location: ' . RUTA_PRINCIPAL . 'empleado/dashboard');
            } else if ($rol == 3) {
                header('Location: ' . RUTA_PRINCIPAL . 'cliente/dashboard');
            }
            exit;
        }

        $data['title'] = 'Login';
        $data['subtitle'] = 'Inicio de sesión';
        // Inyectar nuestra hoja de estilos personalizada
        $data['style'] = 'login.css'; 
        $this->views->getView('principal/login', $data);
    }

    public function verify()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (validarCampos(['usuario', 'clave'])) {
                $usuario = strClean($_POST['usuario']);
                $clave = strClean($_POST['clave']);

                $verificar = $this->model->validarAcceso($usuario);
                if (empty($verificar)) {
                    $res = ['tipo' => 'warning', 'msg' => 'EL USUARIO O CORREO NO EXISTE'];
                } else {
                    if (password_verify($clave, $verificar['clave'])) {
                        // Cast explícito para evitar errores con === en JS
                        $rol = (int)$verificar['rol'];

                        $_SESSION['usuario'] = [
                            'id' => $verificar['id'],
                            'nombre' => $verificar['nombre'],
                            'correo' => $verificar['correo'],
                            'rol' => $rol,
                        ];

                        $res = [
                            'tipo' => 'success',
                            'msg' => 'ACCESO CORRECTO',
                            'rol' => $rol
                        ];
                    } else {
                        $res = ['tipo' => 'warning', 'msg' => 'LA CONTRASEÑA ES INCORRECTA'];
                    }
                }
            } else {
                $res = ['tipo' => 'warning', 'msg' => 'TODOS LOS CAMPOS SON OBLIGATORIOS'];
            }
        } else {
            $res = ['tipo' => 'error', 'msg' => 'PETICIÓN INVÁLIDA'];
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function salir()
    {
        session_destroy();
        header('Location: ' . RUTA_PRINCIPAL);
    }
}
