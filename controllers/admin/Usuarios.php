<?php
require_once 'models/admin/UsuariosModel.php';

class Usuarios extends Controller
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
        // Se podría añadir una verificación de sesión de administrador aquí si fuera necesario.
        $this->model = new UsuariosModel();
    }

    /**
     * Carga la vista principal de gestión de usuarios.
     */
    public function index()
    {
        $data['title'] = 'User Management';
        $data['usuarios'] = $this->model->getUsuarios(); // Obtener usuarios del modelo
        
        // Cargar la vista pasándole los datos
        $this->views->getView('admin/usuarios/index', $data);
    }
}
?>