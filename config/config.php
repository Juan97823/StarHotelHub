<?php
define("ADMIN", "admin");
define("RUTA_PRINCIPAL", "http://98.90.79.229/");  // IP pública
define("RUTA_ADMIN", RUTA_PRINCIPAL . ADMIN . '/');
define("RUTA_RAIZ", dirname(__DIR__));
define('HOST', 'localhost');
define('USER', 'starhubuser');
define('PASS', 'StarHubPass123!');
define('DATABASE', 'starhotelhub');
define('CHARSET', 'charset=utf8');
define('TITLE', 'StarHotelHub');

define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCKOUT_TIME', 300);

session_start([
    'cookie_lifetime' => 5400,
    'cookie_secure' => false,
    'cookie_httponly' => true,
    'use_strict_mode' => true
]);
?>
