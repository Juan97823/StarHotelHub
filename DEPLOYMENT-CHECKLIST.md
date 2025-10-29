# Checklist de Despliegue - StarHotelHub

## Configuración completada para: http://3.88.220.138/

### 1. Configuración de Rutas
- [x] `config/config.php` - RUTA_PRINCIPAL actualizada a `http://3.88.220.138/`
- [x] `.htaccess` - RewriteBase actualizado a `/`
- [x] `assets/principal/js/pages/clientes.js` - Usa `base_url` global

### 2. Verificaciones antes de desplegar

#### Base de Datos
- [ ] Crear base de datos `starhotelhub` en el servidor
- [ ] Importar estructura de tablas (usuarios, habitaciones, reservas, etc.)
- [ ] Verificar credenciales de conexión en variables de entorno:
  - `DB_HOST` (default: localhost)
  - `DB_USER` (default: root)
  - `DB_PASS` (default: vacío)
  - `DB_NAME` (default: starhotelhub)

#### Servidor Web
- [ ] Apache con mod_rewrite habilitado
- [ ] PHP 7.4+ instalado
- [ ] Extensiones PHP requeridas:
  - `php-mysql` o `php-pdo`
  - `php-gd` (para imágenes)
  - `php-curl` (para emails)
  - `php-mbstring`

#### Permisos de Carpetas
- [ ] `uploads/` - Permiso 755 (lectura/escritura)
- [ ] `logs/` - Permiso 755 (lectura/escritura)
- [ ] `tmp/` - Permiso 755 (lectura/escritura)

#### SSL/HTTPS
- [ ] Certificado SSL instalado (recomendado)
- [ ] Redireccionamiento HTTP → HTTPS configurado
- [ ] `config/config.php` línea 29: Verificar que `secure` sea `true` en HTTPS

### 3. Configuración de Email
- [ ] Configurar `config/email.php` con credenciales SMTP
- [ ] Opciones:
  - Mailtrap (desarrollo/pruebas)
  - SendGrid (producción)
  - Gmail (con contraseña de aplicación)
  - Servidor SMTP local

### 4. Archivos a Verificar

#### Rutas Hardcodeadas (TODAS CORREGIDAS)
- [x] `assets/principal/js/pages/clientes.js` - Usa `base_url`
- [x] Todas las imágenes usan `RUTA_PRINCIPAL`
- [x] Todos los scripts usan `RUTA_PRINCIPAL`

#### Archivos de Configuración
- [x] `config/config.php` - Actualizado
- [x] `.htaccess` - Actualizado
- [x] `config/email.php` - Revisar credenciales

### 5. Pruebas Funcionales

#### Autenticación
- [ ] Registro de usuario
- [ ] Login con credenciales correctas
- [ ] Login con credenciales incorrectas
- [ ] Recuperación de contraseña
- [ ] Verificación de email

#### Reservas
- [ ] Búsqueda de habitaciones en página principal
- [ ] Validación de fechas (salida > llegada)
- [ ] Verificación de disponibilidad
- [ ] Crear reserva
- [ ] Ver historial de reservas

#### Admin
- [ ] Login como administrador
- [ ] Gestión de habitaciones
- [ ] Gestión de usuarios
- [ ] Gestión de reservas
- [ ] Reportes

#### Empleado
- [ ] Login como empleado
- [ ] Ver reservas
- [ ] Gestionar reservas

### 6. Seguridad

- [ ] HTTPS habilitado
- [ ] Cookies seguras configuradas
- [ ] CSRF tokens funcionando
- [ ] SQL Injection protegido (prepared statements)
- [ ] XSS protegido (htmlspecialchars)
- [ ] Contraseñas hasheadas (password_hash)

### 7. Optimización

- [ ] Caché de navegador configurado
- [ ] Compresión GZIP habilitada
- [ ] Imágenes optimizadas
- [ ] Minificación de CSS/JS (opcional)

### 8. Monitoreo

- [ ] Logs de errores configurados
- [ ] Monitoreo de base de datos
- [ ] Backups automáticos configurados
- [ ] Alertas de errores configuradas

---

## Pasos de Despliegue

1. **Subir archivos al servidor**
   ```bash
   scp -r /ruta/local/Starhotelhub/* usuario@3.88.220.138:/var/www/html/
   ```

2. **Configurar permisos**
   ```bash
   chmod 755 uploads/ logs/ tmp/
   chmod 644 config/config.php
   ```

3. **Crear base de datos**
   ```bash
   mysql -u root -p < database.sql
   ```

4. **Verificar configuración**
   - Visitar: http://3.88.220.138/
   - Verificar que todas las rutas funcionen
   - Probar login/registro

5. **Habilitar HTTPS**
   - Instalar certificado SSL
   - Configurar redirección en `.htaccess`

---

## Contacto y Soporte

Si hay problemas después del despliegue:
1. Revisar logs de Apache: `/var/log/apache2/error.log`
2. Revisar logs de PHP: `/var/log/php-fpm.log`
3. Verificar permisos de carpetas
4. Verificar conexión a base de datos

