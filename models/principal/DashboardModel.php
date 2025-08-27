<?php
class DashboardModel extends Conexion
{
    public function getReservasHoy()
    {
        $sql = "SELECT COUNT(*) AS total FROM reservas WHERE DATE(fecha_reserva) = CURDATE()";
        return $this->select($sql);
    }

    public function getHabitacionesDisponibles()
    {
        $sql = "SELECT COUNT(*) AS total FROM habitaciones WHERE estado = 'Disponible'";
        return $this->select($sql);
    }

    public function getIngresosMes()
    {
        $sql = "SELECT IFNULL(SUM(total), 0) AS total FROM reservas 
                WHERE MONTH(fecha_reserva) = MONTH(CURDATE()) 
                AND YEAR(fecha_reserva) = YEAR(CURDATE())";
        return $this->select($sql);
    }

    public function getTotalClientes()
    {
        $sql = "SELECT COUNT(*) AS total FROM clientes";
        return $this->select($sql);
    }

    public function getReservasMensuales()
    {
        $sql = "SELECT MONTH(fecha_reserva) AS mes, COUNT(*) AS total 
                FROM reservas 
                WHERE YEAR(fecha_reserva) = YEAR(CURDATE()) 
                GROUP BY mes ORDER BY mes";
        return $this->selectAll($sql);
    }

    public function getUltimasReservas()
    {
        $sql = "SELECT r.fecha_reserva, r.estado, h.nombre AS habitacion, c.nombre AS cliente
                FROM reservas r
                INNER JOIN habitaciones h ON r.habitacion_id = h.id
                INNER JOIN clientes c ON r.cliente_id = c.id
                ORDER BY r.fecha_reserva DESC LIMIT 5";
        return $this->selectAll($sql);
    }
}
