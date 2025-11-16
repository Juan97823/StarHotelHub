<?php
/**
 * Script de prueba para verificar el envío de emails
 */

// Cargar configuración
require_once 'config/config.php';
require_once 'config/email.php';
require_once 'vendor/autoload.php';
require_once 'app/helpers/EmailHelper.php';

echo "=== TEST DE ENVÍO DE EMAIL ===\n\n";

// Configuración
echo "Configuración de Email:\n";
echo "- Driver: " . EMAIL_DRIVER . "\n";
echo "- From: " . EMAIL_FROM . "\n";
echo "- From Name: " . EMAIL_FROM_NAME . "\n";

if (EMAIL_DRIVER === 'smtp') {
    echo "- SMTP Host: " . SMTP_HOST . "\n";
    echo "- SMTP Port: " . SMTP_PORT . "\n";
    echo "- SMTP User: " . SMTP_USER . "\n";
    echo "- SMTP Secure: " . SMTP_SECURE . "\n";
}

echo "\n";

// Verificar que PHPMailer esté disponible
if (class_exists('\PHPMailer\PHPMailer\PHPMailer')) {
    echo "✓ PHPMailer está instalado\n\n";
} else {
    echo "✗ PHPMailer NO está instalado\n\n";
    exit(1);
}

// Pedir email de destino
if (php_sapi_name() === 'cli') {
    echo "Ingresa el email de destino para la prueba: ";
    $emailDestino = trim(fgets(STDIN));
} else {
    // Si se ejecuta desde el navegador
    $emailDestino = isset($_GET['email']) ? $_GET['email'] : 'test@example.com';
    echo "Email de destino: $emailDestino<br>\n";
}

if (empty($emailDestino) || !filter_var($emailDestino, FILTER_VALIDATE_EMAIL)) {
    echo "Email inválido\n";
    exit(1);
}

echo "Enviando email de prueba a: $emailDestino\n\n";

try {
    $email = new EmailHelper();
    
    // Generar contraseña temporal de prueba
    $clave_temporal = EmailHelper::generateTempPassword(12);
    
    echo "Contraseña temporal generada: $clave_temporal\n\n";
    
    // Cargar plantilla
    $email->setTo($emailDestino, 'Usuario de Prueba')
        ->setSubject('Prueba de Recuperación de Contraseña - StarHotelHub')
        ->loadTemplate('recuperar_contrasena', [
            'nombre' => 'Usuario de Prueba',
            'correo' => $emailDestino,
            'clave_temporal' => $clave_temporal
        ]);
    
    echo "Plantilla cargada correctamente\n";
    echo "Intentando enviar email...\n\n";
    
    // Enviar
    $resultado = $email->send();
    
    if ($resultado) {
        echo "✓ EMAIL ENVIADO EXITOSAMENTE\n";
        echo "Revisa la bandeja de entrada de: $emailDestino\n";
    } else {
        echo "✗ ERROR AL ENVIAR EMAIL\n";
        echo "Revisa los logs para más detalles\n";
    }
    
} catch (Exception $e) {
    echo "✗ EXCEPCIÓN CAPTURADA:\n";
    echo "Mensaje: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
}

echo "\n=== FIN DEL TEST ===\n";

