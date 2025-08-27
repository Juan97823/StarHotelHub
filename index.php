<?php
require_once 'config/config.php';
require_once 'helpers/funciones.php';

// ✅ Detectar si es ruta de administrador
$isAdmin = strpos($_SERVER['REQUEST_URI'], '/' . ADMIN) !== false;

// ✅ Obtener la ruta
$ruta = empty($_GET['url']) ? 'Principal/index' : $_GET['url'];
$array = explode('/', $ruta);

// ✅ Resolver controlador y método
if ($isAdmin && (count($array) == 1 || (count($array) == 2 && empty($array[1]))) && $array[0] == ADMIN) {
    $controller = 'Admin';
    $metodo = 'login';
} else {
    $indiceUrl = $isAdmin ? 1 : 0;

    // Si estamos en ruta admin y la URL es admin/dashboard → usar controlador Admin
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

// ✅ Cargar clases automáticamente
require_once 'config/app/Autoload.php';

// ✅ Ruta de controlador según tipo
$dirControllers = $isAdmin 
    ? "controllers/admin/{$controller}.php" 
    : "controllers/principal/{$controller}.php";

// 🔎 Mostrar para depuración
 // echo '🔍 Buscando: ' . $dirControllers;
// exit;

// ✅ Cargar controlador
if (file_exists($dirControllers)) {
    require_once $dirControllers;
    $controller = new $controller();
    if (method_exists($controller, $metodo)) {
        $controller->$metodo($parametro);
    } else {
        echo '❌ MÉTODO NO EXISTE';
    }
} else {
    echo '❌ CONTROLADOR NO EXISTE';
}
