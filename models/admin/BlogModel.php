<?php
class BlogModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtener todas las entradas (para el admin)
    public function getEntradasAdmin()
    {
        $sql = "SELECT * FROM entradas ORDER BY id DESC";
        return $this->selectAll($sql);
    }

    // Obtener una entrada específica por ID
    public function getEntrada($id)
    {
        $sql = "SELECT * FROM entradas WHERE id = ?";
        return $this->select($sql, [$id]);
    }

    // Insertar nueva entrada
    public function insertar($titulo, $descripcion, $slug, $id_usuario)
    {
        $sql = "INSERT INTO entradas (titulo, descripcion, slug, estado, fecha, id_usuario, id_categoria)
            VALUES (?, ?, ?, 1, NOW(), ?, 1)";
        return $this->insert($sql, [$titulo, $descripcion, $slug, $id_usuario]);
    }

    // Actualizar entrada existente
    public function actualizar($titulo, $descripcion, $slug, $id_usuario, $id)
    {
        $sql = "UPDATE entradas
            SET titulo = ?, descripcion = ?, slug = ?, id_usuario = ?, fecha = NOW()
            WHERE id = ?";
        return $this->save($sql, [$titulo, $descripcion, $slug, $id_usuario, $id]);


    }

    // Cambiar estado (activar/inactivar)
    public function estado($estado, $id)
    {
        $sql = "UPDATE entradas SET estado = ? WHERE id = ?";
        return $this->save($sql, [$estado, $id]);
    }

    // Obtener todos los mensajes del blog
    public function getMensajes()
    {
        $sql = "SELECT m.*, e.titulo as entrada_titulo
                FROM comentarios_blog m
                LEFT JOIN entradas e ON m.id_entrada = e.id
                ORDER BY m.fecha DESC";
        return $this->selectAll($sql);
    }

    // Obtener un mensaje específico
    public function getMensaje($id)
    {
        $sql = "SELECT m.*, e.titulo as entrada_titulo
                FROM comentarios_blog m
                LEFT JOIN entradas e ON m.id_entrada = e.id
                WHERE m.id = ?";
        return $this->select($sql, [$id]);
    }

    // Cambiar estado del mensaje
    public function cambiarEstadoMensaje($estado, $id)
    {
        $sql = "UPDATE comentarios_blog SET estado = ? WHERE id = ?";
        return $this->save($sql, [$estado, $id]);
    }

    // Eliminar mensaje
    public function eliminarMensaje($id)
    {
        $sql = "DELETE FROM comentarios_blog WHERE id = ?";
        return $this->save($sql, [$id]);
    }
}
