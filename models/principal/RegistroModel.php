<?php
class RegistroModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    // Registrar usuario
    public function registrarse($nombre, $correo, $hash, $rol)
    {
        $sql = "INSERT INTO usuarios (nombre, correo, clave, rol) VALUES (?, ?, ?, ?)";
        $datos = [$nombre, $correo, $hash, $rol];
        return $this->insert($sql, $datos);
    }

    // Establecer token de verificación para el usuario recién registrado
    public function setVerificationToken($id, $token)
    {
        $sql = "UPDATE usuarios SET token = ?, verify = 0 WHERE id = ?";
        return $this->save($sql, [$token, $id]);
    }

    // Verificar usuario por token (activar cuenta)
    public function verifyUserByToken($token)
    {
        // Buscar usuario con token
        $sql = "SELECT id FROM usuarios WHERE token = ? AND verify = 0";
        $user = $this->select($sql, [$token]);
        if ($user) {
            $sql2 = "UPDATE usuarios SET verify = 1, token = NULL WHERE id = ?";
            return $this->save($sql2, [$user['id']]);
        }
        return false;
    }
    // Validar que un campo sea único - SEGURO contra SQL injection
    public function validarUnique($item, $valor, $id_usuario)
    {
        // Validar que $item sea una columna permitida
        $columnasPermitidas = ['correo', 'nombre'];
        if (!in_array($item, $columnasPermitidas)) {
            return null;
        }

        if ($id_usuario == 0) {
            $sql = "SELECT * FROM usuarios WHERE $item = ?";
            return $this->select($sql, [$valor]);
        } else {
            $sql = "SELECT * FROM usuarios WHERE $item = ? AND id != ?";
            return $this->select($sql, [$valor, $id_usuario]);
        }
    }

    // Verificar correo - SEGURO contra SQL injection
    public function verificarCorreo($correo)
    {
        $sql = "SELECT id, nombre, correo FROM usuarios WHERE correo = ?";
        return $this->select($sql, [$correo]);
    }

    public function getUsuarioById($id)
    {
        $sql = "SELECT id, nombre, correo, clave FROM usuarios WHERE id = ?";
        return $this->select($sql, [$id]);
    }

    public function actualizarUsuario($id, $nombre, $correo, $hash = null)
    {
        if ($hash) {
            $sql = "UPDATE usuarios SET nombre = ?, correo = ?, clave = ? WHERE id = ?";
            $datos = [$nombre, $correo, $hash, $id];
        } else {
            $sql = "UPDATE usuarios SET nombre = ?, correo = ? WHERE id = ?";
            $datos = [$nombre, $correo, $id];
        }
        return $this->save($sql, $datos);
    }

    // Actualizar contraseña
    public function actualizarContrasena($id, $hash)
    {
        $sql = "UPDATE usuarios SET clave = ? WHERE id = ?";
        $datos = [$hash, $id];
        return $this->save($sql, $datos);
    }
}
