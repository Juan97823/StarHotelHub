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
        // rol = 3 es cliente (no string 'cliente')
        $sql = "SELECT id, nombre FROM usuarios WHERE rol = 3 AND estado = 1";
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

    /**
     * Obtener la contraseña (hash) actual de un usuario por su id
     */
    public function getClaveActual($id)
    {
        $sql = "SELECT clave FROM usuarios WHERE id = ? LIMIT 1";
        $res = $this->select($sql, [$id]);
        return $res['clave'] ?? null;
    }

    /**
     * Actualizar la contraseña de un usuario (recibe la contraseña en texto plano)
     */
    public function actualizarClave($id, $nuevaClave)
    {
        $hash = password_hash($nuevaClave, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET clave = ? WHERE id = ?";
        return $this->save($sql, [$hash, $id]);
    }

    /**
     * Actualizar perfil de usuario (solo nombre y correo, sin cambiar rol)
     */
    public function actualizarPerfil($id, $nombre, $correo)
    {
        // Verificar si el correo ya existe en otro usuario
        $sqlCheck = "SELECT id FROM usuarios WHERE correo = ? AND id != ?";
        $existe = $this->select($sqlCheck, [$correo, $id]);

        if ($existe) {
            return 'existe';
        }

        $sql = "UPDATE usuarios SET nombre = ?, correo = ? WHERE id = ?";
        return $this->save($sql, [$nombre, $correo, $id]);
    }

}
