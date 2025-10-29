<?php
class ContactoModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtener todos los mensajes de contacto
    public function getMensajes()
    {
        $sql = "SELECT * FROM contactos ORDER BY fecha DESC";
        return $this->selectAll($sql);
    }

    // Obtener un mensaje específico
    public function getMensaje($id)
    {
        $sql = "SELECT * FROM contactos WHERE id = ?";
        return $this->select($sql, [$id]);
    }

    // Cambiar estado del mensaje (1=No leído, 2=Leído)
    public function cambiarEstado($estado, $id)
    {
        $sql = "UPDATE contactos SET estado = ? WHERE id = ?";
        return $this->save($sql, [$estado, $id]);
    }

    // Eliminar mensaje
    public function eliminarMensaje($id)
    {
        $sql = "DELETE FROM contactos WHERE id = ?";
        return $this->save($sql, [$id]);
    }
}

