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
        $result = $this->select($sql, [$hoy]);
        return ($result && isset($result['total'])) ? $result : ['total' => 0];
    }

    // 2. Total de habitaciones disponibles
    public function getHabitacionesDisponibles()
    {
        $hoy = date('Y-m-d');
        $totalHabitaciones = $this->select("SELECT COUNT(id) AS total FROM habitaciones WHERE estado = 1");
        $habitacionesOcupadas = $this->select(
            "SELECT COUNT(DISTINCT id_habitacion) AS total FROM reservas WHERE ? BETWEEN fecha_ingreso AND fecha_salida AND estado = 1",
            [$hoy]
        );

        $total = ($totalHabitaciones && isset($totalHabitaciones['total'])) ? $totalHabitaciones['total'] : 0;
        $ocupadas = ($habitacionesOcupadas && isset($habitacionesOcupadas['total'])) ? $habitacionesOcupadas['total'] : 0;

        // Devolver un array con la clave 'total' para consistencia con otros métodos
        return ['total' => $total - $ocupadas];
    }

    // 3. Suma de los ingresos del MES ACTUAL
    public function getIngresosMes()
    {
        $mes_actual = date('Y-m');
        $sql = "SELECT SUM(monto) AS total FROM reservas WHERE DATE_FORMAT(fecha_reserva, '%Y-%m') = ? AND estado = 1";
        $result = $this->select($sql, [$mes_actual]);
        // Devolver un array con la clave 'total' para consistencia con otros métodos
        return ['total' => ($result && isset($result['total'])) ? (float) $result['total'] : 0.00];
    }

    // 4. Total de clientes registrados y activos
    public function getTotalClientes()
    {
        $sql = "SELECT COUNT(id) AS total FROM usuarios WHERE rol = 3 AND estado = 1";
        $result = $this->select($sql);
        return ($result && isset($result['total'])) ? $result : ['total' => 0];
    }

    // 5. Datos para el gráfico: Conteo de reservas de los últimos 7 días
    public function getReservasUltimaSemana()
    {
        $sql = "SELECT DATE(fecha_reserva) as fecha, COUNT(id) as total 
                FROM reservas 
                WHERE fecha_reserva >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND estado = 1
                GROUP BY DATE(fecha_reserva)
                ORDER BY fecha ASC";
        $data = $this->selectAll($sql);
        return is_array($data) ? $data : [];
    }

    // 6. Tabla de últimas 5 reservas
    public function getUltimasReservas()
    {
        $sql = "SELECT r.fecha_reserva, r.estado, u.nombre AS cliente, h.estilo AS habitacion
                FROM reservas r
                INNER JOIN usuarios u ON r.id_usuario = u.id
                INNER JOIN habitaciones h ON r.id_habitacion = h.id
                ORDER BY r.fecha_reserva DESC
                LIMIT 5";
        $data = $this->selectAll($sql);
        return is_array($data) ? $data : [];
    }
}
