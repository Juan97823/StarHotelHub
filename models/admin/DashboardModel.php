<?php
class DashboardModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Obtiene el número total de reservas confirmadas en el día actual.
     * @return array - Array con el total de reservas.
     */
    public function getReservasHoy()
    {
        $hoy = date('Y-m-d');
        $sql = "SELECT COUNT(id) AS total FROM reservas WHERE DATE(fecha_reserva) = ? AND estado = 1";
        $resultado = $this->select($sql, [$hoy]);
        return ['total' => $resultado['total'] ?? 0];
    }

    /**
     * Obtiene el número de habitaciones disponibles para el día actual.
     * @return array - Array con el total de habitaciones disponibles.
     */
    public function getHabitacionesDisponibles()
    {
        $hoy = date('Y-m-d');
        $sqlTotal = "SELECT COUNT(id) AS total FROM habitaciones WHERE estado = 1";
        $sqlOcupadas = "SELECT COUNT(DISTINCT id_habitacion) AS total FROM reservas WHERE ? BETWEEN fecha_ingreso AND fecha_salida AND estado = 1";
        
        $totalHabitaciones = $this->select($sqlTotal)['total'] ?? 0;
        $ocupadas = $this->select($sqlOcupadas, [$hoy])['total'] ?? 0;

        return ['total' => $totalHabitaciones - $ocupadas];
    }

    /**
     * Obtiene la suma total de los ingresos de reservas confirmadas en el mes actual.
     * @return array - Array con el total de ingresos.
     */
    public function getIngresosMes()
    {
        $mesActual = date('Y-m');
        $sql = "SELECT SUM(monto) AS total FROM reservas WHERE DATE_FORMAT(fecha_reserva, '%Y-%m') = ? AND estado = 1";
        $resultado = $this->select($sql, [$mesActual]);
        return ['total' => (float)($resultado['total'] ?? 0.0)];
    }

    /**
     * Obtiene el número total de clientes activos y registrados.
     * Se asume que el rol de cliente es 3.
     * @return array - Array con el total de clientes.
     */
    public function getTotalClientes()
    {
        $sql = "SELECT COUNT(id) AS total FROM usuarios WHERE rol = 3 AND estado = 1";
        $resultado = $this->select($sql);
        return ['total' => $resultado['total'] ?? 0];
    }

    /**
     * Obtiene el conteo de reservas por día de los últimos 7 días.
     * @return array - Lista de reservas con fecha y total.
     */
    public function getReservasUltimaSemana()
    {
        $sql = "SELECT DATE(fecha_reserva) AS fecha, COUNT(id) AS total 
                FROM reservas 
                WHERE fecha_reserva >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND estado = 1
                GROUP BY DATE(fecha_reserva) 
                ORDER BY fecha ASC";
        return $this->selectAll($sql) ?? [];
    }

    /**
     * Obtiene las últimas N reservas con información del cliente y la habitación.
     * @param int $limite - El número de reservas a obtener.
     * @return array - Lista de las últimas reservas.
     */
    public function getUltimasReservas($limite = 5)
    {
        $sql = "SELECT r.id, r.fecha_reserva, r.fecha_ingreso, r.estado, u.nombre AS cliente, h.estilo AS habitacion
                FROM reservas r
                INNER JOIN usuarios u ON r.id_usuario = u.id
                INNER JOIN habitaciones h ON r.id_habitacion = h.id
                ORDER BY r.fecha_reserva DESC
                LIMIT ?";
        return $this->selectAll($sql, [$limite]) ?? [];
    }
}
?>