<?php
class RegistroModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }
    public function registrarse($nombre, $correo, $hash, $rol)
    {
        $sql = "INSERT INTO usuarios (nombre, correo, clave, rol) VALUES (?, ?, ?, ?)";
        return $this->insert($sql, array($nombre, $correo, $hash, $rol));
    }
};
