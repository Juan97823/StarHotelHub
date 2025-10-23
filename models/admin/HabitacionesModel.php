<?php
class HabitacionesModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtener todas las habitaciones (opcional: solo activas)
    public function getHabitaciones($soloActivas = true)
    {
        $sql = "SELECT * FROM habitaciones WHERE 1=1";
        if ($soloActivas) {
            $sql .= " AND estado = 1";
        }
        return $this->selectAll($sql) ?? [];
    }

    // Registrar nueva habitación
    public function registrarHabitacion($estilo, $numero, $capacidad, $precio, $descripcion, $servicios, $foto)
    {
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

    // Generar slug único
    private function generateSlug($text, $id_to_ignore = null)
    {
        // Normalizar texto
        $base_slug = preg_replace('~[^\\pL\\d]+~u', '-', $text);
        $base_slug = iconv('UTF-8', 'ASCII//TRANSLIT', $base_slug);
        $base_slug = preg_replace('~[^-a-z0-9]+~', '', strtolower($base_slug));
        $base_slug = trim($base_slug, '-');
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
                return $temp_slug;
            }

            $counter++;
            $temp_slug = $slug . '-' . $counter;
        }
    }
}
