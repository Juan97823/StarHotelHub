# Configuración de Gmail para StarHotelHub

## Problema
Si estás recibiendo errores de autenticación al intentar enviar emails, es probable que necesites generar una "Contraseña de Aplicación" en lugar de usar tu contraseña de Gmail normal.

## Solución

### Paso 1: Habilitar la Autenticación de Dos Factores (2FA)
1. Ve a https://myaccount.google.com/
2. Haz clic en "Seguridad" en el menú izquierdo
3. Busca "Autenticación de dos pasos" y habilítala si no está habilitada

### Paso 2: Generar una Contraseña de Aplicación
1. Ve a https://myaccount.google.com/apppasswords
2. Selecciona:
   - **Aplicación**: "Correo"
   - **Dispositivo**: "Windows" (o tu sistema operativo)
3. Google te generará una contraseña de 16 caracteres
4. Copia esa contraseña

### Paso 3: Actualizar la Configuración
1. Abre el archivo `config/email.php`
2. Reemplaza la línea:
   ```php
   define('SMTP_PASS', getenv('SMTP_PASS') ?: 'Jbemaz10');
   ```
   Con:
   ```php
   define('SMTP_PASS', getenv('SMTP_PASS') ?: 'AQUI_VA_LA_CONTRASEÑA_DE_APLICACION');
   ```
3. Reemplaza `AQUI_VA_LA_CONTRASEÑA_DE_APLICACION` con la contraseña que Google te generó

### Paso 4: Probar la Conexión
1. Ve a http://localhost/Starhotelhub/test-smtp.php
2. Deberías ver "✅ Email enviado exitosamente"

## Alternativa: Usar una Contraseña Normal
Si no quieres usar una contraseña de aplicación, puedes:
1. Habilitar "Acceso de aplicaciones menos seguras" en https://myaccount.google.com/lesssecureapps
2. Usar tu contraseña normal de Gmail

## Errores Comunes

### "SMTP connect() failed"
- Verifica que SMTP_HOST sea `smtp.gmail.com`
- Verifica que SMTP_PORT sea `587`
- Verifica que SMTP_SECURE sea `tls`

### "Username and Password not accepted"
- Verifica que SMTP_USER sea `starhotelhub@gmail.com`
- Verifica que SMTP_PASS sea la contraseña de aplicación correcta
- Verifica que no haya espacios en blanco

### "Timeout"
- Verifica tu conexión a internet
- Intenta aumentar el timeout en EmailHelper.php

## Archivos de Prueba
- `test-smtp.php` - Prueba la conexión SMTP
- `test-registro.php` - Prueba el envío de email de registro
- `test-form.php` - Prueba el formulario completo

