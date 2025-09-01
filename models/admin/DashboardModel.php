<?php
class DashboardModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    // -- Métricas para Tarjetas de Resumen --

    // Obtener el total de usuarios (clientes)
    public function getTotalClientes()
    {
        $query = "SELECT COUNT(*) AS total FROM usuarios WHERE rol = 3 AND estado = 1";
        return $this->select($query);
    }

    // Obtener el total de habitaciones
    public function getTotalHabitaciones()
    {
        $query = "SELECT COUNT(*) AS total FROM habitaciones";
        return $this->select($query);
    }

    // Obtener el total de reservas
    public function getTotalReservas()
    {
        $query = "SELECT COUNT(*) AS total FROM reservas";
        return $this->select($query);
    }

    // Obtener los ingresos totales
    public function getIngresosTotales()
    {
        $query = "SELECT SUM(monto) AS total FROM reservas";
        return $this->select($query);
    }

    // -- Datos para Gráficos y Tablas --

    // Obtener las reservas de los últimos 12 meses
    public function getReservasMensuales()
    {
        $query = "SELECT DATE_FORMAT(fecha_reserva, '%Y-%m') AS mes, COUNT(id) AS total 
                  FROM reservas 
                  WHERE fecha_reserva >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) 
                  GROUP BY mes 
                  ORDER BY mes ASC";
        return $this->selectAll($query);
    }

    // Obtener las últimas reservas registradas
    public function getUltimasReservas()
    {
        $query = "SELECT r.*, u.nombre AS cliente, h.estilo AS habitacion 
                  FROM reservas r 
                  JOIN usuarios u ON r.id_usuario = u.id 
                  JOIN habitaciones h ON r.id_habitacion = h.id 
                  ORDER BY r.fecha_reserva DESC 
                  LIMIT 5";
        return $this->selectAll($query);
    }
    
    // -- NUEVA FUNCIÓN PARA GRÁFICO EN TIEMPO REAL --
    public function getConteoEstadoReservas()
    {
        $query = "SELECT estado, COUNT(*) AS total FROM reservas GROUP BY estado";
        return $this->selectAll($query);
    }

}
?>