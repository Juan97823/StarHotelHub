<?php 
class Controller{
    protected $model,$views;
    public function __construct()
        {
            $this->views = new Views();
            $this->cargarModel();
        }
    

    public function cargarModel($model = null)
    {
        if ($model == null) {
            $nombreModel = get_class($this) . 'Model';
        } else {
            $nombreModel = $model . 'Model';
        }
        $isAdmin = strpos($_SERVER['REQUEST_URI'], '/' . ADMIN) !== false;
        $ruta = ($isAdmin) ? 'models/admin/' . $nombreModel . '.php' : 'models/principal/' . $nombreModel . '.php';
        if (file_exists($ruta)) {
            require_once $ruta;
            $this->model = new $nombreModel();
        }
    }
}