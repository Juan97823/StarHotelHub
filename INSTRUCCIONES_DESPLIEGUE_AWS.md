# 🚀 Instrucciones de Despliegue en AWS - StarHotelHub

## ✅ Cambios Completados

Todos los cambios necesarios para la compatibilidad con Linux (AWS) han sido realizados:

### 1. Archivos y Carpetas Renombrados
- ✅ `app/Helpers` → `app/helpers`
- ✅ `assets/img/Logo.png` → `assets/img/logo.png`
- ✅ `assets/img/Alojamiento.avif` → `assets/img/alojamiento.avif`
- ✅ `assets/img/RoomLujo.jpg` → `assets/img/roomlujo.jpg`

### 2. Referencias Actualizadas en Código
- ✅ 6 archivos PHP actualizados con rutas a `app/helpers/EmailHelper.php`
- ✅ 7 archivos de vistas actualizados con rutas a `assets/img/logo.png`

### 3. Configuración de Email Verificada
- ✅ SMTP configurado correctamente para Gmail
- ✅ EmailHelper funcionando con fallback a mail()

---

## 📋 Pasos para Subir a AWS

### Paso 1: Conectarse al Servidor AWS
```bash
ssh -i tu-clave.pem ubuntu@3.88.220.138
```

### Paso 2: Preparar el Directorio
```bash
# Ir al directorio web
cd /var/www/html

# Hacer backup si existe instalación previa
sudo mv starhotelhub starhotelhub_backup_$(date +%Y%m%d)

# Crear directorio nuevo
sudo mkdir starhotelhub
sudo chown ubuntu:ubuntu starhotelhub
```

### Paso 3: Subir Archivos
Desde tu máquina local (Windows):
```bash
# Opción 1: Usando SCP
scp -i tu-clave.pem -r "C:\xampp\htdocs\Starhotelhub Ubuntu\*" ubuntu@3.88.220.138:/var/www/html/starhotelhub/

# Opción 2: Usando SFTP
sftp -i tu-clave.pem ubuntu@3.88.220.138
put -r "C:\xampp\htdocs\Starhotelhub Ubuntu\*" /var/www/html/starhotelhub/

# Opción 3: Usando Git (recomendado)
# En tu máquina local:
git add .
git commit -m "Preparado para AWS - archivos en minúsculas"
git push origin main

# En el servidor AWS:
cd /var/www/html/starhotelhub
git pull origin main
```

### Paso 4: Configurar Permisos en AWS
```bash
# Establecer propietario correcto
sudo chown -R www-data:www-data /var/www/html/starhotelhub

# Establecer permisos de carpetas
sudo find /var/www/html/starhotelhub -type d -exec chmod 755 {} \;

# Establecer permisos de archivos
sudo find /var/www/html/starhotelhub -type f -exec chmod 644 {} \;

# Permisos especiales para carpetas de escritura
sudo chmod -R 775 /var/www/html/starhotelhub/assets/img/habitaciones
sudo chmod -R 775 /var/www/html/starhotelhub/assets/img/sliders
sudo chmod -R 775 /var/www/html/starhotelhub/logs
```

### Paso 5: Instalar Dependencias de Composer
```bash
cd /var/www/html/starhotelhub

# Si composer no está instalado:
sudo apt update
sudo apt install composer -y

# Instalar dependencias
composer install --no-dev --optimize-autoloader
```

### Paso 6: Configurar Base de Datos
```bash
# Conectar a MySQL
mysql -u root -p

# Crear base de datos y usuario (si no existen)
CREATE DATABASE IF NOT EXISTS starhotelhub;
CREATE USER IF NOT EXISTS 'starhub_user'@'localhost' IDENTIFIED BY 'StarHub2025!';
GRANT ALL PRIVILEGES ON starhotelhub.* TO 'starhub_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Importar base de datos
mysql -u starhub_user -p starhotelhub < /var/www/html/starhotelhub/starhotelhub.sql
```

### Paso 7: Configurar Apache/Nginx

#### Para Apache:
```bash
# Crear archivo de configuración
sudo nano /etc/apache2/sites-available/starhotelhub.conf
```

Contenido del archivo:
```apache
<VirtualHost *:80>
    ServerName 3.88.220.138
    DocumentRoot /var/www/html/starhotelhub

    <Directory /var/www/html/starhotelhub>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/starhotelhub_error.log
    CustomLog ${APACHE_LOG_DIR}/starhotelhub_access.log combined
</VirtualHost>
```

