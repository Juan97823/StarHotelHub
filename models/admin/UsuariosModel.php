<?php
class UsuariosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Obtiene todos los usuarios y sus roles, incluyendo activos e inactivos.
     * Se usa un LEFT JOIN para asegurar que todos los usuarios se listen, incluso si su rol no está definido.
     */
    public function getUsuarios()
    {
        $sql = "SELECT u.id, u.nombre, u.correo, r.NombreRol AS rol, u.estado 
                FROM usuarios u 
                LEFT JOIN roles r ON u.rol = r.id 
                WHERE u.id != 1";
        return $this->selectAll($sql) ?? [];
    }
    public function getClientes()
    {
        $sql = "SELECT id, nombre FROM usuarios WHERE rol = 'cliente' AND estado = 1";
        return $this->selectAll($sql);
    }



    /**
     * Obtiene un usuario específico por su ID, incluyendo el nombre del rol.
     */
    public function getUsuarioPorId($id)
    {
        $sql = "SELECT u.id, u.nombre, u.correo, u.rol as rol_id, r.NombreRol AS rol 
                FROM usuarios u
                LEFT JOIN roles r ON u.rol = r.id
                WHERE u.id = ?";
        return $this->select($sql, [$id]);
    }

    /**
     * Obtiene el ID de un rol a partir de su nombre.
     */
    public function getRolIdPorNombre($nombreRol)
    {
        $sql = "SELECT id FROM roles WHERE NombreRol = ?";
        $result = $this->select($sql, [$nombreRol]);
        return $result ? $result['id'] : null;
    }

    /**
     * Registra un nuevo usuario en la base de datos (espera ID de rol).
     */
    public function registrarUsuario($nombre, $correo, $clave, $rolId)
    {
        $sql = "INSERT INTO usuarios (nombre, correo, clave, rol) VALUES (?, ?, ?, ?)";
        $hash = password_hash($clave, PASSWORD_DEFAULT);
        return $this->insert($sql, [$nombre, $correo, $hash, $rolId]);
    }

    /**
     * Actualiza un usuario existente (espera ID de rol).
     */
    public function actualizarUsuario($id, $nombre, $correo, $rolId, $clave = null)
    {
        if ($clave) {
            $sql = "UPDATE usuarios SET nombre = ?, correo = ?, rol = ?, clave = ? WHERE id = ?";
            $hash = password_hash($clave, PASSWORD_DEFAULT);
            return $this->save($sql, [$nombre, $correo, $rolId, $hash, $id]);
        } else {
            $sql = "UPDATE usuarios SET nombre = ?, correo = ?, rol = ? WHERE id = ?";
            return $this->save($sql, [$nombre, $correo, $rolId, $id]);
        }
    }

    /**
     * Cambia el estado de un usuario (activo/inactivo).
     */
    public function cambiarEstadoUsuario($id, $estado)
    {
        $sql = "UPDATE usuarios SET estado = ? WHERE id = ? AND id != 1";
        $res = $this->save($sql, [$estado, $id]);
        // devuelve true si la consulta se ejecutó correctamente
        return $res !== false;
    }

}
