<?php
class Controller
{
    protected $model, $views;
    public function __construct()
    {
        // Se incluye la clase Query, ya que es la base de todos los modelos
        // y debe estar disponible ANTES de que cargarModel() intente instanciar un modelo.
        require_once 'config/app/Query.php';
        $this->views = new Views();
        $this->cargarModel();
    }

    public function cargarModel($model = null)
    {
        if ($model == null) {
            $nombreModel = get_class($this) . 'Model';
        } else {
            $nombreModel = $model; // No agregues "Model" extra si ya lo tiene
        }

        $isAdmin = strpos($_SERVER['REQUEST_URI'], '/' . ADMIN) !== false;
        $ruta = ($isAdmin) ? 'models/admin/' . $nombreModel . '.php' : 'models/principal/' . $nombreModel . '.php';

        if (file_exists($ruta)) {
            require_once $ruta;
            $this->model = new $nombreModel();
        } else {
            $this->model = null;
        }
    }
}