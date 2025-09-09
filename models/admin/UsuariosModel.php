<?php
class UsuariosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Obtiene todos los usuarios activos y sus roles.
     * Excluye al superadministrador (ID = 1).
     * @param bool $soloActivos Si es true, devuelve solo usuarios con estado=1
     * @return array
     */
    public function getUsuarios($soloActivos = true)
    {
        $sql = "SELECT u.id, u.nombre, u.correo, r.NombreRol AS rol, u.estado
                FROM usuarios u
                INNER JOIN roles r ON u.rol = r.id
                WHERE u.id != 1";

        if ($soloActivos) {
            $sql .= " AND u.estado = 1";
        }

        return $this->selectAll($sql) ?? [];
    }

    /**
     * Inhabilita un usuario (borrado lógico).
     * Protege al superadministrador (ID 1).
     */
    public function inhabilitarUsuario($id)
    {
        $sql = "UPDATE usuarios SET estado = 0 WHERE id = ? AND id != 1";
        return $this->save($sql, [$id]) ? true : false;
    }

    /**
     * Reactiva un usuario previamente inhabilitado.
     * Protege al superadministrador (ID 1).
     */
    public function reingresarUsuario($id)
    {
        $sql = "UPDATE usuarios SET estado = 1 WHERE id = ? AND id != 1";
        return $this->save($sql, [$id]) ? true : false;
    }
}
    