<?php
define("ADMIN", "admin");
define("RUTA_PRINCIPAL", "http://localhost/starhotelhub/");
define("RUTA_ADMIN", RUTA_PRINCIPAL . ADMIN . '/');
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DATABASE', 'starhotelhub');
define('CHARSET', 'charset=utf8');
define('TITLE', 'Star Hotel Hub');
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