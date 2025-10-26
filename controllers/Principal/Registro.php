<?php
class Registro extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = 'Registro';
        $data['subtitle'] = 'Regístrate en nuestra plataforma';
        $this->views->getView('principal/Registro', $data);
    }

    public function crear()
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

        if (!validarCampos(['nombre', 'correo', 'clave', 'confirmar', 'chb2'])) {
            echo json_encode(['tipo' => 'warning', 'msg' => 'TODOS LOS CAMPOS SON OBLIGATORIOS'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $nombre = sanitizar($_POST['nombre']);
        $correo = sanitizar($_POST['correo']);
        $clave = $_POST['clave'];
        $confirmar = $_POST['confirmar'];

        // Validar email
        if (!validarEmail($correo)) {
            echo json_encode(['tipo' => 'warning', 'msg' => 'EMAIL INVÁLIDO'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Validar contraseña
        if (!validarContrasena($clave)) {
            echo json_encode(['tipo' => 'warning', 'msg' => 'LA CONTRASEÑA DEBE TENER AL MENOS 8 CARACTERES, MAYÚSCULA, MINÚSCULA Y NÚMERO'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Validar que las contraseñas coincidan
        if ($clave !== $confirmar) {
            echo json_encode(['tipo' => 'warning', 'msg' => 'LAS CONTRASEÑAS NO COINCIDEN'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Validar que el correo no esté registrado
        $verificarCorreo = $this->model->validarUnique('correo', $correo, 0);
        if (!empty($verificarCorreo)) {
            echo json_encode(['tipo' => 'warning', 'msg' => 'EL CORREO YA ESTÁ REGISTRADO'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Registrar usuario
        $hash = password_hash($clave, PASSWORD_DEFAULT);
        $rol = 3; // Usuario normal
        $resultado = $this->model->registrarse($nombre, $correo, $hash, $rol);

        if ($resultado > 0) {
            echo json_encode(['tipo' => 'success', 'msg' => 'USUARIO REGISTRADO EXITOSAMENTE'], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['tipo' => 'error', 'msg' => 'ERROR AL REGISTRAR EL USUARIO'], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }
}
 