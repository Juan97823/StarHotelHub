# Guía de Despliegue - StarHotelHub en http://3.88.220.138/

## Paso 1: Preparar el Servidor

### 1.1 Instalar dependencias
```bash
# Actualizar sistema
sudo apt update && sudo apt upgrade -y

# Instalar Apache, PHP y MySQL
sudo apt install apache2 php php-mysql php-gd php-curl php-mbstring -y

# Habilitar mod_rewrite
sudo a2enmod rewrite

# Reiniciar Apache
sudo systemctl restart apache2
```

### 1.2 Crear base de datos
```bash
# Conectar a MySQL
mysql -u root -p

# Crear base de datos
CREATE DATABASE starhotelhub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Crear usuario
CREATE USER 'starhotel'@'localhost' IDENTIFIED BY 'Jbemaz10978';

# Otorgar permisos
GRANT ALL PRIVILEGES ON starhotelhub.* TO 'starhotel'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

## Paso 2: Subir Archivos

### 2.1 Opción A: Usando SCP
```bash
scp -r /ruta/local/Starhotelhub/* usuario@3.88.220.138:/var/www/html/
```

### 2.2 Opción B: Usando Git
```bash
cd /var/www/html
git clone https://tu-repo.git .
```

### 2.3 Opción C: Usando FTP
- Conectar con FileZilla
- Subir todos los archivos a `/var/www/html/`

## Paso 3: Configurar Permisos

```bash
# Cambiar propietario
sudo chown -R www-data:www-data /var/www/html

# Configurar permisos
sudo chmod 755 /var/www/html
sudo chmod 755 /var/www/html/uploads
sudo chmod 755 /var/www/html/logs
sudo chmod 755 /var/www/html/tmp
sudo chmod 644 /var/www/html/config/config.php
```

## Paso 4: Configurar Variables de Entorno

### 4.1 Crear archivo `.env` (opcional pero recomendado)
```bash
nano /var/www/html/.env
```

Contenido:
```
DB_HOST=localhost
DB_USER=starhotel
DB_PASS=tu_contraseña_segura
DB_NAME=starhotelhub
```

### 4.2 O configurar en `config/config.php`
```php
define('HOST', 'localhost');
define('USER', 'starhotel');
define('PASS', 'tu_contraseña_segura');
define('DATABASE', 'starhotelhub');
```

## Paso 5: Importar Base de Datos

```bash
# Si tienes un archivo SQL
mysql -u starhotel -p starhotelhub < database.sql

# O crear tablas manualmente
mysql -u starhotel -p starhotelhub < /var/www/html/database/schema.sql
```

## Paso 6: Configurar Apache

### 6.1 Crear archivo de configuración virtual host
```bash
sudo nano /etc/apache2/sites-available/starhotelhub.conf
```

Contenido:
```apache
<VirtualHost *:80>
    ServerName 3.88.220.138
    ServerAdmin admin@starhotelhub.com
    DocumentRoot /var/www/html

    <Directory /var/www/html>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/starhotelhub-error.log
    CustomLog ${APACHE_LOG_DIR}/starhotelhub-access.log combined
</VirtualHost>
```

### 6.2 Habilitar sitio
```bash
sudo a2ensite starhotelhub.conf
sudo systemctl reload apache2
```

## Paso 7: Configurar HTTPS (Recomendado)

### 7.1 Instalar Certbot
```bash
sudo apt install certbot python3-certbot-apache -y
```

### 7.2 Obtener certificado
```bash
sudo certbot --apache -d 3.88.220.138
```

### 7.3 Configurar redirección HTTP → HTTPS
```bash
sudo nano /etc/apache2/sites-available/starhotelhub.conf
```

Agregar:
```apache
<VirtualHost *:80>
    ServerName 3.88.220.138
    Redirect permanent / https://3.88.220.138/
</VirtualHost>
```

## Paso 8: Configurar Email

### 8.1 Opción A: Usar Mailtrap (Desarrollo)
1. Ir a https://mailtrap.io
2. Crear cuenta gratuita
3. Obtener credenciales SMTP
4. Actualizar `config/email.php`

### 8.2 Opción B: Usar SendGrid (Producción)
1. Crear cuenta en https://sendgrid.com
2. Obtener API key
3. Configurar en `config/email.php`

### 8.3 Opción C: Usar servidor SMTP local
```bash
sudo apt install postfix -y
```

## Paso 9: Verificar Instalación

### 9.1 Ejecutar script de verificación
```
http://3.88.220.138/verificar-instalacion.php
```

### 9.2 Revisar logs
```bash
# Logs de Apache
sudo tail -f /var/log/apache2/error.log

# Logs de PHP
sudo tail -f /var/log/php-fpm.log
```

## Paso 10: Pruebas Finales

1. **Acceder a la página principal**
   - http://3.88.220.138/

2. **Probar registro**
   - Crear nueva cuenta
   - Verificar email

3. **Probar login**
   - Iniciar sesión con credenciales

4. **Probar reservas**
   - Buscar habitaciones
   - Crear reserva

5. **Probar admin**
   - Acceder a http://3.88.220.138/admin
   - Gestionar habitaciones y usuarios

## Solución de Problemas

### Error 404 en rutas
- Verificar que mod_rewrite esté habilitado
- Revisar `.htaccess`
- Reiniciar Apache: `sudo systemctl restart apache2`

### Error de conexión a BD
- Verificar credenciales en `config/config.php`
- Verificar que MySQL esté corriendo: `sudo systemctl status mysql`
- Verificar permisos de usuario en MySQL

### Error de permisos
- Verificar propietario: `ls -la /var/www/html`
- Cambiar permisos: `sudo chown -R www-data:www-data /var/www/html`

### Emails no se envían
- Verificar configuración en `config/email.php`
- Revisar logs: `sudo tail -f /var/log/mail.log`
- Probar con `verificar-instalacion.php`

## Mantenimiento

### Backups automáticos
```bash
# Crear script de backup
sudo nano /usr/local/bin/backup-starhotelhub.sh
```

### Monitoreo
- Configurar alertas de errores
- Revisar logs regularmente
- Monitorear uso de disco y memoria

---

**¡Listo!** Tu proyecto StarHotelHub está desplegado en http://3.88.220.138/

