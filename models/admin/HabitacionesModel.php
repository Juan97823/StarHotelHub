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
        return $this->selectAll($sql);
    }

    public function registrarHabitacion($estilo, $capacidad, $precio, $descripcion, $servicios, $foto)
    {
        $slug = $this->generateSlug($estilo);
        $sql = "INSERT INTO habitaciones (estilo, capacidad, precio, descripcion, servicios, foto, slug) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $datos = array($estilo, $capacidad, $precio, $descripcion, $servicios, $foto, $slug);
        return $this->insertar($sql, $datos);
    }

    public function getHabitacion($id)
    {
        $sql = "SELECT * FROM habitaciones WHERE id = ?";
        return $this->select($sql, [$id]);
    }

    public function actualizarHabitacion($estilo, $capacidad, $precio, $descripcion, $servicios, $foto, $id)
    {
        $slug = $this->generateSlug($estilo);
        $sql = "UPDATE habitaciones SET estilo = ?, capacidad = ?, precio = ?, descripcion = ?, servicios = ?, foto = ?, slug = ? WHERE id = ?";
        $datos = array($estilo, $capacidad, $precio, $descripcion, $servicios, $foto, $slug, $id);
        return $this->save($sql, $datos);
    }

    public function eliminarHabitacion($id)
    {
        $sql = "UPDATE habitaciones SET estado = 0 WHERE id = ?";
        return $this->save($sql, [$id]);
    }

    private function generateSlug($text)
    {
        $text = preg_replace('~[\\pL\\d]+~', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        $text = preg_replace('~[^\\w]+~', '', $text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }
}
?>
