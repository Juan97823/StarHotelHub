<?php
class ContactoModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Guardar mensaje de contacto en la BD
     */
    public function guardarContacto($nombre, $correo, $telefono, $asunto, $mensaje)
    {
        $sql = "INSERT INTO contactos (nombre, correo, telefono, asunto, mensaje, fecha, estado) 
                VALUES (?, ?, ?, ?, ?, NOW(), 1)";
        $datos = [$nombre, $correo, $telefono, $asunto, $mensaje];
        return $this->insert($sql, $datos);
    }

    /**
     * Obtener todos los contactos (para admin)
     */
    public function getContactos()
    {
        $sql = "SELECT * FROM contactos ORDER BY fecha DESC";
        return $this->selectAll($sql);
    }

    /**
     * Obtener un contacto específico
     */
    public function getContacto($id)
    {
        $sql = "SELECT * FROM contactos WHERE id = ?";
        return $this->select($sql, [$id]);
    }

    /**
     * Marcar contacto como leído
     */
    public function marcarLeido($id)
    {
        $sql = "UPDATE contactos SET estado = 2 WHERE id = ?";
        return $this->save($sql, [$id]);
    }

    /**
     * Eliminar contacto
     */
    public function eliminarContacto($id)
    {
        $sql = "DELETE FROM contactos WHERE id = ?";
        return $this->delete($sql, [$id]);
    }
}

