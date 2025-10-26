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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['tipo' => 'error', 'msg' => 'PETICIÓN INVÁLIDA'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Validar campos requeridos
        if (!validarCampos(['name', 'correo', 'phone_number', 'msg_subject', 'message'])) {
            echo json_encode(['tipo' => 'warning', 'msg' => 'TODOS LOS CAMPOS SON OBLIGATORIOS'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Sanitizar entrada
        $nombre = sanitizar($_POST['name']);
        $correo = sanitizar($_POST['correo']);
        $telefono = sanitizar($_POST['phone_number']);
        $asunto = sanitizar($_POST['msg_subject']);
        $mensaje = sanitizar($_POST['message']);

        // Validar email
        if (!validarEmail($correo)) {
            echo json_encode(['tipo' => 'warning', 'msg' => 'EMAIL INVÁLIDO'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Validar teléfono (solo números y caracteres permitidos)
        if (!preg_match('/^[0-9\s\-\+\(\)]+$/', $telefono)) {
            echo json_encode(['tipo' => 'warning', 'msg' => 'TELÉFONO INVÁLIDO'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Guardar en BD
        $resultado = $this->model->guardarContacto($nombre, $correo, $telefono, $asunto, $mensaje);

        if ($resultado > 0) {
            // Enviar email de confirmación
            $this->enviarEmailContacto($nombre, $correo, $asunto, $mensaje);

            echo json_encode([
                'tipo' => 'success',
                'msg' => 'MENSAJE ENVIADO CORRECTAMENTE. NOS PONDREMOS EN CONTACTO PRONTO.'
            ], JSON_UNESCAPED_UNICODE);
        } else {
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
    private function enviarEmailContacto($nombre, $correo, $asunto, $mensaje)
    {
        // Nota: Descomentar cuando se configure servidor SMTP
        // $destinatario = 'contacto@starhotelhub.com';
        // $asunto_email = 'Nuevo mensaje de contacto: ' . $asunto;
        //
        // $cuerpo = "
        // <html>
        // <head>
        //     <title>Nuevo Mensaje de Contacto</title>
        // </head>
        // <body>
        //     <h2>Nuevo mensaje de contacto en StarHotelHub</h2>
        //     <p><strong>Nombre:</strong> {$nombre}</p>
        //     <p><strong>Email:</strong> {$correo}</p>
        //     <p><strong>Asunto:</strong> {$asunto}</p>
        //     <p><strong>Mensaje:</strong></p>
        //     <p>{$mensaje}</p>
        // </body>
        // </html>
        // ";
        //
        // $headers = "MIME-Version: 1.0\r\n";
        // $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        // $headers .= "From: {$correo}\r\n";
        //
        // mail($destinatario, $asunto_email, $cuerpo, $headers);
    }
}