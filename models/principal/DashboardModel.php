<?php
class DashboardModel extends Query
{
    public function getReservasHoy()
    {
        $sql = "SELECT COUNT(*) AS total FROM reservas WHERE DATE(fecha_reserva) = CURDATE()";
        return $this->select($sql);
    }

    public function getHabitacionesDisponibles()
    {
        // estado = 1 significa disponible (no string 'Disponible')
        $sql = "SELECT COUNT(*) AS total FROM habitaciones WHERE estado = 1";
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
        // Tabla correcta: usuarios (no clientes)
        $sql = "SELECT COUNT(*) AS total FROM usuarios WHERE rol = 3";
        return $this->select($sql);
    }

    public function getReservasMensuales()
    {
        $sql = "SELECT MONTH(fecha_ingreso) AS mes, COUNT(*) AS total
                FROM reservas
                WHERE YEAR(fecha_ingreso) = YEAR(CURDATE())
                GROUP BY mes ORDER BY mes";
        return $this->selectAll($sql);
    }

    public function getUltimasReservas()
    {
        // Corregir nombres de columnas según schema real
        $sql = "SELECT r.fecha_ingreso, r.estado, h.estilo AS habitacion, u.nombre AS cliente
                FROM reservas r
                INNER JOIN habitaciones h ON r.id_habitacion = h.id
                INNER JOIN usuarios u ON r.id_usuario = u.id
                ORDER BY r.fecha_ingreso DESC LIMIT 5";
        return $this->selectAll($sql);
    }
}
