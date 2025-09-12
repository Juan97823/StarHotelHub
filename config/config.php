<?php
define("ADMIN", "admin");
define("RUTA_PRINCIPAL", "http://localhost/Starhotelhub/");
define("RUTA_ADMIN", RUTA_PRINCIPAL . ADMIN . '/');
define("RUTA_RAIZ", dirname(__DIR__)); // Nueva constante para la ruta física
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
    'cookie_lifetime' => 5400, // 2 horas
    'cookie_secure' => true,
    'cookie_httponly' => true,
    'use_strict_mode' => true
]);
?>