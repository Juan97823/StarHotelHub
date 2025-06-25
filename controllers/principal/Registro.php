<?php
class Registro extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $data['title'] = 'Registro'; 
        $data['subtitle'] = 'Regístrate en nuestra plataforma'; 

        $this->views->getView('principal/Registro', $data);

    }
    public function crear(){
        $nombre = strClean($_POST['nombre']);
        $correo = strClean($_POST['correo']);
        $clave = strClean($_POST['clave']);
        $confirmar = strClean($_POST['confirmar']);
        $hash = password_hash($clave, PASSWORD_DEFAULT);
        $rol = 2; // Rol de usuario normal
        $this->model->registrarse($nombre, $correo, $hash, $rol);
    }
}
