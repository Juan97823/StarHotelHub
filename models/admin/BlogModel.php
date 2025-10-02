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
    public function insertar($titulo, $descripcion, $imagen, $slug, $id_usuario, $id_categorias)
    {
        $sql = "INSERT INTO entradas (titulo, descripcion, foto, slug, estado, fecha, id_usuario, id_categorias) 
            VALUES (?, ?, ?, ?, 1, NOW(), ?, ?)";
        return $this->insert($sql, [$titulo, $descripcion, $imagen, $slug, $id_usuario, $id_categorias]);
    }


    // Actualizar entrada existente
    public function actualizar($titulo, $descripcion, $imagen, $slug, $id_usuario, $id_categorias, $id)
    {
        if ($imagen) {
            $sql = "UPDATE entradas 
            SET titulo = ?, descripcion = ?, foto = ?, slug = ?, id_usuario = ?, id_categorias = ?, fecha = NOW() 
            WHERE id = ?";
            return $this->save($sql, [$titulo, $descripcion, $imagen, $slug, $id_usuario, $id_categorias, $id]);
        } else {
            $sql = "UPDATE entradas 
            SET titulo = ?, descripcion = ?, slug = ?, id_usuario = ?, id_categorias = ?, fecha = NOW() 
            WHERE id = ?";
            return $this->save($sql, [$titulo, $descripcion, $slug, $id_usuario, $id_categorias, $id]);
        }


    }

    // Cambiar estado (activar/inactivar)
    public function estado($estado, $id)
    {
        $sql = "UPDATE entradas SET estado = ? WHERE id = ?";
        return $this->save($sql, [$estado, $id]);
    }
}
