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
    private $mail;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        $this->configurarPHPMailer();
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
        $this->mail->Subject = $subject;
        return $this;
    }

    /**
     * Establecer cuerpo del email
     */
    public function setBody($body)
    {
        $this->body = $body;
        $this->mail->Body = $body;
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

        // Extraer variables para la plantilla
        extract($data);

        // Capturar salida de la plantilla
        ob_start();
        include $templatePath;
        $this->body = ob_get_clean();

        // Actualizar el body en PHPMailer
        $this->mail->Body = $this->body;

        return $this;
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

            error_log("✅ Email enviado exitosamente a: " . $this->to);
            return $resultado;

        } catch (\PHPMailer\PHPMailer\Exception $e) {
            $errorMsg = "❌ Error al enviar email a {$this->to}: " . $e->getMessage() . "\n";
            $errorMsg .= "PHPMailer Error: " . $this->mail->ErrorInfo . "\n";
            error_log($errorMsg);

            // Si usamos SMTP, intentar fallback a mail() para no bloquear flujos importantes
            if (EMAIL_DRIVER === 'smtp') {
                try {
                    error_log("Intentando fallback a mail() para: {$this->to}");
                    // Reconfigurar PHPMailer para usar mail()
                    $this->mail = new \PHPMailer\PHPMailer\PHPMailer(true);
                    $this->mail->isMail();
                    $this->mail->setFrom(EMAIL_FROM, EMAIL_FROM_NAME);
                    $this->mail->isHTML(true);
                    $this->mail->CharSet = 'UTF-8';
                    $this->mail->Encoding = 'base64';
                    $this->mail->addAddress($this->to, $this->toName);
                    foreach ($this->attachments as $attachment) {
                        $this->mail->addAttachment($attachment['path'], $attachment['name']);
                    }
                    $this->mail->Subject = $this->subject;
                    $this->mail->Body = $this->body;

                    $res2 = $this->mail->send();
                    if ($res2) {
                        error_log("✅ Email enviado por fallback mail() a: " . $this->to);
                        return true;
                    }
                } catch (\Exception $ex2) {
                    error_log("❌ Fallback mail() también falló para {$this->to}: " . $ex2->getMessage());
                }
            }

            // Re-lanzar excepción después de intentar fallback
            throw $e;
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

