<?php
class LoginModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    //Obtemer usuario por correo
    public function validarAcceso($usuario)
    {
        $sql = "SELECT u.*, r.NombreRol, r.id AS rol
                FROM usuarios u
                INNER JOIN roles r ON u.Rol = r.id
                WHERE u.estado = 1 AND u.correo = ?";
            return $this->select($sql, [$usuario]); 
    }
}