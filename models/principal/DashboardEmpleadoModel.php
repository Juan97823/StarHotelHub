<?php
class DashboardEmpleadoModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getReservasAtendidas($id_empleado)
    {
        $sql = "SELECT COUNT(id) AS total FROM reservas WHERE id_empleado = ? AND estado = 1 AND fecha_salida < CURDATE()";
        $result = $this->select($sql, [$id_empleado]);
        return $result['total'] ?? 0;
    }

    public function getProximasReservas($id_empleado)
    {
        $sql = "SELECT COUNT(id) AS total FROM reservas WHERE id_empleado = ? AND estado = 1 AND fecha_ingreso > CURDATE()";
        $result = $this->select($sql, [$id_empleado]);
        return $result['total'] ?? 0;
    }

    public function getClientesNuevos($id_empleado)
    {
        $sql = "SELECT COUNT(id) AS total FROM usuarios WHERE registrado_por = ? AND fecha >= CURDATE() - INTERVAL 30 DAY";
        $result = $this->select($sql, [$id_empleado]);
        return $result['total'] ?? 0;
    }

    public function getIncidenciasReportadas($id_empleado)
    {
        $sql = "SELECT COUNT(id) AS total FROM incidencias WHERE id_empleado = ? AND estado != 'resuelta'";
        $result = $this->select($sql, [$id_empleado]);
        return $result['total'] ?? 0;
    }

    public function getUltimasReservas($id_empleado)
    {
        $sql = "SELECT r.id, r.fecha_ingreso AS checkin, r.fecha_salida AS checkout, r.estado, u.nombre AS cliente, h.estilo AS habitacion
                FROM reservas r
                INNER JOIN usuarios u ON r.id_usuario = u.id
                INNER JOIN habitaciones h ON r.id_habitacion = h.id
                WHERE r.id_empleado = ?
                ORDER BY r.fecha_reserva DESC
                LIMIT 5";
        return $this->selectAll($sql, [$id_empleado]);
    }
}
