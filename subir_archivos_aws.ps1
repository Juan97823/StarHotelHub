# Script para subir archivos modificados a AWS
# Ejecutar desde PowerShell en: c:\xampp\htdocs\Starhotelhub Ubuntu

$KEY = "~/Downloads/starhotelhub.pem"
$SERVER = "ubuntu@3.88.220.138"
$LOCAL_BASE = "c:\xampp\htdocs\Starhotelhub Ubuntu"

Write-Host "Subiendo archivos a AWS..." -ForegroundColor Green

# Lista de archivos a subir
$archivos = @(
    "app\helpers\EmailHelper.php",
    "controllers\Admin\Dashboard.php",
    "controllers\Admin\Reservas.php",
    "controllers\Admin\Habitaciones.php",
    "controllers\Principal\Reserva.php",
    "test_admin_endpoints.php"
)

foreach ($archivo in $archivos) {
    $localPath = Join-Path $LOCAL_BASE $archivo
    $remotePath = "/tmp/" + ($archivo -replace '\\', '_')
    
    Write-Host "Subiendo: $archivo" -ForegroundColor Yellow
    
    # Subir a /tmp primero
    scp -i $KEY $localPath "${SERVER}:${remotePath}"
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "  OK - Archivo subido a /tmp" -ForegroundColor Green
    } else {
        Write-Host "  ERROR - No se pudo subir $archivo" -ForegroundColor Red
    }
}

Write-Host "`nAhora conectate por SSH y ejecuta estos comandos:" -ForegroundColor Cyan
Write-Host "ssh -i ~/Downloads/starhotelhub.pem ubuntu@3.88.220.138" -ForegroundColor White
Write-Host ""
Write-Host "sudo mv /tmp/app_helpers_EmailHelper.php /var/www/starhotelhub/app/helpers/EmailHelper.php" -ForegroundColor White
Write-Host "sudo mv /tmp/controllers_Admin_Dashboard.php /var/www/starhotelhub/controllers/Admin/Dashboard.php" -ForegroundColor White
Write-Host "sudo mv /tmp/controllers_Admin_Reservas.php /var/www/starhotelhub/controllers/Admin/Reservas.php" -ForegroundColor White
Write-Host "sudo mv /tmp/controllers_Admin_Habitaciones.php /var/www/starhotelhub/controllers/Admin/Habitaciones.php" -ForegroundColor White
Write-Host "sudo mv /tmp/controllers_Principal_Reserva.php /var/www/starhotelhub/controllers/Principal/Reserva.php" -ForegroundColor White
Write-Host "sudo mv /tmp/test_admin_endpoints.php /var/www/starhotelhub/test_admin_endpoints.php" -ForegroundColor White
Write-Host "sudo chown -R www-data:www-data /var/www/starhotelhub/" -ForegroundColor White
Write-Host "sudo chmod -R 644 /var/www/starhotelhub/app/helpers/*.php" -ForegroundColor White
Write-Host "sudo chmod -R 644 /var/www/starhotelhub/controllers/**/*.php" -ForegroundColor White
Write-Host "sudo systemctl restart apache2" -ForegroundColor White

