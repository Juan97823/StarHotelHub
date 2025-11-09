<?php
class OlvideContrasena extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cargarModel('Registro');
    }

    /**
     * Mostrar formulario de recuperación de contraseña
     */
    public function index()
    {
        $data['title'] = 'Recuperar Contraseña';
        $data['subtitle'] = 'Recupera tu acceso';
        $this->views->getView('principal/olvide-contrasena/index', $data);
    }

    /**
     * Procesar solicitud de recuperación de contraseña
     */
    public function recuperar()
    {
        error_log("DEBUG - Método recuperar() iniciado");

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

        // Validar que el correo esté presente
        if (!isset($_POST['correo']) || empty($_POST['correo'])) {
            generarCsrfToken();
            echo json_encode(['tipo' => 'warning', 'msg' => 'EL CORREO ES OBLIGATORIO'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $correo = sanitizar($_POST['correo']);

        // Validar email
        if (!validarEmail($correo)) {
            generarCsrfToken();
            echo json_encode(['tipo' => 'warning', 'msg' => 'EMAIL INVÁLIDO'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Verificar que el correo exista
        $usuario = $this->model->verificarCorreo($correo);
        if (empty($usuario)) {
            // Por seguridad, no revelar si el correo existe o no
            echo json_encode(['tipo' => 'success', 'msg' => 'SI EL CORREO EXISTE EN NUESTRO SISTEMA, RECIBIRÁS UN MENSAJE CON INSTRUCCIONES.'], JSON_UNESCAPED_UNICODE);
            exit;
        }
        // Generar token único y seguro
        $token = bin2hex(random_bytes(32)); // Token de 64 caracteres hexadecimales

        // Calcular fecha de expiración (1 hora desde ahora)
        $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // DEBUG: Log de valores
        error_log("DEBUG - Usuario ID: " . $usuario['id']);
        error_log("DEBUG - Token: " . $token);
        error_log("DEBUG - Expira: " . $expira);

        // Guardar token en la base de datos
        $resultado = $this->model->guardarTokenReset($usuario['id'], $token, $expira);

        // DEBUG: Log de resultado
        error_log("DEBUG - Resultado guardarTokenReset: " . $resultado);
        if ($resultado > 0) {
            // Enviar email con enlace de restablecimiento
            $this->enviarEmailRecuperacion(
                $usuario['nombre'],
                $usuario['correo'],
                $token
            );

            echo json_encode(['tipo' => 'success', 'msg' => 'SI EL CORREO EXISTE EN NUESTRO SISTEMA, RECIBIRÁS UN MENSAJE CON INSTRUCCIONES.'], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['tipo' => 'error', 'msg' => 'ERROR AL PROCESAR LA SOLICITUD. INTENTA DE NUEVO.'], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }

    /**
     * Enviar email de recuperación de contraseña con enlace de token
     */
    private function enviarEmailRecuperacion($nombre, $correo, $token)
    {
        try {
            // Cargar el helper de emails
            require_once RUTA_RAIZ . '/config/email.php';
            require_once RUTA_RAIZ . '/app/helpers/EmailHelper.php';

            // Crear enlace de restablecimiento
            $enlace_reset = RUTA_PRINCIPAL . 'olvidecontrasena/restablecer/' . $token;

            $email = new EmailHelper();
            $email->setTo($correo, $nombre)
                ->setSubject('Recuperación de Contraseña - StarHotelHub')
                ->loadTemplate('recuperar_contrasena', [
                    'nombre' => $nombre,
                    'correo' => $correo,
                    'enlace_reset' => $enlace_reset
                ])
                ->send();

        } catch (Exception $e) {
            error_log("Error al enviar email de recuperación: " . $e->getMessage());
            // No interrumpir el flujo si falla el email
        }
    }

    /**
     * Mostrar formulario para restablecer contraseña con token
     */
    public function restablecer($token = '')
    {
        if (empty($token)) {
            header('Location: ' . RUTA_PRINCIPAL . 'olvidecontrasena');
            exit;
        }

        // Validar que el token sea válido
        $usuario = $this->model->validarTokenReset($token);

        if (!$usuario) {
            $data['title'] = 'Token Inválido';
            $data['error'] = 'El enlace de restablecimiento es inválido o ha expirado.';
            $this->views->getView('principal/olvide-contrasena/token-invalido', $data);
            exit;
        }

        // Mostrar formulario para nueva contraseña
        $data['title'] = 'Restablecer Contraseña';
        $data['token'] = $token;
        $data['nombre'] = $usuario['nombre'];
        $this->views->getView('principal/olvide-contrasena/restablecer', $data);
    }

    /**
     * Procesar el restablecimiento de contraseña con token
     */
    public function procesarRestablecimiento()
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

        // Validar campos requeridos
        if (!isset($_POST['token']) || empty($_POST['token'])) {
            echo json_encode(['tipo' => 'error', 'msg' => 'TOKEN NO PROPORCIONADO'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        if (!isset($_POST['password']) || empty($_POST['password'])) {
            generarCsrfToken();
            echo json_encode(['tipo' => 'warning', 'msg' => 'LA CONTRASEÑA ES OBLIGATORIA'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        if (!isset($_POST['password_confirm']) || empty($_POST['password_confirm'])) {
            generarCsrfToken();
            echo json_encode(['tipo' => 'warning', 'msg' => 'DEBES CONFIRMAR LA CONTRASEÑA'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $token = sanitizar($_POST['token']);
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];

        // Validar que las contraseñas coincidan
        if ($password !== $password_confirm) {
            generarCsrfToken();
            echo json_encode(['tipo' => 'warning', 'msg' => 'LAS CONTRASEÑAS NO COINCIDEN'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Validar longitud de contraseña
        if (strlen($password) < 6) {
            generarCsrfToken();
            echo json_encode(['tipo' => 'warning', 'msg' => 'LA CONTRASEÑA DEBE TENER AL MENOS 6 CARACTERES'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Hashear nueva contraseña
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Actualizar contraseña usando el token
        $resultado = $this->model->actualizarContrasenaConToken($token, $hash);

        if ($resultado > 0) {
            echo json_encode([
                'tipo' => 'success',
                'msg' => 'CONTRASEÑA ACTUALIZADA CORRECTAMENTE. YA PUEDES INICIAR SESIÓN.',
                'redirect' => RUTA_PRINCIPAL . 'login'
            ], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['tipo' => 'error', 'msg' => 'EL ENLACE HA EXPIRADO O ES INVÁLIDO. SOLICITA UNO NUEVO.'], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }
}

