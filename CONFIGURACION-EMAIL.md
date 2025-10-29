# Configuración de Email - StarHotelHub

## Opciones Disponibles

### Opción 1: Gmail (Recomendado para desarrollo)

#### Paso 1: Habilitar 2FA en Gmail
1. Ir a https://myaccount.google.com/security
2. Habilitar "Verificación en dos pasos"

#### Paso 2: Generar contraseña de aplicación
1. Ir a https://myaccount.google.com/apppasswords
2. Seleccionar "Correo" y "Windows"
3. Copiar la contraseña generada (16 caracteres)

#### Paso 3: Configurar en `config/email.php`
```php
define('EMAIL_DRIVER', 'smtp');
define('EMAIL_FROM', 'tu_email@gmail.com');
define('EMAIL_FROM_NAME', 'StarHotelHub');
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'tu_email@gmail.com');
define('SMTP_PASS', 'contraseña_de_aplicacion_16_caracteres');
define('SMTP_SECURE', 'tls');
```

#### Paso 4: Probar
```
http://3.88.220.138/verificar-instalacion.php
```

---

### Opción 2: Mailtrap (Mejor para desarrollo/pruebas)

#### Paso 1: Crear cuenta
1. Ir a https://mailtrap.io
2. Registrarse (gratuito)
3. Crear un proyecto

#### Paso 2: Obtener credenciales
1. En el dashboard, ir a "Integrations"
2. Seleccionar "PHPMailer"
3. Copiar las credenciales

#### Paso 3: Configurar en `config/email.php`
```php
define('EMAIL_DRIVER', 'smtp');
define('EMAIL_FROM', 'noreply@starhotelhub.com');
define('EMAIL_FROM_NAME', 'StarHotelHub');
define('SMTP_HOST', 'smtp.mailtrap.io');
define('SMTP_PORT', 2525);
define('SMTP_USER', 'tu_usuario_mailtrap');
define('SMTP_PASS', 'tu_contraseña_mailtrap');
define('SMTP_SECURE', 'tls');
```

#### Ventajas:
- ✅ Todos los emails se capturan en el dashboard
- ✅ Perfecto para pruebas
- ✅ No envía emails reales
- ✅ Puedes ver el contenido exacto

---

### Opción 3: SendGrid (Recomendado para producción)

#### Paso 1: Crear cuenta
1. Ir a https://sendgrid.com
2. Registrarse (100 emails gratis/mes)
3. Verificar email

#### Paso 2: Obtener API Key
1. En el dashboard, ir a "Settings" → "API Keys"
2. Crear nueva API Key
3. Copiar la clave

#### Paso 3: Configurar en `config/email.php`
```php
define('EMAIL_DRIVER', 'smtp');
define('EMAIL_FROM', 'noreply@starhotelhub.com');
define('EMAIL_FROM_NAME', 'StarHotelHub');
define('SMTP_HOST', 'smtp.sendgrid.net');
define('SMTP_PORT', 587);
define('SMTP_USER', 'apikey');
define('SMTP_PASS', 'tu_api_key_sendgrid');
define('SMTP_SECURE', 'tls');
```

#### Ventajas:
- ✅ Profesional
- ✅ Buena entregabilidad
- ✅ Estadísticas de envío
- ✅ 100 emails gratis/mes

---

### Opción 4: Servidor SMTP Local (Postfix)

#### Paso 1: Instalar Postfix
```bash
sudo apt install postfix -y
# Seleccionar "Internet Site" durante la instalación
```

#### Paso 2: Configurar en `config/email.php`
```php
define('EMAIL_DRIVER', 'mail'); // Usar PHP mail()
define('EMAIL_FROM', 'noreply@3.88.220.138');
define('EMAIL_FROM_NAME', 'StarHotelHub');
```

#### Ventajas:
- ✅ Gratuito
- ✅ Sin dependencias externas
- ✅ Control total

#### Desventajas:
- ❌ Puede llegar a spam
- ❌ Requiere configuración DNS
- ❌ Menos confiable

