<?php
class ReservaModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }

    // Obtener reservas disponibles para una habitación específica entre fechas
    public function getDisponible($f_llegada, $f_salida, $habitacion)
    {
        $query = "SELECT * FROM reservas 
                  WHERE fecha_ingreso <= :f_salida
                  AND fecha_salida >= :f_llegada 
                  AND id_habitacion = :habitacion";
        $params = [
            ':f_llegada' => $f_llegada,
            ':f_salida' => $f_salida,
            ':habitacion' => $habitacion
        ];
        return $this->selectAll($query, $params);
    }

    // Obtener todas las reservas de una habitación
    public function getReservasHabitacion($habitacion)
    {
        $query = "SELECT * FROM reservas 
                  WHERE id_habitacion = :habitacion";
        $params = [':habitacion' => $habitacion];
        return $this->selectAll($query, $params);
    }

    // Recuperar todas las habitaciones disponibles
    public function getHabitaciones()
    {
        return $this->selectAll("SELECT * FROM habitaciones WHERE estado = 1");
    }

    // Recuperar información de una habitación específica
    public function getHabitacion($id_habitacion)
    {
        $query = "SELECT * FROM habitaciones WHERE id = :id_habitacion";
        $params = [':id_habitacion' => $id_habitacion];
        return $this->select($query, $params);
    }
}
