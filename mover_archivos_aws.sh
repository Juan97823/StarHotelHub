#!/bin/bash
# Script para mover archivos de /tmp a sus ubicaciones finales en AWS
# Ejecutar DESPUES de subir los archivos con el script PowerShell

echo "Moviendo archivos a sus ubicaciones finales..."

# Mover archivos
sudo mv /tmp/app_helpers_EmailHelper.php /var/www/starhotelhub/app/helpers/EmailHelper.php
sudo mv /tmp/controllers_Admin_Dashboard.php /var/www/starhotelhub/controllers/Admin/Dashboard.php
sudo mv /tmp/controllers_Admin_Reservas.php /var/www/starhotelhub/controllers/Admin/Reservas.php
sudo mv /tmp/controllers_Admin_Habitaciones.php /var/www/starhotelhub/controllers/Admin/Habitaciones.php
sudo mv /tmp/controllers_Principal_Reserva.php /var/www/starhotelhub/controllers/Principal/Reserva.php
sudo mv /tmp/test_admin_endpoints.php /var/www/starhotelhub/test_admin_endpoints.php

# Ajustar permisos
echo "Ajustando permisos..."
sudo chown -R www-data:www-data /var/www/starhotelhub/
sudo find /var/www/starhotelhub/ -type f -name "*.php" -exec chmod 644 {} \;
sudo find /var/www/starhotelhub/ -type d -exec chmod 755 {} \;

# Reiniciar Apache
echo "Reiniciando Apache..."
sudo systemctl restart apache2

echo "Listo! Archivos actualizados en AWS."
echo ""
echo "Prueba el sistema en:"
echo "  - http://3.88.220.138/admin/dashboard"
echo "  - http://3.88.220.138/test_admin_endpoints.php"

