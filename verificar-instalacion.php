<?php
/**
 * Script de Verificación de Instalación
 * Ejecutar en: http://3.88.220.138/verificar-instalacion.php
 */

$checks = [];
$errors = [];
$warnings = [];

// 1. Verificar PHP
$checks['PHP Version'] = phpversion();
if (version_compare(phpversion(), '7.4', '<')) {
    $errors[] = 'PHP 7.4+ requerido. Versión actual: ' . phpversion();
}

// 2. Verificar extensiones
$extensiones_requeridas = ['pdo', 'pdo_mysql', 'gd', 'curl', 'mbstring'];
foreach ($extensiones_requeridas as $ext) {
    $checks["Extensión: $ext"] = extension_loaded($ext) ? 'OK' : 'FALTA';
    if (!extension_loaded($ext)) {
        $errors[] = "Extensión PHP faltante: $ext";
    }
}

// 3. Verificar archivos de configuración
$archivos_requeridos = [
    'config/config.php',
    'config/email.php',
    '.htaccess',
    'index.php'
];

foreach ($archivos_requeridos as $archivo) {
    $existe = file_exists($archivo);
    $checks["Archivo: $archivo"] = $existe ? 'OK' : 'FALTA';
    if (!$existe) {
        $errors[] = "Archivo faltante: $archivo";
    }
}

// 4. Verificar carpetas
$carpetas_requeridas = ['uploads', 'logs', 'tmp', 'assets', 'views', 'controllers'];
foreach ($carpetas_requeridas as $carpeta) {
    $existe = is_dir($carpeta);
    $checks["Carpeta: $carpeta"] = $existe ? 'OK' : 'FALTA';
    if (!$existe) {
        $errors[] = "Carpeta faltante: $carpeta";
    }
}

// 5. Verificar permisos de escritura
$carpetas_escritura = ['uploads', 'logs', 'tmp'];
foreach ($carpetas_escritura as $carpeta) {
    if (is_dir($carpeta)) {
        $writable = is_writable($carpeta);
        $checks["Permiso escritura: $carpeta"] = $writable ? 'OK' : 'NO';
        if (!$writable) {
            $warnings[] = "Carpeta sin permiso de escritura: $carpeta";
        }
    }
}

// 6. Verificar configuración
if (file_exists('config/config.php')) {
    require_once 'config/config.php';
    $checks['RUTA_PRINCIPAL'] = RUTA_PRINCIPAL;
    $checks['DATABASE'] = DATABASE;
    $checks['HOST'] = HOST;
}

// 7. Verificar conexión a base de datos
if (file_exists('config/config.php')) {
    require_once 'config/config.php';
    require_once 'config/app/Conexion.php';
    
    try {
        $conexion = new Conexion();
        $checks['Conexión BD'] = 'OK';
    } catch (Exception $e) {
        $errors[] = 'Error de conexión a BD: ' . $e->getMessage();
        $checks['Conexión BD'] = 'ERROR';
    }
}

// 8. Verificar mod_rewrite
if (function_exists('apache_get_modules')) {
    $mod_rewrite = in_array('mod_rewrite', apache_get_modules());
    $checks['mod_rewrite'] = $mod_rewrite ? 'OK' : 'NO HABILITADO';
    if (!$mod_rewrite) {
        $warnings[] = 'mod_rewrite no está habilitado. Las rutas pueden no funcionar correctamente.';
    }
}

// 9. Verificar HTTPS
$is_https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
$checks['HTTPS'] = $is_https ? 'OK' : 'NO (Recomendado)';
if (!$is_https) {
    $warnings[] = 'HTTPS no está habilitado. Se recomienda usar HTTPS en producción.';
}

// 10. Verificar configuración de email
if (file_exists('config/email.php')) {
    require_once 'config/email.php';
    $checks['EMAIL_DRIVER'] = EMAIL_DRIVER;
    $checks['EMAIL_FROM'] = EMAIL_FROM;
    $checks['SMTP_HOST'] = SMTP_HOST;
    $checks['SMTP_PORT'] = SMTP_PORT;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Instalación - StarHotelHub</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 30px; text-align: center; }
        .section { margin-bottom: 30px; }
        .section h2 { color: #555; font-size: 18px; margin-bottom: 15px; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        .check-item { display: flex; justify-content: space-between; padding: 10px; border-bottom: 1px solid #eee; }
        .check-item:last-child { border-bottom: none; }
        .check-label { font-weight: 500; color: #333; }
        .check-value { color: #666; }
        .status-ok { color: #28a745; font-weight: bold; }
        .status-error { color: #dc3545; font-weight: bold; }
        .status-warning { color: #ffc107; font-weight: bold; }
        .alert { padding: 15px; margin-bottom: 15px; border-radius: 4px; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-warning { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .summary { text-align: center; margin-top: 30px; padding: 20px; background: #f9f9f9; border-radius: 4px; }
        .summary p { margin: 10px 0; font-size: 16px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Verificación de Instalación - StarHotelHub</h1>

        <?php if (!empty($errors)): ?>
            <div class="section">
                <h2>Errores Críticos</h2>
                <?php foreach ($errors as $error): ?>
                    <div class="alert alert-error">
                        <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($warnings)): ?>
            <div class="section">
                <h2>Advertencias</h2>
                <?php foreach ($warnings as $warning): ?>
                    <div class="alert alert-warning">
                        <strong>Advertencia:</strong> <?php echo htmlspecialchars($warning); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="section">
            <h2>Verificaciones</h2>
            <?php foreach ($checks as $label => $value): ?>
                <div class="check-item">
                    <span class="check-label"><?php echo htmlspecialchars($label); ?></span>
                    <span class="check-value <?php echo (strpos($value, 'OK') !== false) ? 'status-ok' : (strpos($value, 'ERROR') !== false ? 'status-error' : 'status-warning'); ?>">
                        <?php echo htmlspecialchars($value); ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="summary">
            <?php if (empty($errors)): ?>
                <div class="alert alert-success">
                    <strong>¡Instalación correcta!</strong> El proyecto está listo para usar.
                </div>
            <?php else: ?>
                <div class="alert alert-error">
                    <strong>Hay errores que deben corregirse antes de usar el proyecto.</strong>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

