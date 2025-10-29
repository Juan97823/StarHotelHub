# Cambios Realizados para Despliegue en AWS

## Fecha: 2025-10-29

### Resumen
Se realizaron cambios para asegurar la compatibilidad del proyecto StarHotelHub con servidores Linux (AWS), donde el sistema de archivos es **case-sensitive** (distingue entre mayúsculas y minúsculas).

---

## 📁 Cambios en Estructura de Archivos

### 1. Carpetas Renombradas
- ✅ `app/Helpers` → `app/helpers` (minúsculas)

### 2. Archivos de Imágenes Renombrados
- ✅ `assets/img/Logo.png` → `assets/img/logo.png`
- ✅ `assets/img/Alojamiento.avif` → `assets/img/alojamiento.avif`
- ✅ `assets/img/RoomLujo.jpg` → `assets/img/roomlujo.jpg`

---

## 🔧 Archivos PHP Actualizados

### Controladores con Referencias a `app/Helpers` → `app/helpers`

1. **controllers/Principal/Contacto.php**
   - Línea 85: `require_once RUTA_RAIZ . '/app/helpers/EmailHelper.php';`

2. **controllers/Principal/OlvideContrasena.php**
   - Línea 63: `require_once RUTA_RAIZ . '/app/helpers/EmailHelper.php';`
   - Línea 93: `require_once RUTA_RAIZ . '/app/helpers/EmailHelper.php';`

3. **controllers/Principal/Registro.php**
   - Línea 133: `require_once RUTA_RAIZ . '/app/helpers/EmailHelper.php';`

4. **controllers/Principal/Reserva.php**
   - Línea 54: `require_once RUTA_RAIZ . '/app/helpers/EmailHelper.php';`
   - Línea 362: `require_once RUTA_RAIZ . '/app/helpers/EmailHelper.php';`

---

## 🖼️ Vistas con Referencias a `Logo.png` → `logo.png`

1. **views/principal/Login.php**
   - Actualizado: `assets/img/logo.png`

2. **views/template/footer-login.php**
   - Actualizado: `assets/img/logo.png`

3. **views/template/footer-principal.php**
   - Actualizado: `assets/img/logo.png`

4. **views/template/header-admin.php**
   - Favicon: `assets/img/logo.png`
   - Logo sidebar: `assets/img/logo.png`

5. **views/template/header-cliente.php**
   - Favicon: `assets/img/logo.png`
   - Logo sidebar: `assets/img/logo.png`

6. **views/template/header-empleado.php**
   - Favicon: `assets/img/logo.png`
   - Logo sidebar: `assets/img/logo.png`
   - Avatar usuario: `assets/img/logo.png`

7. **views/template/header-principal.php**
   - Favicon: `assets/img/logo.png`
   - Logo navbar: `assets/img/logo.png`

---

## 📧 Configuración de Email (Verificada)

### Archivo: `config/email.php`

**Configuración SMTP para Gmail:**
```php
define('EMAIL_DRIVER', 'smtp');
define('EMAIL_FROM', 'starhotelhub@gmail.com');
define('EMAIL_FROM_NAME', 'StarHotelHub');
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'starhotelhub@gmail.com');
define('SMTP_PASS', 'lofwwzbsmhtyywgx'); // App Password de Gmail
define('SMTP_SECURE', 'tls');
```

**✅ Estado:** Configuración correcta para envío de emails

---

## 🔍 Funcionalidades Verificadas

### 1. Formulario de Contacto
- **Controlador:** `controllers/Principal/Contacto.php`
- **Modelo:** `models/principal/ContactoModel.php`
- **Funcionalidad:**
  - ✅ Validación de campos (nombre, correo, teléfono, asunto, mensaje)
  - ✅ Sanitización de datos
  - ✅ Guardado en base de datos (tabla `contactos`)
  - ✅ Envío de 2 emails:
    1. Al admin (starhotelhub@gmail.com) con detalles del mensaje
    2. Al remitente con confirmación de recepción
  - ✅ Fallback a `mail()` si SMTP falla

### 2. EmailHelper
- **Ubicación:** `app/helpers/EmailHelper.php`
- **Características:**
  - ✅ Soporte SMTP y PHP mail()
  - ✅ Configuración desde variables de entorno
  - ✅ Plantillas de email
  - ✅ Adjuntos
  - ✅ Logging de errores
  - ✅ Fallback automático

---

## 🚀 Pasos para Despliegue en AWS

### 1. Subir Archivos
```bash
# Asegurarse de que todos los archivos se suban con los nombres correctos
# (minúsculas donde corresponda)
```

### 2. Configurar Permisos
```bash
# En el servidor AWS
chmod -R 755 /var/www/html/starhotelhub
chown -R www-data:www-data /var/www/html/starhotelhub
```

### 3. Verificar PHP Extensions
```bash
# Asegurarse de que estén instaladas:
- php-mbstring
- php-mysqli
- php-curl
- php-xml
```

### 4. Configurar Base de Datos
- Host: localhost
- Usuario: starhub_user
- Contraseña: StarHub2025!
- Base de datos: starhotelhub

### 5. Verificar Email
```bash
# Probar envío de email desde el servidor
# El formulario de contacto debería funcionar automáticamente
```

---

## ✅ Checklist de Verificación

- [x] Carpeta `app/helpers` en minúsculas
- [x] Todas las referencias a `app/Helpers` actualizadas
- [x] Archivos de imágenes en minúsculas
- [x] Todas las referencias a `Logo.png` actualizadas
- [x] Configuración SMTP verificada
- [x] EmailHelper funcionando correctamente
- [x] Formulario de contacto listo

---

## 📝 Notas Importantes

1. **Case Sensitivity:** Linux distingue entre mayúsculas y minúsculas. Todos los archivos y referencias deben coincidir exactamente.

2. **Email SMTP:** La contraseña configurada es una "App Password" de Gmail, no la contraseña normal de la cuenta.

3. **Fallback:** Si SMTP falla, el sistema intentará usar `mail()` de PHP automáticamente.

4. **Logs:** Los errores de email se registran en `error_log` de PHP para debugging.

---

## 🔗 URLs del Proyecto

- **Producción:** http://3.88.220.138/
- **Admin:** http://3.88.220.138/admin
- **Contacto:** http://3.88.220.138/contacto

---

## 👤 Contacto

Para soporte técnico: starhotelhub@gmail.com

