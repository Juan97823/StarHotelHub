<?php
class LoginModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtener usuario por correo
    public function getUsuarioCorreo($correo)
    {
        $sql = "SELECT * FROM usuarios WHERE correo = ?";
        return $this->select($sql, [$correo]);
    }

    // (Opcional) Obtener por correo o usuario
    public function getUsuarioLogin($usuario)
    {
        $sql = "SELECT * FROM usuarios WHERE correo = ? OR nombre = ?";
        return $this->select($sql, [$usuario, $usuario]);
    }

    // (Opcional) Validar si usuario está activo
    public function usuarioActivo($correo)
    {
        $sql = "SELECT * FROM usuarios WHERE correo = ? AND estado = 1";
        return $this->select($sql, [$correo]);
    }
}