```bash
# Habilitar el sitio
sudo a2ensite starhotelhub.conf

# Habilitar mod_rewrite
sudo a2enmod rewrite

# Reiniciar Apache
sudo systemctl restart apache2
```

#### Para Nginx:
```bash
# Crear archivo de configuración
sudo nano /etc/nginx/sites-available/starhotelhub
```

Contenido del archivo:
```nginx
server {
    listen 80;
    server_name 3.88.220.138;
    root /var/www/html/starhotelhub;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?url=$uri&$args;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

```bash
# Habilitar el sitio
sudo ln -s /etc/nginx/sites-available/starhotelhub /etc/nginx/sites-enabled/

# Probar configuración
sudo nginx -t

# Reiniciar Nginx
sudo systemctl restart nginx
```

### Paso 8: Verificar Extensiones PHP
```bash
# Verificar extensiones instaladas
php -m | grep -E "mysqli|mbstring|curl|openssl"

# Si falta alguna, instalar:
sudo apt install php-mysqli php-mbstring php-curl php-xml -y
sudo systemctl restart apache2  # o nginx
```

### Paso 9: Configurar Variables de Entorno (Opcional)
```bash
# Crear archivo .env en el servidor
cd /var/www/html/starhotelhub
nano .env
```

Contenido:
```env
EMAIL_DRIVER=smtp
EMAIL_FROM=starhotelhub@gmail.com
EMAIL_FROM_NAME=StarHotelHub
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USER=starhotelhub@gmail.com
SMTP_PASS=lofwwzbsmhtyywgx
SMTP_SECURE=tls
```

### Paso 10: Probar el Sitio
```bash
# Verificar que el sitio carga
curl http://3.88.220.138/

# Verificar logs de errores
sudo tail -f /var/log/apache2/starhotelhub_error.log
# o para Nginx:
sudo tail -f /var/log/nginx/error.log
```

---

## 🧪 Pruebas Post-Despliegue

### 1. Probar Página Principal
- Abrir: http://3.88.220.138/
- Verificar que carga correctamente
- Verificar que el logo aparece

### 2. Probar Login Admin
- Abrir: http://3.88.220.138/admin
- Intentar login con credenciales de admin

### 3. Probar Formulario de Contacto
- Ir a: http://3.88.220.138/contacto
- Llenar formulario y enviar
- Verificar que se guarda en BD
- Verificar que se envían los emails

### 4. Verificar Imágenes
- Verificar que todas las imágenes cargan correctamente
- Especialmente el logo en todas las páginas

---

## 🔧 Solución de Problemas Comunes

### Error 500 - Internal Server Error
```bash
# Verificar logs
sudo tail -f /var/log/apache2/error.log

# Verificar permisos
ls -la /var/www/html/starhotelhub

# Verificar .htaccess
cat /var/www/html/starhotelhub/.htaccess
```

### Imágenes no Cargan
```bash
# Verificar que los archivos existen en minúsculas
ls -la /var/www/html/starhotelhub/assets/img/

# Verificar permisos
sudo chmod 644 /var/www/html/starhotelhub/assets/img/*.png
```

### Emails no se Envían
```bash
# Verificar logs de PHP
sudo tail -f /var/log/apache2/error.log | grep -i mail

# Probar conexión SMTP
telnet smtp.gmail.com 587

# Verificar que la contraseña de aplicación es correcta
```

### Error de Base de Datos
```bash
# Verificar conexión
mysql -u starhub_user -p starhotelhub

# Verificar que las tablas existen
SHOW TABLES;

# Verificar tabla contactos
DESCRIBE contactos;
```

---

## 📝 Checklist Final

- [ ] Archivos subidos al servidor
- [ ] Permisos configurados correctamente
- [ ] Composer install ejecutado
- [ ] Base de datos creada e importada
- [ ] Apache/Nginx configurado
- [ ] Extensiones PHP instaladas
- [ ] Sitio accesible desde navegador
- [ ] Logo visible en todas las páginas
- [ ] Login admin funciona
- [ ] Formulario de contacto funciona
- [ ] Emails se envían correctamente

---

## 📞 Soporte

Si encuentras algún problema durante el despliegue:
1. Revisa los logs de errores
2. Verifica la sección de "Solución de Problemas"
3. Contacta: starhotelhub@gmail.com

---

**Última actualización:** 2025-10-29
**Versión:** 1.0

