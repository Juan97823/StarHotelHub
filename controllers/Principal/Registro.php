<?php
class Registro extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cargarModel('Registro');
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
        // DEBUG: log de tokens para diagnosticar 403 en entorno local (remover en producción)
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $postToken = $_POST['csrf_token'] ?? null;
        $sessionToken = $_SESSION['csrf_token'] ?? null;
        error_log("[DEBUG] Registro::crear - session_id=" . session_id() . " POST_csrf=" . ($postToken ?? 'null') . " SESSION_csrf=" . ($sessionToken ?? 'null'));

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
            generarCsrfToken();
            echo json_encode(['tipo' => 'warning', 'msg' => 'EMAIL INVÁLIDO'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Validar contraseña
        if (!validarContrasena($clave)) {
            generarCsrfToken();
            echo json_encode(['tipo' => 'warning', 'msg' => 'LA CONTRASEÑA DEBE TENER AL MENOS 8 CARACTERES, MAYÚSCULA, MINÚSCULA Y NÚMERO'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Validar que las contraseñas coincidan
        if ($clave !== $confirmar) {
            generarCsrfToken();
            echo json_encode(['tipo' => 'warning', 'msg' => 'LAS CONTRASEÑAS NO COINCIDEN'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Validar que el correo no esté registrado
        $verificarCorreo = $this->model->validarUnique('correo', $correo, 0);
        if (!empty($verificarCorreo)) {
            generarCsrfToken();
            echo json_encode(['tipo' => 'warning', 'msg' => 'EL CORREO YA ESTÁ REGISTRADO'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Registrar usuario
        $hash = password_hash($clave, PASSWORD_DEFAULT);
        $rol = 3; // Usuario normal
        $resultado = $this->model->registrarse($nombre, $correo, $hash, $rol);

        if ($resultado > 0) {
            // Generar token de verificación y guardarlo
            try {
                $token = bin2hex(random_bytes(32));
                $this->model->setVerificationToken($resultado, $token);
            } catch (Exception $e) {
                // si falla la generación, continuar sin token (no ideal)
                error_log('Error generando token de verificación: ' . $e->getMessage());
                $token = null;
            }

            // Responder inmediatamente al cliente para mejorar la UX
            $response = ['tipo' => 'success', 'msg' => 'USUARIO REGISTRADO EXITOSAMENTE. REVISA TU CORREO PARA CONFIRMAR.'];
            echo json_encode($response, JSON_UNESCAPED_UNICODE);

            // Cerrar la sesión para evitar bloqueos y terminar la respuesta al cliente
            if (session_status() == PHP_SESSION_ACTIVE) {
                session_write_close();
            }

            // Intentar terminar la respuesta rápidamente si PHP-FPM está disponible
            if (function_exists('fastcgi_finish_request')) {
                fastcgi_finish_request();
            } else {
                // Intentar vaciar buffers y forzar flush como fallback
                @ob_flush();
                @flush();
            }

            // Enviar email de confirmación en background (el cliente ya recibió la respuesta)
            try {
                $this->enviarEmailRegistro($nombre, $correo, $token);
            } catch (Exception $e) {
                error_log("Error enviando email en background: " . $e->getMessage());
            }
        } else {
            echo json_encode(['tipo' => 'error', 'msg' => 'ERROR AL REGISTRAR EL USUARIO'], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }

    /**
     * Enviar email de confirmación de registro
     */
    private function enviarEmailRegistro($nombre, $correo, $token)
    {
        try {
            // Cargar el helper de emails
            require_once RUTA_RAIZ . '/config/email.php';
            require_once RUTA_RAIZ . '/app/helpers/EmailHelper.php';

            $email = new EmailHelper();
            $confirmLink = $token ? RUTA_PRINCIPAL . 'registro/confirmar/' . $token : RUTA_PRINCIPAL . 'login';

            $email->setTo($correo, $nombre)
                  ->setSubject('Bienvenido a StarHotelHub - Confirma tu correo')
                  ->loadTemplate('registro_confirmacion', [
                      'nombre' => $nombre,
                      'correo' => $correo,
                      'confirmLink' => $confirmLink
                  ])
                  ->send();

        } catch (Exception $e) {
            error_log("Error al enviar email de registro: " . $e->getMessage());
            // No interrumpir el flujo si falla el email
        }
    }

    // Endpoint para confirmar cuenta
    public function confirmar($token = null)
    {
        if (!$token) {
            $this->views->getView('principal/RegistroConfirmacion', ['success' => false, 'msg' => 'Token inválido']);
            return;
        }

        $this->cargarModel('Registro');
        $res = $this->model->verifyUserByToken($token);
        if ($res) {
            $this->views->getView('principal/RegistroConfirmacion', ['success' => true, 'msg' => 'Cuenta confirmada. Ya puedes iniciar sesión.']);
        } else {
            $this->views->getView('principal/RegistroConfirmacion', ['success' => false, 'msg' => 'Token inválido o expirado.']);
        }
    }

    public function exito()
    {
        $data['title'] = 'Registro completado';
        $data['subtitle'] = 'Revisa tu correo para confirmar tu cuenta';
        $this->views->getView('principal/RegistroExito', $data);
    }
}
 