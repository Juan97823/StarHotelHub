<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Registro - StarHotelHub</title>
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
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #008cff;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #008cff;
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 20px 0;
        }
        .content h2 {
            color: #333;
            font-size: 20px;
            margin-top: 0;
        }
        .credentials {
            background-color: #f9f9f9;
            border-left: 4px solid #008cff;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .credentials p {
            margin: 10px 0;
            font-size: 14px;
        }
        .credentials strong {
            color: #008cff;
        }
        .button {
            display: inline-block;
            background-color: #008cff;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            background-color: #0073cc;
        }
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            color: #856404;
        }
        .footer {
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 20px;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏨 StarHotelHub</h1>
            <p style="margin: 10px 0 0 0; color: #666;">Bienvenido a nuestra plataforma</p>
        </div>

        <div class="content">
            <h2>¡Hola <?php echo htmlspecialchars($nombre); ?>!</h2>
            
            <p>Gracias por registrarte en <strong>StarHotelHub</strong>. Tu cuenta ha sido creada exitosamente.</p>

            <p>Para activar tu cuenta y completar tu registro, haz clic en el botón de abajo:</p>

            <center>
                <a href="<?php echo htmlspecialchars($confirmLink); ?>" class="button">Confirmar mi cuenta</a>
            </center>

            <p>Si el botón no funciona, copia y pega el siguiente enlace en tu navegador:</p>
            <p><a href="<?php echo htmlspecialchars($confirmLink); ?>"><?php echo htmlspecialchars($confirmLink); ?></a></p>

            <p><strong>¿Necesitas ayuda?</strong></p>
            <p>Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos a través de nuestro formulario de contacto o enviando un correo a <strong>starhotelhub@gmail.com</strong>.</p>

            <p>¡Esperamos que disfrutes tu experiencia con nosotros!</p>
        </div>

        <div class="footer">
            <p>&copy; <?php echo date('Y'); ?> StarHotelHub. Todos los derechos reservados.</p>
            <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
        </div>
    </div>
</body>
</html>

