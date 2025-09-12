<?php
class Login extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (session_status() === PHP_SESSION_NONE) {
            //  Configurar parámetros seguros de sesión
            session_set_cookie_params([
                'lifetime' => 0,         // Expira al cerrar navegador
                'httponly' => true,      // Previene acceso por JS
                'samesite' => 'Strict',  // Evita CSRF básico
                'secure' => isset($_SERVER['HTTPS']) // Solo HTTPS si aplica
            ]);
            session_start();
        }
    }

    public function index()
    {
        if (!empty($_SESSION['usuario'])) {
            $rol = $_SESSION['usuario']['rol'];
            switch ($rol) {
                case 1:
                    header('Location: ' . RUTA_PRINCIPAL . 'admin/dashboard');
                    break;
                case 2:
                    header('Location: ' . RUTA_PRINCIPAL . 'empleado/dashboard');
                    break;
                case 3:
                    header('Location: ' . RUTA_PRINCIPAL . 'cliente/dashboard');
                    break;
            }
            exit;
        }

        $data['title'] = 'Login';
        $data['subtitle'] = 'Inicio de sesión';
        $data['style'] = 'login.css'; 
        $this->views->getView('principal/login', $data);
    }

    public function verify()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $res = ['tipo' => 'error', 'msg' => 'PETICIÓN INVÁLIDA'];
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            die();
        }

        //  Validar campos obligatorios
        if (!validarCampos(['usuario', 'clave'])) {
            $res = ['tipo' => 'warning', 'msg' => 'TODOS LOS CAMPOS SON OBLIGATORIOS'];
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            die();
        }

        $usuario = strClean($_POST['usuario']);
        $clave = strClean($_POST['clave']);

        $verificar = $this->model->validarAcceso($usuario);

        if (empty($verificar)) {
            $res = ['tipo' => 'warning', 'msg' => 'EL USUARIO O CORREO NO EXISTE'];
        } else {
            if (password_verify($clave, $verificar['clave'])) {
                //  Regenerar ID de sesión en cada login exitoso
                session_regenerate_id(true);

                $rol = (int)$verificar['rol'];
                $_SESSION['usuario'] = [
                    'id'     => (int)$verificar['id'],
                    'nombre' => htmlspecialchars($verificar['nombre']),
                    'correo' => htmlspecialchars($verificar['correo']),
                    'rol'    => $rol,
                    'login_time' => time()
                ];

                $res = [
                    'tipo' => 'success',
                    'msg'  => 'ACCESO CORRECTO',
                    'rol'  => $rol
                ];
            } else {
                // Opcional: aquí puedes contar intentos de login fallidos
                $res = ['tipo' => 'warning', 'msg' => 'LA CONTRASEÑA ES INCORRECTA'];
            }
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function salir()
    {
        //  Cerrar sesión de forma segura
        session_unset();
        session_destroy();
        session_regenerate_id(true);
        header('Location: ' . RUTA_PRINCIPAL);
        exit;
    }
}
