<?php
/**
 * Script de Verificación para Despliegue en AWS
 * 
 * Este script verifica que todos los archivos y configuraciones
 * estén correctos para el despliegue en AWS (Linux)
 */

echo "=================================================\n";
echo "   VERIFICACIÓN DE DESPLIEGUE AWS - StarHotelHub\n";
echo "=================================================\n\n";

$errores = [];
$advertencias = [];
$exitos = [];

// 1. Verificar estructura de carpetas
echo "1. Verificando estructura de carpetas...\n";

$carpetas_requeridas = [
    'app/helpers',
    'assets/img',
    'config',
    'controllers/Admin',
    'controllers/Principal',
    'models/admin',
    'models/principal',
    'views/template',
    'vendor/phpmailer'
];

foreach ($carpetas_requeridas as $carpeta) {
    if (is_dir($carpeta)) {
        $exitos[] = "✓ Carpeta existe: $carpeta";
    } else {
        $errores[] = "✗ Carpeta NO existe: $carpeta";
    }
}

// 2. Verificar archivos críticos
echo "\n2. Verificando archivos críticos...\n";

$archivos_criticos = [
    'config/config.php',
    'config/email.php',
    'app/helpers/EmailHelper.php',
    'controllers/Principal/Contacto.php',
    'assets/img/logo.png',
    'index.php'
];

foreach ($archivos_criticos as $archivo) {
    if (file_exists($archivo)) {
        $exitos[] = "✓ Archivo existe: $archivo";
    } else {
        $errores[] = "✗ Archivo NO existe: $archivo";
    }
}

// 3. Verificar que NO existan archivos con mayúsculas problemáticas
echo "\n3. Verificando archivos con mayúsculas problemáticas...\n";

$archivos_viejos = [
    'app/Helpers',
    'assets/img/Logo.png',
    'assets/img/Alojamiento.avif',
    'assets/img/RoomLujo.jpg'
];

foreach ($archivos_viejos as $archivo) {
    if (file_exists($archivo)) {
        $errores[] = "✗ Archivo con mayúsculas aún existe: $archivo (debe ser minúsculas)";
    } else {
        $exitos[] = "✓ Archivo viejo eliminado correctamente: $archivo";
    }
}

// 4. Verificar configuración de PHP
echo "\n4. Verificando configuración de PHP...\n";

$extensiones_requeridas = [
    'mysqli',
    'mbstring',
    'curl',
    'openssl'
];

foreach ($extensiones_requeridas as $ext) {
    if (extension_loaded($ext)) {
        $exitos[] = "✓ Extensión PHP cargada: $ext";
    } else {
        $errores[] = "✗ Extensión PHP NO cargada: $ext";
    }
}

// 5. Verificar configuración de email
echo "\n5. Verificando configuración de email...\n";

// Cargar config.php primero (define RUTA_RAIZ)
if (file_exists('config/config.php')) {
    require_once 'config/config.php';
}

if (file_exists('config/email.php')) {
    require_once 'config/email.php';
    
    if (defined('EMAIL_DRIVER')) {
        $exitos[] = "✓ EMAIL_DRIVER definido: " . EMAIL_DRIVER;
    } else {
        $errores[] = "✗ EMAIL_DRIVER no definido";
    }
    
    if (defined('SMTP_HOST')) {
        $exitos[] = "✓ SMTP_HOST definido: " . SMTP_HOST;
    } else {
        $errores[] = "✗ SMTP_HOST no definido";
    }
    
    if (defined('SMTP_USER')) {
        $exitos[] = "✓ SMTP_USER definido: " . SMTP_USER;
    } else {
        $errores[] = "✗ SMTP_USER no definido";
    }
    
    if (defined('SMTP_PASS') && !empty(SMTP_PASS)) {
        $exitos[] = "✓ SMTP_PASS configurado";
    } else {
        $errores[] = "✗ SMTP_PASS no configurado";
    }
}

// 6. Verificar permisos de escritura
echo "\n6. Verificando permisos de escritura...\n";

$carpetas_escritura = [
    'assets/img/habitaciones',
    'assets/img/sliders',
    'logs'
];

foreach ($carpetas_escritura as $carpeta) {
    if (is_dir($carpeta)) {
        if (is_writable($carpeta)) {
            $exitos[] = "✓ Carpeta escribible: $carpeta";
        } else {
            $advertencias[] = "⚠ Carpeta NO escribible: $carpeta (ejecutar: chmod 755 $carpeta)";
        }
    } else {
        $advertencias[] = "⚠ Carpeta no existe: $carpeta";
    }
}

// 7. Verificar base de datos
echo "\n7. Verificando conexión a base de datos...\n";

if (defined('HOST') && defined('USER') && defined('PASS') && defined('DATABASE')) {
    $exitos[] = "✓ Constantes de BD definidas";

    // Intentar conexión
    try {
        $conn = new mysqli(HOST, USER, PASS, DATABASE);
        if ($conn->connect_error) {
            $errores[] = "✗ Error de conexión a BD: " . $conn->connect_error;
        } else {
            $exitos[] = "✓ Conexión a BD exitosa";

            // Verificar tabla contactos
            $result = $conn->query("SHOW TABLES LIKE 'contactos'");
            if ($result && $result->num_rows > 0) {
                $exitos[] = "✓ Tabla 'contactos' existe";
            } else {
                $advertencias[] = "⚠ Tabla 'contactos' no existe";
            }

            $conn->close();
        }
    } catch (Exception $e) {
        $errores[] = "✗ Error al conectar a BD: " . $e->getMessage();
    }
} else {
    $errores[] = "✗ Constantes de BD no definidas";
}

// 8. Verificar vendor/autoload
echo "\n8. Verificando Composer autoload...\n";

if (file_exists('vendor/autoload.php')) {
    $exitos[] = "✓ vendor/autoload.php existe";
    require_once 'vendor/autoload.php';
    
    // Verificar PHPMailer
    if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        $exitos[] = "✓ PHPMailer cargado correctamente";
    } else {
        $errores[] = "✗ PHPMailer NO cargado";
    }
} else {
    $errores[] = "✗ vendor/autoload.php NO existe (ejecutar: composer install)";
}

// RESUMEN
echo "\n\n=================================================\n";
echo "                  RESUMEN\n";
echo "=================================================\n\n";

echo "✅ ÉXITOS: " . count($exitos) . "\n";
foreach ($exitos as $exito) {
    echo "   $exito\n";
}

if (count($advertencias) > 0) {
    echo "\n⚠️  ADVERTENCIAS: " . count($advertencias) . "\n";
    foreach ($advertencias as $advertencia) {
        echo "   $advertencia\n";
    }
}

if (count($errores) > 0) {
    echo "\n❌ ERRORES: " . count($errores) . "\n";
    foreach ($errores as $error) {
        echo "   $error\n";
    }
    echo "\n🔴 HAY ERRORES QUE DEBEN CORREGIRSE ANTES DEL DESPLIEGUE\n";
} else {
    echo "\n🟢 TODO LISTO PARA DESPLIEGUE EN AWS!\n";
}

echo "\n=================================================\n";
echo "Verificación completada: " . date('Y-m-d H:i:s') . "\n";
echo "=================================================\n";

