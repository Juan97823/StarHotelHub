<?php
define("ADMIN", "admin");
define("RUTA_PRINCIPAL", "http://localhost/Starhotelhub/");
define("RUTA_ADMIN", RUTA_PRINCIPAL . ADMIN . '/');
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DATABASE', 'Starhotelhub');
define('CHARSET', 'charset=utf8');
define('TITLE', 'StarHotelHub');
// Configuración de seguridad
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCKOUT_TIME', 300); // 5 minutos en segundos

// Iniciar sesión segura
session_start([
    'cookie_lifetime' => 86400, // 1 día
    'cookie_secure' => true,
    'cookie_httponly' => true,
    'use_strict_mode' => true
]);
?>