<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña - StarHotelHub</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #333;
        }
        .message {
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        .password-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 30px 0;
            border-radius: 4px;
        }
        .password-label {
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        .password-value {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
            word-break: break-all;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
            font-size: 13px;
        }
        .warning strong {
            display: block;
            margin-bottom: 5px;
        }
        .instructions {
            background-color: #e7f3ff;
            border: 1px solid #b3d9ff;
            color: #004085;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
            font-size: 13px;
        }
        .instructions ol {
            margin: 10px 0;
            padding-left: 20px;
        }
        .instructions li {
            margin: 8px 0;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
            font-size: 14px;
        }
        .button:hover {
            opacity: 0.9;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #e0e0e0;
        }
        .footer p {
            margin: 5px 0;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: white;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">StarHotelHub</div>
            <h1>Recuperación de Contraseña</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                ¡Hola <strong><?php echo htmlspecialchars($nombre); ?></strong>!
            </div>

            <div class="message">
                Hemos recibido una solicitud para recuperar tu contraseña en StarHotelHub. 
                A continuación encontrarás tu contraseña temporal para acceder a tu cuenta.
            </div>

            <!-- Contraseña Temporal -->
            <div class="password-box">
                <div class="password-label">Tu contraseña temporal es:</div>
                <div class="password-value"><?php echo htmlspecialchars($clave_temporal); ?></div>
            </div>

            <!-- Instrucciones -->
            <div class="instructions">
                <strong>Pasos a seguir:</strong>
                <ol>
                    <li>Accede a tu cuenta usando esta contraseña temporal</li>
                    <li>Ve a tu perfil o configuración de cuenta</li>
                    <li>Cambia tu contraseña por una nueva y segura</li>
                    <li>Guarda los cambios</li>
                </ol>
            </div>

            <!-- Advertencia -->
            <div class="warning">
                <strong>Importante:</strong>
                Esta contraseña temporal es válida por 24 horas. 
                Si no la utilizas en este tiempo, deberás solicitar una nueva recuperación de contraseña.
            </div>

            <!-- Botón de Acción -->
            <div class="button-container">
                <a href="<?php echo RUTA_PRINCIPAL; ?>login" class="button">Ir al Login</a>
            </div>

            <!-- Mensaje de Seguridad -->
            <div class="message" style="font-size: 12px; color: #999; margin-top: 30px;">
                Si no solicitaste esta recuperación de contraseña, por favor ignora este email. 
                Tu cuenta seguirá siendo segura con tu contraseña actual.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>StarHotelHub</strong></p>
            <p>Sistema de Gestión de Reservas Hoteleras</p>
            <p>&copy; <?php echo date('Y'); ?> StarHotelHub. Todos los derechos reservados.</p>
            <p>
                <a href="<?php echo RUTA_PRINCIPAL; ?>" style="color: #667eea; text-decoration: none;">
                    Visita nuestro sitio web
                </a>
            </p>
        </div>
    </div>
</body>
</html>

