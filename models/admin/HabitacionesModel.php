<?php
class HabitacionesModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getHabitaciones()
    {
        $sql = "SELECT * FROM habitaciones";
        $data = $this->selectAll($sql);
        return is_array($data) ? $data : [];
    }

    public function registrarHabitacion($estilo, $numero, $capacidad, $precio, $descripcion, $servicios, $foto)
    {
        $slug = $this->generateSlug($estilo);
        $sql = "INSERT INTO habitaciones (estilo, numero, capacidad, precio, descripcion, servicios, foto, slug) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $datos = array($estilo, $numero, $capacidad, $precio, $descripcion, $servicios, $foto, $slug);
        return $this->insert($sql, $datos);
    }

    public function getHabitacion($id)
    {
        $sql = "SELECT * FROM habitaciones WHERE id = ?";
        return $this->select($sql, [$id]);
    }

    public function actualizarHabitacion($estilo, $numero, $capacidad, $precio, $descripcion, $servicios, $foto, $id)
    {
        $slug = $this->generateSlug($estilo);
        $sql = "UPDATE habitaciones SET estilo = ?, numero = ?, capacidad = ?, precio = ?, descripcion = ?, servicios = ?, foto = ?, slug = ? WHERE id = ?";
        $datos = array($estilo, $numero, $capacidad, $precio, $descripcion, $servicios, $foto, $slug, $id);
        return $this->save($sql, $datos);
    }

    public function eliminarHabitacion($id)
    {
        $sql = "UPDATE habitaciones SET estado = 0 WHERE id = ?";
        return $this->save($sql, [$id]);
    }
    
    public function reingresarHabitacion($id)
    {
        $sql = "UPDATE habitaciones SET estado = 1 WHERE id = ?";
        return $this->save($sql, [$id]);
    }

    private function generateSlug($text)
    {
        $text = preg_replace('~[^\\pL\\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    // Métodos para la galería
    public function getGaleria($id_habitacion)
    {
        $sql = "SELECT * FROM galeria_habitaciones WHERE id_habitacion = ?";
        $data = $this->selectAll($sql, [$id_habitacion]);
        return is_array($data) ? $data : [];
    }

    public function insertarImagenGaleria($imagen, $id_habitacion)
    {
        $sql = "INSERT INTO galeria_habitaciones (imagen, id_habitacion) VALUES (?, ?)";
        $datos = array($imagen, $id_habitacion);
        return $this->insert($sql, $datos);
    }

    public function getFoto($id)
    {
        $sql = "SELECT * FROM galeria_habitaciones WHERE id = ?";
        return $this->select($sql, [$id]);
    }

    public function eliminarFotoGaleria($id)
    {
        $sql = "DELETE FROM galeria_habitaciones WHERE id = ?";
        return $this->save($sql, [$id]);
    }
}
?>