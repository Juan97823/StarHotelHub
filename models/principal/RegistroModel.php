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
        return $this->insert($sql,[$nombre,$correo,$hash,$rol]);
    }
    public function validarUnique($item,$valor,$id_usuario) {
        if ($id_usuario == 0) {
            $sql = "SELECT * FROM usuarios WHERE $item = '$valor'";
        } else {
             $sql = "SELECT * FROM usuarios WHERE $item = '$valor' AND id != $id_usuario";
        }
        return $this->select($sql);
    }
    public function verificarCorreo($correo)
    {
        $correo = addslashes($correo); // sanitizar mínimamente
        $sql = "SELECT id FROM usuarios WHERE correo = '$correo'";
        return $this->select($sql);
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
}
