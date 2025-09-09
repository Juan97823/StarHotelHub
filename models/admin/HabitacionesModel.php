<?php
class HabitacionesModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtener todas las habitaciones activas
    public function getHabitaciones($soloActivas = true)
    {
        $sql = "SELECT * FROM habitaciones";
        if ($soloActivas) {
            $sql .= " WHERE estado = 1";
        }
        return $this->selectAll($sql) ?? [];
    }

    // Registrar nueva habitación
    public function registrarHabitacion($estilo, $numero, $capacidad, $precio, $descripcion, $servicios, $foto)
    {
        $slug = $this->generateSlug($estilo . '-' . $numero);
        $sql = "INSERT INTO habitaciones (estilo, numero, capacidad, precio, descripcion, servicios, foto, slug, estado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)";
        $datos = [$estilo, $numero, $capacidad, $precio, $descripcion, $servicios, $foto, $slug];
        return $this->insert($sql, $datos); // retorna ID insertado o false
    }

    // Obtener una habitación específica
    public function getHabitacion($id)
    {
        $sql = "SELECT * FROM habitaciones WHERE id = ?";
        return $this->select($sql, [$id]) ?? [];
    }

    // Actualizar habitación
    public function actualizarHabitacion($estilo, $numero, $capacidad, $precio, $descripcion, $servicios, $foto, $id)
    {
        $slug = $this->generateSlug($estilo . '-' . $numero);
        $sql = "UPDATE habitaciones 
                SET estilo = ?, numero = ?, capacidad = ?, precio = ?, descripcion = ?, servicios = ?, foto = ?, slug = ? 
                WHERE id = ?";
        $datos = [$estilo, $numero, $capacidad, $precio, $descripcion, $servicios, $foto, $slug, $id];
        return $this->save($sql, $datos); // retorna true/false
    }

    // Borrado lógico
    public function eliminarHabitacion($id)
    {
        $sql = "UPDATE habitaciones SET estado = 0 WHERE id = ?";
        return $this->save($sql, [$id]);
    }

    // Reactivar habitación
    public function reingresarHabitacion($id)
    {
        $sql = "UPDATE habitaciones SET estado = 1 WHERE id = ?";
        return $this->save($sql, [$id]);
    }

    // Generar slug único
    private function generateSlug($text)
    {
        $text = preg_replace('~[^\\pL\\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        return !empty($text) ? $text : 'n-a';
    }

    // -------------------- GALERÍA --------------------

    public function getGaleria($id_habitacion)
    {
        $sql = "SELECT * FROM galeria_habitaciones WHERE id_habitacion = ?";
        return $this->selectAll($sql, [$id_habitacion]) ?? [];
    }

    public function insertarImagenGaleria($imagen, $id_habitacion)
    {
        $sql = "INSERT INTO galeria_habitaciones (imagen, id_habitacion) VALUES (?, ?)";
        return $this->insert($sql, [$imagen, $id_habitacion]);
    }

    public function getFoto($id)
    {
        $sql = "SELECT * FROM galeria_habitaciones WHERE id = ?";
        return $this->select($sql, [$id]) ?? [];
    }

    public function eliminarFotoGaleria($id)
    {
        // Borrado permanente (cuidado con consistencia)
        $sql = "DELETE FROM galeria_habitaciones WHERE id = ?";
        return $this->save($sql, [$id]);
    }
}
