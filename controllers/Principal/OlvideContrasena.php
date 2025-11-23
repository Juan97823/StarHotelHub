<?php
class OlvideContrasena extends Controller
{
    public function __construct()
    {
        // No llamar a parent::__construct() para evitar cargar OlvideContrasenaModel
        require_once 'config/app/Query.php';
        $this->views = new Views();
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

        // Generar contraseña temporal
        require_once RUTA_RAIZ . '/app/helpers/EmailHelper.php';
        $clave_temporal = EmailHelper::generateTempPassword(12);
        $hash = password_hash($clave_temporal, PASSWORD_DEFAULT);

        // Actualizar contraseña en la base de datos y marcar como temporal
        $resultado = $this->model->actualizarContrasenaTemp($usuario['id'], $hash);

        if ($resultado > 0) {
            // Enviar email con contraseña temporal
            $this->enviarEmailRecuperacion(
                $usuario['nombre'],
                $usuario['correo'],
                $clave_temporal
            );

            echo json_encode(['tipo' => 'success', 'msg' => 'SI EL CORREO EXISTE EN NUESTRO SISTEMA, RECIBIRÁS UN MENSAJE CON INSTRUCCIONES.'], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['tipo' => 'error', 'msg' => 'ERROR AL PROCESAR LA SOLICITUD. INTENTA DE NUEVO.'], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }

    /**
     * Enviar email de recuperación de contraseña
     */
    private function enviarEmailRecuperacion($nombre, $correo, $clave_temporal)
    {
        try {
            // Cargar el helper de emails
            require_once RUTA_RAIZ . '/config/email.php';
            require_once RUTA_RAIZ . '/app/helpers/EmailHelper.php';

            error_log("=== ENVIANDO EMAIL ===");
            error_log("Nombre: $nombre");
            error_log("Correo: $correo");
            error_log("Clave temporal: $clave_temporal");

            $email = new EmailHelper();
            $email->setTo($correo, $nombre)
                ->setSubject('Recuperación de Contraseña - StarHotelHub')
                ->loadTemplate('recuperar_contrasena', [
                    'nombre' => $nombre,
                    'correo' => $correo,
                    'clave_temporal' => $clave_temporal
                ])
                ->send();

            error_log("Email enviado correctamente");

        } catch (Exception $e) {
            error_log("Error al enviar email de recuperación: " . $e->getMessage());
            // No interrumpir el flujo si falla el email
        }
    }
}
?>