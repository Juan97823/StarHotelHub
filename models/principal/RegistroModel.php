<?php
class RegistroModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    // Registrar usuario
    public function registrarse($nombre, $correo, $clave, $rol)
    {
        $sql = "INSERT INTO usuarios (nombre, correo, clave, rol) VALUES (?, ?, ?, ?)";
        $datos = [$nombre, $correo, $clave, $rol];
        return $this->insert($sql, $datos);
    }

    public function verificarCorreo($correo)
    {
        $correo = addslashes($correo); // sanitizar mínimamente
        $sql = "SELECT id FROM usuarios WHERE correo = '$correo'";
        return $this->select($sql);
    }
}