---

### Opción 5: AWS SES (Para producción a escala)

#### Paso 1: Crear cuenta AWS
1. Ir a https://aws.amazon.com
2. Crear cuenta
3. Ir a SES (Simple Email Service)

#### Paso 2: Verificar dominio
1. En SES, ir a "Domains"
2. Agregar tu dominio
3. Verificar registros DNS

#### Paso 3: Obtener credenciales
1. Ir a "SMTP Settings"
2. Crear usuario IAM con permisos SES
3. Copiar credenciales

#### Paso 4: Configurar en `config/email.php`
```php
define('EMAIL_DRIVER', 'smtp');
define('EMAIL_FROM', 'noreply@tu-dominio.com');
define('EMAIL_FROM_NAME', 'StarHotelHub');
define('SMTP_HOST', 'email-smtp.region.amazonaws.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'tu_usuario_iam');
define('SMTP_PASS', 'tu_contraseña_iam');
define('SMTP_SECURE', 'tls');
```

---

## Recomendaciones por Entorno

### Desarrollo Local
```
Usar: Mailtrap
Razón: Captura todos los emails, no envía reales
```

### Staging/Pruebas
```
Usar: Mailtrap o Gmail
Razón: Seguro, no afecta usuarios reales
```

### Producción
```
Usar: SendGrid o AWS SES
Razón: Profesional, confiable, escalable
```

---

## Prueba de Configuración

### Script de prueba
```php
<?php
require_once 'config/config.php';
require_once 'config/email.php';
require_once 'app/Helpers/EmailHelper.php';

try {
    $email = new EmailHelper();
    $email->setTo('tu_email@example.com', 'Nombre')
        ->setSubject('Prueba de Email')
        ->setBody('Este es un email de prueba')
        ->send();
    
    echo "Email enviado correctamente";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
```

### Verificar en `verificar-instalacion.php`
```
http://3.88.220.138/verificar-instalacion.php
```

---

## Solución de Problemas

### "SMTP connect() failed"
- Verificar host y puerto
- Verificar credenciales
- Verificar firewall

### "Authentication failed"
- Verificar usuario y contraseña
- Para Gmail: usar contraseña de aplicación, no la contraseña normal
- Para SendGrid: usuario debe ser "apikey"

### "Connection timed out"
- Verificar puerto (587 para TLS, 465 para SSL)
- Verificar firewall del servidor
- Verificar que SMTP_SECURE sea correcto

### Emails llegan a spam
- Configurar SPF, DKIM, DMARC
- Usar dominio propio (no Gmail)
- Usar SendGrid o AWS SES

---

## Variables de Entorno (Recomendado)

En lugar de hardcodear en `config/email.php`, usar variables de entorno:

### Crear archivo `.env`
```
EMAIL_DRIVER=smtp
EMAIL_FROM=noreply@starhotelhub.com
EMAIL_FROM_NAME=StarHotelHub
SMTP_HOST=smtp.sendgrid.net
SMTP_PORT=587
SMTP_USER=apikey
SMTP_PASS=tu_api_key_aqui
SMTP_SECURE=tls
```

### Usar en `config/email.php`
```php
define('EMAIL_DRIVER', getenv('EMAIL_DRIVER') ?: 'smtp');
define('EMAIL_FROM', getenv('EMAIL_FROM') ?: 'noreply@starhotelhub.com');
// ... etc
```

---

## Resumen Rápido

| Opción | Desarrollo | Producción | Costo | Facilidad |
|--------|-----------|-----------|-------|-----------|
| Gmail | ✅ | ❌ | Gratis | Fácil |
| Mailtrap | ✅✅ | ❌ | Gratis | Muy Fácil |
| SendGrid | ✅ | ✅✅ | Gratis/Pago | Fácil |
| Postfix | ✅ | ⚠️ | Gratis | Difícil |
| AWS SES | ✅ | ✅✅ | Pago | Difícil |

**Recomendación**: Usa **Mailtrap** para desarrollo y **SendGrid** para producción.

