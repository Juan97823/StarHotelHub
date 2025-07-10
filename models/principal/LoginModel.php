<?php
class LoginModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtener usuario por correo
    public function validarAcceso($usuario)
    {
        $sql = "SELECT * FROM usuarios WHERE estado = 1 AND correo = ?";
        return $this->select($sql, [$usuario]);
    }
}
?>
