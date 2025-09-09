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
        // Se genera el slug solo a partir del estilo
        $slug = $this->generateSlug($estilo);
        $sql = "INSERT INTO habitaciones (estilo, numero, capacidad, precio, descripcion, servicios, foto, slug, estado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)";
        $datos = [$estilo, $numero, $capacidad, $precio, $descripcion, $servicios, $foto, $slug];
        return $this->insert($sql, $datos);
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
        // Se genera el slug a partir del estilo y se pasa el ID para evitar colisiones con el mismo registro
        $slug = $this->generateSlug($estilo, $id);
        $sql = "UPDATE habitaciones 
                SET estilo = ?, numero = ?, capacidad = ?, precio = ?, descripcion = ?, servicios = ?, foto = ?, slug = ? 
                WHERE id = ?";
        $datos = [$estilo, $numero, $capacidad, $precio, $descripcion, $servicios, $foto, $slug, $id];
        return $this->save($sql, $datos);
    }

    // Inhabilitar habitación
    public function inhabilitarHabitacion($id)
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

    // Generar slug único y robusto
    private function generateSlug($text, $id_to_ignore = null)
    {
        $base_slug = preg_replace('~[^\\pL\\d]+~u', '-', $text);
        $base_slug = trim($base_slug, '-');
        $base_slug = strtolower($base_slug);
        $slug = !empty($base_slug) ? $base_slug : 'n-a';

        $counter = 0;
        $temp_slug = $slug;
        
        while (true) {
            $sql = "SELECT id FROM habitaciones WHERE slug = ?";
            $params = [$temp_slug];
            
            if ($id_to_ignore !== null) {
                $sql .= " AND id != ?";
                $params[] = $id_to_ignore;
            }

            $result = $this->select($sql, $params);

            if (empty($result)) {
                return $temp_slug; // El slug es único
            }

            $counter++;
            $temp_slug = $slug . '-' . $counter;
        }
    }

    // -------------------- GALERÍA --------------------

    public function getGaleria($id_habitacion, $soloActivas = true)
    {
        $sql = "SELECT * FROM galeria_habitaciones WHERE id_habitacion = ?";
        if ($soloActivas) {
            $sql .= " AND estado = 1";
        }
        return $this->selectAll($sql, [$id_habitacion]) ?? [];
    }

    public function insertarImagenGaleria($imagen, $id_habitacion)
    {
        $sql = "INSERT INTO galeria_habitaciones (imagen, id_habitacion, estado) VALUES (?, ?, 1)";
        return $this->insert($sql, [$imagen, $id_habitacion]);
    }

    public function getFoto($id)
    {
        $sql = "SELECT * FROM galeria_habitaciones WHERE id = ?";
        return $this->select($sql, [$id]) ?? [];
    }

    // Inhabilitar foto
    public function inhabilitarFotoGaleria($id)
    {
        $sql = "UPDATE galeria_habitaciones SET estado = 0 WHERE id = ?";
        return $this->save($sql, [$id]);
    }

    // Reactivar foto
    public function reingresarFotoGaleria($id)
    {
        $sql = "UPDATE galeria_habitaciones SET estado = 1 WHERE id = ?";
        return $this->save($sql, [$id]);
    }
}
