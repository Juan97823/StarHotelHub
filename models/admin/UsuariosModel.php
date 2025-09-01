<?php
class UsuariosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Obtiene todos los usuarios y sus roles de la base de datos.
     * Excluye al superadministrador (ID 1) para mayor seguridad.
     * @return array Lista de usuarios con sus roles
     */
    public function getUsuarios()
    {
        $sql = "SELECT u.id, u.nombre, u.correo, r.NombreRol as rol
                FROM usuarios u
                INNER JOIN roles r ON u.rol = r.id
                WHERE u.id != 1";
        return $this->selectAll($sql);
    }
}
?>