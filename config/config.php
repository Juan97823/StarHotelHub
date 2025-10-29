<?php
// =============================================
// Configuración general del sistema StarHotelHub
// =============================================

// Rutas base
define("ADMIN", "admin");
define("RUTA_PRINCIPAL", "http://3.88.220.138/");
define("RUTA_ADMIN", RUTA_PRINCIPAL . ADMIN . '/');
define("RUTA_RAIZ", dirname(__DIR__)); // Ruta física del proyecto en el servidor

// ---------------------------------------------
// Configuración de la base de datos
// ---------------------------------------------
define('HOST', 'localhost');
define('USER', 'starhub_user');
define('PASS', 'StarHub2025!');
define('DATABASE', 'starhotelhub');
define('CHARSET', 'charset=utf8mb4'); // Compatible con caracteres especiales y emojis

// ---------------------------------------------
// Configuración general del sitio
// ---------------------------------------------
define('TITLE', 'StarHotelHub');

// ---------------------------------------------
// Seguridad y control de sesión
// ---------------------------------------------
define('MAX_LOGIN_ATTEMPTS', 5);   // Intentos máximos de inicio de sesión
define('LOCKOUT_TIME', 300);       // Bloqueo temporal (5 minutos)
define('SESSION_TIMEOUT', 5400);   // Duración máxima de sesión (1.5 horas)

// Inicialización de sesión con parámetros seguros
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => SESSION_TIMEOUT,
        'path' => '/',
        'domain' => '',
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    session_start();
}
?>
