<?php
/**
 * EmailHelper - Clase para manejar el envío de emails
 *
 * Usa PHPMailer para SMTP y PHP mail() como fallback
 */

class EmailHelper
{
    private $to;
    private $toName;
    private $subject;
    private $body;
    private $attachments = [];

    /** @var \PHPMailer\PHPMailer\PHPMailer|null */
    private $mail;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Verificar si PHPMailer está disponible
        if (class_exists('\PHPMailer\PHPMailer\PHPMailer')) {
            $this->mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $this->configurarPHPMailer();
        } else {
            // PHPMailer no disponible, usar mail() de PHP
            error_log("ADVERTENCIA PHPMailer no esta instalado. Usando mail() de PHP como fallback.");
            $this->mail = null;
        }
    }

    /**
     * Configurar PHPMailer
     */
    private function configurarPHPMailer()
    {
        try {
            if (EMAIL_DRIVER === 'smtp') {
                // Configuración SMTP
                $this->mail->isSMTP();
                $this->mail->Host = SMTP_HOST;
                $this->mail->SMTPAuth = true;
                $this->mail->Username = SMTP_USER;
                $this->mail->Password = SMTP_PASS;
                $this->mail->SMTPSecure = SMTP_SECURE;
                $this->mail->Port = SMTP_PORT;

                // Configuración adicional
                $this->mail->SMTPDebug = defined('SMTP_DEBUG') ? constant('SMTP_DEBUG') : 0; // 0 = sin debug, 2 = debug completo
                $this->mail->Timeout = 10;
            } else {
                // Usar PHP mail()
                $this->mail->isMail();
            }

            // Configuración general
            $this->mail->setFrom(EMAIL_FROM, EMAIL_FROM_NAME);
            $this->mail->isHTML(true);
            $this->mail->CharSet = 'UTF-8';
            $this->mail->Encoding = 'base64';

        } catch (\PHPMailer\PHPMailer\Exception $e) {
            error_log("Error configurando PHPMailer: " . $e->getMessage());
        }
    }

    /**
     * Establecer destinatario
     */
    public function setTo($email, $name = '')
    {
        $this->to = $email;
        $this->toName = $name ?: '';
        return $this;
    }

    /**
     * Establecer asunto
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        if ($this->mail !== null) {
            $this->mail->Subject = $subject;
        }
        return $this;
    }

    /**
     * Establecer cuerpo del email
     */
    public function setBody($body)
    {
        $this->body = $body;
        if ($this->mail !== null) {
            $this->mail->Body = $body;
        }
        return $this;
    }

    /**
     * Cargar plantilla de email
     */
    public function loadTemplate($template, $data = [])
    {
        $templatePath = EMAIL_TEMPLATES_PATH . $template . '.php';

        if (!file_exists($templatePath)) {
            throw new Exception("Plantilla de email no encontrada: $template");
        }

        // Renderizar plantilla con las variables
        $this->body = $this->renderTemplate($templatePath, $data);

        // Actualizar el body en PHPMailer si está disponible
        if ($this->mail !== null) {
            $this->mail->Body = $this->body;
        }

        return $this;
    }

    /**
     * Renderizar plantilla con variables
     */
    private function renderTemplate($templatePath, $data = [])
    {
        error_log("=== RENDERIZANDO PLANTILLA ===");
        error_log("Template: $templatePath");
        error_log("Data: " . print_r($data, true));

        // Extraer variables para que estén disponibles en la plantilla
        extract($data);

        error_log("Variables extraídas. Verificando clave_temporal: " . (isset($clave_temporal) ? $clave_temporal : 'NO DEFINIDA'));

        // Capturar salida de la plantilla
        ob_start();
        include $templatePath;
        $output = ob_get_clean();

        error_log("Plantilla renderizada. Longitud: " . strlen($output));

        return $output;
    }

    /**
     * Agregar adjunto
     */
    public function addAttachment($filePath, $fileName = '')
    {
        if (!file_exists($filePath)) {
            throw new Exception("Archivo no encontrado: $filePath");
        }

        if (empty($fileName)) {
            $fileName = basename($filePath);
        }

        $this->attachments[] = [
            'path' => $filePath,
            'name' => $fileName
        ];

        return $this;
    }

    /**
     * Enviar email
     */
    public function send()
    {
        if (empty($this->to) || empty($this->subject) || empty($this->body)) {
            throw new Exception("Faltan datos requeridos para enviar el email");
        }

        // Si PHPMailer no está disponible, usar mail() de PHP directamente
        if ($this->mail === null) {
            return $this->sendWithPhpMail();
        }

        try {
            // Agregar destinatario
            $this->mail->addAddress($this->to, $this->toName);

            // Agregar adjuntos
            foreach ($this->attachments as $attachment) {
                $this->mail->addAttachment($attachment['path'], $attachment['name']);
            }

            // Log de debug
            $logMessage = "Intentando enviar email a: {$this->to}\n";
            $logMessage .= "Asunto: {$this->subject}\n";
            $logMessage .= "Driver: " . EMAIL_DRIVER . "\n";
            if (EMAIL_DRIVER === 'smtp') {
                $logMessage .= "SMTP Host: " . SMTP_HOST . "\n";
                $logMessage .= "SMTP Port: " . SMTP_PORT . "\n";
                $logMessage .= "SMTP User: " . SMTP_USER . "\n";
            }
            error_log($logMessage);

            // Enviar
            $resultado = $this->mail->send();

            error_log("Email enviado exitosamente a: " . $this->to);
            return $resultado;

        } catch (\PHPMailer\PHPMailer\Exception $e) {
            $errorMsg = "ERROR Error al enviar email a {$this->to}: " . $e->getMessage() . "\n";
            if ($this->mail !== null) {
                $errorMsg .= "PHPMailer Error: " . $this->mail->ErrorInfo . "\n";
            }
            error_log($errorMsg);

            // Intentar fallback a mail() de PHP
            error_log("Intentando fallback a mail() de PHP para: {$this->to}");
            return $this->sendWithPhpMail();
        }
    }

    /**
     * Enviar email usando la función mail() de PHP (fallback)
     */
    private function sendWithPhpMail()
    {
        try {
            error_log("Enviando email con mail() de PHP a: {$this->to}");

            // Headers
            $headers = [];
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=UTF-8';
            $headers[] = 'From: ' . EMAIL_FROM_NAME . ' <' . EMAIL_FROM . '>';
            $headers[] = 'Reply-To: ' . EMAIL_FROM;
            $headers[] = 'X-Mailer: PHP/' . phpversion();

            // Enviar
            $resultado = mail(
                $this->to,
                $this->subject,
                $this->body,
                implode("\r\n", $headers)
            );

            if ($resultado) {
                error_log("Email enviado con mail() de PHP a: " . $this->to);
                return true;
            } else {
                error_log("ERROR mail() de PHP fallo para: " . $this->to);
                return false;
            }
        } catch (\Exception $e) {
            error_log("ERROR Error en sendWithPhpMail(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Generar contraseña temporal
     */
    public static function generateTempPassword($length = 12)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%';
        $password = '';
        
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        return $password;
    }

    /**
     * Generar token para recuperación de contraseña
     */
    public static function generateResetToken()
    {
        return bin2hex(random_bytes(32));
    }
}

