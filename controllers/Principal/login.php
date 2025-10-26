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
            http_response_code(405);
            echo json_encode(['tipo' => 'error', 'msg' => 'PETICIÓN INVÁLIDA'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Validar CSRF token
        if (!isset($_POST['csrf_token']) || !validarCsrfToken($_POST['csrf_token'])) {
            http_response_code(403);
            echo json_encode(['tipo' => 'error', 'msg' => 'TOKEN INVÁLIDO'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Validar campos obligatorios
        if (!validarCampos(['usuario', 'clave'])) {
            echo json_encode(['tipo' => 'warning', 'msg' => 'TODOS LOS CAMPOS SON OBLIGATORIOS'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $usuario = sanitizar($_POST['usuario']);
        $clave = $_POST['clave']; // NO sanitizar contraseña antes de verificar hash

        // Validar formato de email
        if (!validarEmail($usuario)) {
            echo json_encode(['tipo' => 'warning', 'msg' => 'FORMATO DE EMAIL INVÁLIDO'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $verificar = $this->model->validarAcceso($usuario);

        if (empty($verificar)) {
            // Usar mensaje genérico por seguridad
            echo json_encode(['tipo' => 'warning', 'msg' => 'CREDENCIALES INVÁLIDAS'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        if (password_verify($clave, $verificar['clave'])) {
            // Regenerar ID de sesión en cada login exitoso
            session_regenerate_id(true);

            $rol = (int)$verificar['rol'];
            $_SESSION['usuario'] = [
                'id'     => (int)$verificar['id'],
                'nombre' => sanitizar($verificar['nombre']),
                'correo' => sanitizar($verificar['correo']),
                'rol'    => $rol,
                'login_time' => time()
            ];

            echo json_encode([
                'tipo' => 'success',
                'msg'  => 'ACCESO CORRECTO',
                'rol'  => $rol
            ], JSON_UNESCAPED_UNICODE);
        } else {
            // Usar mensaje genérico por seguridad
            echo json_encode(['tipo' => 'warning', 'msg' => 'CREDENCIALES INVÁLIDAS'], JSON_UNESCAPED_UNICODE);
        }
        exit;
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
