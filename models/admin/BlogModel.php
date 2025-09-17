<?php
class BlogModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtener todas las entradas activas
    public function getEntradasAdmin()
    {
        $sql = "SELECT * FROM entradas ORDER BY fecha DESC";
        return $this->selectAll($sql);
    }

    // Obtener una entrada específica
    public function getEntrada($id)
    {
        $sql = "SELECT * FROM entradas WHERE id = ?";
        return $this->select($sql, [$id]);
    }

    // Insertar nueva entrada
    public function insertar($titulo, $contenido, $imagen, $slug, $categorias, $id_usuario)
    {
        $sql = "INSERT INTO entradas (titulo, descripcion, foto, slug, categorias, estado, fecha, id_usuario) VALUES (?, ?, ?, ?, ?, 1, NOW(), ?)";
        return $this->insert($sql, [$titulo, $contenido, $imagen, $slug, $categorias, $id_usuario]);
    }

    // Actualizar entrada existente
    public function actualizar($titulo, $contenido, $imagen, $slug, $categorias, $id_usuario, $id)
    {
        $sql = "UPDATE entradas SET titulo = ?, descripcion = ?, foto = ?, slug = ?, categorias = ?, id_usuario = ? WHERE id = ?";
        return $this->save($sql, [$titulo, $contenido, $imagen, $slug, $categorias, $id_usuario, $id]);
    }

    // Cambiar estado (activar/inactivar)
    public function estado($estado, $id)
    {
        $sql = "UPDATE entradas SET estado = ? WHERE id = ?";
        return $this->save($sql, [$estado, $id]);
    }
}
