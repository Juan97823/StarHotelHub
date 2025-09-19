<?php
spl_autoload_register(function ($class) {
    $paths = [
        'config/app/',
        'core/',
        'models/',
        'models/principal/',
        'models/admin/',
        'models/empleado/' // <- Añadido para el dashboard de empleado
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }

        // Intenta también con sufijo Model
        $modelFile = $path . $class . 'Model.php';
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return;
        }
    }
});
