<?php
/**
 * Script de Prueba de Email
 * Ejecutar en: http://3.88.220.138/test-email-produccion.php
 * 
 * IMPORTANTE: Eliminar este archivo después de probar en producción
 */

require_once 'config/config.php';
require_once 'config/email.php';
require_once 'app/Helpers/EmailHelper.php';

$resultado = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_destino = $_POST['email'] ?? '';
    $nombre_destino = $_POST['nombre'] ?? 'Usuario';
    
    if (empty($email_destino)) {
        $error = 'Por favor ingresa un email';
    } else if (!filter_var($email_destino, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email inválido';
    } else {
        try {
            $email = new EmailHelper();
            $email->setTo($email_destino, $nombre_destino)
                ->setSubject('Prueba de Email - StarHotelHub')
                ->setBody('
                    <h2>Prueba de Email</h2>
                    <p>Este es un email de prueba desde StarHotelHub.</p>
                    <p><strong>Configuración:</strong></p>
                    <ul>
                        <li>Driver: ' . EMAIL_DRIVER . '</li>
                        <li>Host: ' . SMTP_HOST . '</li>
                        <li>Puerto: ' . SMTP_PORT . '</li>
                        <li>Usuario: ' . SMTP_USER . '</li>
                    </ul>
                    <p>Si recibes este email, la configuración es correcta.</p>
                ')
                ->send();
            
            $resultado = 'Email enviado correctamente a: ' . htmlspecialchars($email_destino);
        } catch (Exception $e) {
            $error = 'Error al enviar email: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de Email - StarHotelHub</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 30px; text-align: center; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: 500; margin-bottom: 8px; color: #333; }
        input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        input:focus { outline: none; border-color: #007bff; box-shadow: 0 0 5px rgba(0,123,255,0.3); }
        button { width: 100%; padding: 12px; background: #007bff; color: white; border: none; border-radius: 4px; font-size: 16px; font-weight: 600; cursor: pointer; }
        button:hover { background: #0056b3; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info { background: #e7f3ff; color: #004085; border: 1px solid #b3d9ff; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .config { background: #f9f9f9; padding: 15px; border-radius: 4px; margin-top: 20px; }
        .config h3 { color: #333; margin-bottom: 10px; }
        .config p { color: #666; margin: 5px 0; font-size: 14px; }
        .warning { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; padding: 15px; border-radius: 4px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Prueba de Email</h1>

        <div class="info">
            <strong>Información:</strong> Este script prueba la configuración de email del servidor.
            <br><strong>Importante:</strong> Elimina este archivo después de probar en producción.
        </div>

        <?php if ($resultado): ?>
            <div class="alert alert-success">
                <strong>Éxito:</strong> <?php echo htmlspecialchars($resultado); ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error">
                <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="nombre">Nombre (opcional)</label>
                <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="email">Email de destino</label>
                <input type="email" id="email" name="email" placeholder="tu@email.com" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            </div>

            <button type="submit">Enviar Email de Prueba</button>
        </form>

        <div class="config">
            <h3>Configuración Actual</h3>
            <p><strong>Driver:</strong> <?php echo htmlspecialchars(EMAIL_DRIVER); ?></p>
            <p><strong>Email From:</strong> <?php echo htmlspecialchars(EMAIL_FROM); ?></p>
            <p><strong>Nombre From:</strong> <?php echo htmlspecialchars(EMAIL_FROM_NAME); ?></p>
            <p><strong>SMTP Host:</strong> <?php echo htmlspecialchars(SMTP_HOST); ?></p>
            <p><strong>SMTP Port:</strong> <?php echo htmlspecialchars(SMTP_PORT); ?></p>
            <p><strong>SMTP User:</strong> <?php echo htmlspecialchars(SMTP_USER); ?></p>
            <p><strong>SMTP Secure:</strong> <?php echo htmlspecialchars(SMTP_SECURE); ?></p>
        </div>

        <div class="warning">
            <strong>⚠️ Advertencia:</strong> Este archivo es solo para pruebas. 
            <br>Elimínalo del servidor después de verificar que el email funciona correctamente.
            <br>Ruta: <code>test-email-produccion.php</code>
        </div>
    </div>
</body>
</html>

