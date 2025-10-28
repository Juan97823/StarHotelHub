<?php
// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 0); // No mostrar errores en producción
ini_set('log_errors', 1);
ini_set('error_log', dirname(__DIR__) . '/logs/error.log');

// Habilitar reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/logs/error.log');

// Crear carpeta de logs si no existe
if (!is_dir('logs')) {
    mkdir('logs', 0755, true);
}

// Cargar autoload de composer (para PHPMailer y otras dependencias)
if (file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
}

require_once 'config/config.php';
require_once 'helpers/funciones.php';

// La sesión ya se inicia en config.php

//  Función para mostrar error 404 controlado
function error404()
{
    http_response_code(404);
    require_once 'views/errors/404.php';
    exit;
}


//  Detectar si es ruta de administrador
$isAdmin = strpos($_SERVER['REQUEST_URI'], '/' . ADMIN) !== false;

//  Obtener la ruta
$ruta = empty($_GET['url']) ? 'Principal/index' : $_GET['url'];
$array = explode('/', $ruta);

//  Protección de rutas de administrador
if (
    $isAdmin &&
        // excluir login
    (!isset($array[1]) || $array[1] != 'login') &&
        // si no hay sesión o no es admin
    (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 1)
) {
    header('Location: ' . RUTA_PRINCIPAL . 'login');
    exit;
}

//  Resolver controlador y método
if ($isAdmin && (count($array) == 1 || (count($array) == 2 && empty($array[1]))) && $array[0] == ADMIN) {
    // Caso especial: /admin → login
    $controller = 'Admin';
    $metodo = 'login';
} else {
    $indiceUrl = $isAdmin ? 1 : 0;

    if ($isAdmin && isset($array[1]) && $array[1] === 'dashboard') {
        // Caso especial: /admin/dashboard
        $controller = 'Admin';
        $metodo = 'dashboard';
    } else {
        $controller = ucfirst($array[$indiceUrl]);
        $metodo = 'index';
    }
}

//  Resolver método si se especificó
$metodoIndice = $isAdmin ? 2 : 1;
if (!empty($array[$metodoIndice])) {
    $metodo = $array[$metodoIndice];
}

//  Resolver parámetros (mejorado con implode)
$parametro = '';
$parametroIndice = $isAdmin ? 3 : 2;
if (!empty($array[$parametroIndice])) {
    $parametro = implode(',', array_slice($array, $parametroIndice));
}

//  Autoload
require_once 'config/app/Autoload.php';

//  Ruta de controlador según tipo
$dirControllers = $isAdmin
    ? "controllers/admin/{$controller}.php"
    : "controllers/principal/{$controller}.php";

//  Cargar controlador
if (file_exists($dirControllers)) {
    require_once $dirControllers;
    $controller = new $controller();
    if (method_exists($controller, $metodo)) {
        $parametro = array_slice($array, $parametroIndice);
        $controller->$metodo(...$parametro);
    } else {
        error404();
    }
}
