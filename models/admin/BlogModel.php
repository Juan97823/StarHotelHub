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
    public function insertar($titulo, $contenido, $imagen, $slug, $id_usuario)
    {
        $sql = "INSERT INTO entradas (titulo, contenido, imagen, slug, estado, fecha, id_usuario) 
                VALUES (?, ?, ?, ?, 1, NOW(), ?)";
        return $this->insert($sql, [$titulo, $contenido, $imagen, $slug, $id_usuario]);
    }

    // Actualizar entrada existente
    public function actualizar($titulo, $contenido, $imagen, $slug, $id_usuario, $id)
    {
        if ($imagen) {
            $sql = "UPDATE entradas 
                    SET titulo = ?, contenido = ?, imagen = ?, slug = ?, id_usuario = ?, fecha = NOW() 
                    WHERE id = ?";
            return $this->save($sql, [$titulo, $contenido, $imagen, $slug, $id_usuario, $id]);
        } else {
            $sql = "UPDATE entradas 
                    SET titulo = ?, contenido = ?, slug = ?, id_usuario = ?, fecha = NOW() 
                    WHERE id = ?";
            return $this->save($sql, [$titulo, $contenido, $slug, $id_usuario, $id]);
        }
    }

    // Cambiar estado (activar/inactivar)
    public function estado($estado, $id)
    {
        $sql = "UPDATE entradas SET estado = ? WHERE id = ?";
        return $this->save($sql, [$estado, $id]);
    }
}
