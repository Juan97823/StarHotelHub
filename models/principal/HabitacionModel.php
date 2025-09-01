<?php
class HabitacionesModel extends Query {

    public function __construct()
    {
        parent::__construct();
    }

    public function getHabitaciones()
    {
        return $this->selectAll("SELECT * FROM habitaciones WHERE estado = 1");
    }

    public function getHabitacionBySlug($slug)
    {
        return $this->select("SELECT * FROM habitaciones WHERE slug = '$slug' AND estado = 1");
    }

}
?>