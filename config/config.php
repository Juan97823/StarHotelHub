<?php
// Configuración principal
define("ADMIN", "admin");
define("RUTA_PRINCIPAL", "http://localhost/Starhotelhub/");
define("RUTA_ADMIN", RUTA_PRINCIPAL . ADMIN . '/');
define("RUTA_RAIZ", dirname(__DIR__)); // Ruta física del proyecto

// Configuración de la base de datos - USAR VARIABLES DE ENTORNO EN PRODUCCIÓN
define('HOST', getenv('DB_HOST') ?: 'localhost');
define('USER', getenv('DB_USER') ?: 'root');
define('PASS', getenv('DB_PASS') ?: '');
define('DATABASE', getenv('DB_NAME') ?: 'starhotelhub'); // ⚠️ MINÚSCULAS para Ubuntu
define('CHARSET', 'charset=utf8mb4'); // utf8mb4 para mejor compatibilidad (emojis, caracteres especiales)

// Configuración general
define('TITLE', 'StarHotelHub');

// Configuración de seguridad
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCKOUT_TIME', 300); // 5 minutos en segundos
define('SESSION_TIMEOUT', 5400); // 1.5 horas

// Configurar parámetros de sesión ANTES de iniciar
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => SESSION_TIMEOUT,
        'path' => '/',
        'domain' => '',
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on', // true solo en HTTPS
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    session_start();
}
