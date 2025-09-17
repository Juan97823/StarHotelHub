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

    // Recuperar información de una habitación específica por su slug
    public function getHabitacionBySlug($slug)
    {
        $query = "SELECT * FROM habitaciones WHERE slug = :slug";
        $params = [':slug' => $slug];
        return $this->select($query, $params);
    }

    // Obtener todas las reservas de un cliente
    public function getReservasCliente($id_usuario)
    {
        $query = "SELECT r.*, h.estilo AS tipo, r.monto AS monto_total
                  FROM reservas r
                  JOIN habitaciones h ON r.id_habitacion = h.id
                  WHERE r.id_usuario = :id_usuario";
        $params = [':id_usuario' => $id_usuario];
        return $this->selectAll($query, $params);
    }

    // Contar el total de reservas de un cliente
    public function getCantidadReservas($id_usuario)
    {
        $query = "SELECT COUNT(*) AS total FROM reservas WHERE id_usuario = :id_usuario";
        $params = [':id_usuario' => $id_usuario];
        return $this->select($query, $params);
    }

    // Contar las reservas de un cliente por estado
    public function getCantidadReservasByEstado($id_usuario, $estado)
    {
        $query = "SELECT COUNT(*) AS total FROM reservas WHERE id_usuario = :id_usuario AND estado = :estado";
        $params = [':id_usuario' => $id_usuario, ':estado' => $estado];
        return $this->select($query, $params);
    }
}
