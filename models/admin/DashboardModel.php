<?php
class DashboardModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    // 1. Total de reservas confirmadas realizadas HOY
    public function getReservasHoy()
    {
        $hoy = date('Y-m-d');
        $sql = "SELECT COUNT(id) AS total FROM reservas WHERE DATE(fecha_reserva) = ? AND estado = 1";
        return $this->select($sql, [$hoy]);
    }

    // 2. Total de habitaciones disponibles (considerando habitaciones activas menos las ocupadas hoy)
    public function getHabitacionesDisponibles()
    {
        $hoy = date('Y-m-d');
        // Primero, contamos el total de habitaciones activas
        $totalHabitaciones = $this->select("SELECT COUNT(id) AS total FROM habitaciones WHERE estado = 1");

        // Luego, contamos las habitaciones ocupadas hoy
        $habitacionesOcupadas = $this->select(
            "SELECT COUNT(DISTINCT id_habitacion) AS total FROM reservas WHERE ? BETWEEN fecha_ingreso AND fecha_salida AND estado = 1",
            [$hoy]
        );

        return $totalHabitaciones['total'] - $habitacionesOcupadas['total'];
    }

    // 3. Suma de los ingresos de las reservas confirmadas en el MES ACTUAL
    public function getIngresosMes()
    {
        $mes_actual = date('Y-m');
        $sql = "SELECT SUM(monto) AS total FROM reservas WHERE DATE_FORMAT(fecha_reserva, '%Y-%m') = ? AND estado = 1";
        $result = $this->select($sql, [$mes_actual]);
        // Si no hay ingresos, devolver 0.00 en lugar de NULL
        return ($result['total']) ? $result['total'] : 0.00;
    }

    // 4. Total de clientes registrados y activos
    public function getTotalClientes()
    {
        $sql = "SELECT COUNT(id) AS total FROM usuarios WHERE rol = 3 AND estado = 1";
        return $this->select($sql);
    }

    // 5. Datos para el gráfico: Conteo de reservas confirmadas de los últimos 7 días
    public function getReservasUltimaSemana()
    {
        $sql = "SELECT DATE(fecha_reserva) as fecha, COUNT(id) as total 
                FROM reservas 
                WHERE fecha_reserva >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND estado = 1
                GROUP BY DATE(fecha_reserva)
                ORDER BY fecha ASC";
        return $this->selectAll($sql);
    }

    // 6. Tabla de últimas 5 reservas (uniendo con cliente y habitación)
    public function getUltimasReservas()
    {
        $sql = "SELECT r.fecha_reserva, r.estado, u.nombre AS cliente, h.estilo AS habitacion
                FROM reservas r
                INNER JOIN usuarios u ON r.id_usuario = u.id
                INNER JOIN habitaciones h ON r.id_habitacion = h.id
                ORDER BY r.fecha_reserva DESC
                LIMIT 5";
        return $this->selectAll($sql);
    }
}
?>