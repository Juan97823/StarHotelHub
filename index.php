<?php
require_once 'config/config.php';
require_once 'helpers/funciones.php';

// ✅ Función para mostrar error 404 controlado
function error404() {
    http_response_code(404);
    require_once 'views/errors/404.php'; // crea este archivo con un mensaje amigable
    exit;
}

// ✅ Detectar si es ruta de administrador o empleado
$isAdmin = strpos($_SERVER['REQUEST_URI'], '/' . ADMIN) !== false;
$isEmpleado = strpos($_SERVER['REQUEST_URI'], '/empleado') !== false;

// ✅ Obtener la ruta de manera segura
$ruta = isset($_GET['url']) ? filter_var($_GET['url'], FILTER_SANITIZE_URL) : 'Principal/index';
$array = explode('/', trim($ruta, '/'));

// ✅ Resolver controlador y método
if ($isAdmin && (count($array) == 1 || (count($array) == 2 && empty($array[1]))) && $array[0] == ADMIN) {
    $controller = 'Admin';
    $metodo = 'login';
} else {
    $indiceUrl = $isAdmin ? 1 : 0;

    if ($isAdmin && isset($array[1]) && $array[1] === 'dashboard') {
        $controller = 'Admin';
        $metodo = 'dashboard';
    } else {
        $controller = ucfirst($array[$indiceUrl]);
        $metodo = 'index';
    }
}

// ✅ Resolver método si se especificó
$metodoIndice = $isAdmin ? 2 : 1;
if (!empty($array[$metodoIndice])) {
    $metodo = $array[$metodoIndice];
}

// ✅ Resolver parámetros si existen
$parametro = '';
$parametroIndice = $isAdmin ? 3 : 2;
if (!empty($array[$parametroIndice])) {
    for ($i = $parametroIndice; $i < count($array); $i++) {
        $parametro .= $array[$i] . ',';
    }
    $parametro = rtrim($parametro, ',');
}

// ✅ Sanitizar controlador y método
$controller = preg_replace('/[^a-zA-Z0-9]/', '', $controller);
$metodo = preg_replace('/[^a-zA-Z0-9]/', '', $metodo);

// ✅ Cargar clases automáticamente
require_once 'config/app/Autoload.php';

// ✅ Ruta de controlador según tipo
if ($isAdmin) {
    $dirControllers = "controllers/admin/{$controller}.php";
} elseif ($isEmpleado) {
    $dirControllers = "controllers/empleado/" . strtolower($controller) . ".php";
} else {
    $dirControllers = "controllers/principal/{$controller}.php";
}

// ✅ Protección de acceso admin
if ($isAdmin) {
    session_start();
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
        header("Location: " . RUTA_PRINCIPAL . ADMIN . "/login");
        exit;
    }
}

// ✅ Cargar controlador
if (file_exists($dirControllers)) {
    require_once $dirControllers;
    if (class_exists($controller)) {
        $controller = new $controller();
        if (method_exists($controller, $metodo)) {
            $controller->$metodo($parametro);
        } else {
            error404();
        }
    } else {
        error404();
    }
} else {
    error404();
}
