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
        // Solo permitir acceso a usuarios activos (sin requerir verificación de correo)
        $sql = "SELECT u.*, r.NombreRol, r.id AS rol
                FROM usuarios u
                INNER JOIN roles r ON u.rol = r.id
                WHERE u.estado = 1 AND u.correo = ?";
        return $this->select($sql, [$usuario]);
    }
}