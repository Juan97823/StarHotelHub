<?php
// Configuración principal
define("ADMIN", "admin");
define("RUTA_PRINCIPAL", "http://184.73.133.51/");  // IP pública de tu instancia EC2
define("RUTA_ADMIN", RUTA_PRINCIPAL . ADMIN . '/');
define("RUTA_RAIZ", dirname(__DIR__)); // Ruta física del proyecto

// Configuración de la base de datos
define('HOST', '127.0.0.1');           // localhost dentro de la instancia
define('USER', 'staruser');             // usuario que creaste en MariaDB
define('PASS', 'StarHub2025!');         // contraseña del usuario
define('DATABASE', 'starhotelhub');     // nombre de la base de datos
define('CHARSET', 'charset=utf8');

// Configuración general
define('TITLE', 'StarHotelHub');

// Configuración de seguridad
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCKOUT_TIME', 300); // 5 minutos en segundos

// Iniciar sesión segura
session_start([
    'cookie_lifetime' => 5400, // 1.5 horas
    'cookie_secure' => false,   // poner true cuando uses HTTPS
    'cookie_httponly' => true,
    'use_strict_mode' => true
]);
?>
