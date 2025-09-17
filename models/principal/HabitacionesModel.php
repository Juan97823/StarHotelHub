<?php
class HabitacionesModel extends Query {

    public function __construct()
    {
        parent::__construct();
    }

    // 🔹 Obtener todas las habitaciones activas
    public function getHabitaciones()
    {
        $sql = "SELECT * FROM habitaciones WHERE estado = 1";
        return $this->selectAll($sql);
    }

    // 🔹 Obtener una habitación por slug (seguro con parámetro)
    public function getHabitacionBySlug($slug)
    {
        $sql = "SELECT * FROM habitaciones WHERE slug = ? AND estado = 1";
        return $this->select($sql, [$slug]);
    }

    // 🔹 (Opcional) Obtener habitación por ID
    public function getHabitacionById($id)
    {
        $sql = "SELECT * FROM habitaciones WHERE id = ? AND estado = 1";
        return $this->select($sql, [$id]);
    }

    // 🔹 (Opcional) Obtener todas las habitaciones (admin)
    public function getTodasHabitaciones()
    {
        $sql = "SELECT * FROM habitaciones";
        return $this->selectAll($sql);
    }
}
?>
