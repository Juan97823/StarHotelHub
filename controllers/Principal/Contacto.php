<?php
class Contacto extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cargarModel('Contacto');
    }

    public function index()
    {
        $data['title'] = 'Contacto';
        $data['subtitle'] = 'Contáctenos';
        $this->views->getView('principal/contacto/index', $data);
    }

    /**
     * Procesar formulario de contacto
     */
    public function enviar()
    {
        error_log("=== CONTACTO::ENVIAR ===");
        error_log("POST data: " . print_r($_POST, true));

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['tipo' => 'error', 'msg' => 'PETICIÓN INVÁLIDA'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Validar campos requeridos
        if (!validarCampos(['name', 'correo', 'phone_number', 'msg_subject', 'message'])) {
            error_log("ERROR: Campos faltantes");
            echo json_encode(['tipo' => 'warning', 'msg' => 'TODOS LOS CAMPOS SON OBLIGATORIOS'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Sanitizar entrada
        $nombre = sanitizar($_POST['name']);
        $correo = sanitizar($_POST['correo']);
        $telefono = sanitizar($_POST['phone_number']);
        $asunto = sanitizar($_POST['msg_subject']);
        $mensaje = sanitizar($_POST['message']);

        error_log("Datos sanitizados - Nombre: $nombre, Correo: $correo, Telefono: $telefono");

        // Validar email
        if (!validarEmail($correo)) {
            error_log("ERROR: Email inválido: $correo");
            echo json_encode(['tipo' => 'warning', 'msg' => 'EMAIL INVÁLIDO'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Validar teléfono (solo números y caracteres permitidos)
        if (!preg_match('/^[0-9\s\-\+\(\)]+$/', $telefono)) {
            error_log("ERROR: Teléfono inválido: $telefono");
            echo json_encode(['tipo' => 'warning', 'msg' => 'TELÉFONO INVÁLIDO'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Guardar en BD
        error_log("Intentando guardar en BD...");
        $resultado = $this->model->guardarContacto($nombre, $correo, $telefono, $asunto, $mensaje);
        error_log("Resultado de guardarContacto: " . ($resultado ? $resultado : 'FALSE'));

        if ($resultado > 0) {
            // Enviar email de confirmación
            error_log("Enviando emails de confirmación...");
            $this->enviarEmailContacto($nombre, $correo, $telefono, $asunto, $mensaje);

            echo json_encode([
                'tipo' => 'success',
                'msg' => 'MENSAJE ENVIADO CORRECTAMENTE. NOS PONDREMOS EN CONTACTO PRONTO.'
            ], JSON_UNESCAPED_UNICODE);
        } else {
            error_log("ERROR: No se pudo guardar en BD. Resultado: " . var_export($resultado, true));
            echo json_encode([
                'tipo' => 'error',
                'msg' => 'ERROR AL ENVIAR EL MENSAJE. INTENTA DE NUEVO.'
            ], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }

    /**
     * Enviar email de confirmación
     */
    private function enviarEmailContacto($nombre, $correo, $telefono, $asunto, $mensaje)
    {
        // Enviar dos correos:
        // 1) Al equipo/admin: detalles del mensaje de contacto
        // 2) Al remitente: confirmación de recepción

        try {
            // Cargar helper de emails
            require_once RUTA_RAIZ . '/config/email.php';
            require_once RUTA_RAIZ . '/app/helpers/EmailHelper.php';

            // 1) Email al admin (starhotelhub@gmail.com)
            $adminEmail = 'starhotelhub@gmail.com';
            $adminSubject = 'Nuevo mensaje de contacto: ' . $asunto;
            $adminBody = "<html><body>
                <h2>Nuevo mensaje de contacto en StarHotelHub</h2>
                <p><strong>Nombre:</strong> {$nombre}</p>
                <p><strong>Email:</strong> {$correo}</p>
                <p><strong>Teléfono:</strong> {$telefono}</p>
                <p><strong>Asunto:</strong> {$asunto}</p>
                <p><strong>Mensaje:</strong></p>
                <p>{$mensaje}</p>
                </body></html>";

            $emailAdmin = new EmailHelper();
            $emailAdmin->setTo($adminEmail, 'StarHotelHub')
                       ->setSubject($adminSubject)
                       ->setBody($adminBody)
                       ->send();

            // 2) Email de confirmación al remitente
            $userSubject = 'Hemos recibido tu mensaje - StarHotelHub';
            $userBody = "<html><body>
                <p>Hola <strong>{$nombre}</strong>,</p>
                <p>Hemos recibido tu mensaje con asunto <strong>{$asunto}</strong>. Nuestro equipo se pondrá en contacto contigo pronto.</p>
                <p>Si necesitas contactarnos directamente, escríbenos a <strong>starhotelhub@gmail.com</strong>.</p>
                <p>Saludos,<br/>Equipo StarHotelHub</p>
                </body></html>";

            $emailUser = new EmailHelper();
            $emailUser->setTo($correo, $nombre)
                      ->setSubject($userSubject)
                      ->setBody($userBody)
                      ->send();

        } catch (Exception $e) {
            error_log('Error al enviar emails de contacto: ' . $e->getMessage());
        }
    }
}