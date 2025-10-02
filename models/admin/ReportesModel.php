<?php
class ReportesModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Obtener datos según tipo de reporte y rango de fechas
     */
    public function obtenerDatos($tipoReporte, $fechaInicio, $fechaFin)
    {
        switch ($tipoReporte) {
            case 'reservas':
                return $this->getReservas($fechaInicio, $fechaFin);
            case 'usuarios': // usamos "usuarios", ya que no existe tabla clientes
                return $this->getUsuarios($fechaInicio, $fechaFin);
            case 'habitaciones':
                return $this->getHabitaciones($fechaInicio, $fechaFin);
            default:
                return [];
        }
    }

    // -------------------- RESERVAS --------------------

    private function getReservas($fechaInicio, $fechaFin)
    {
        $sql = "SELECT r.id, CONCAT('Reserva de ', u.nombre) AS detalle, r.fecha_reserva AS fecha
            FROM reservas r
            INNER JOIN usuarios u ON r.id_usuario = u.id
            WHERE r.fecha_reserva BETWEEN ? AND ?
            ORDER BY r.fecha_reserva ASC";
        return $this->selectAll($sql, [$fechaInicio, $fechaFin]);
    }


    // -------------------- USUARIOS --------------------
    private function getUsuarios($fechaInicio, $fechaFin)
    {
        $sql = "SELECT id, CONCAT(nombre, ' (', correo, ')') AS detalle, fecha 
                FROM usuarios 
                WHERE fecha BETWEEN ? AND ? 
                ORDER BY fecha ASC";
        return $this->selectAll($sql, [$fechaInicio, $fechaFin]);
    }

    // -------------------- HABITACIONES --------------------
    private function getHabitaciones($fechaInicio, $fechaFin)
    {
        $sql = "SELECT id, CONCAT('Habitación ', numero) AS detalle, fecha AS fecha
            FROM habitaciones
            WHERE fecha BETWEEN ? AND ?
            ORDER BY fecha ASC";
        return $this->selectAll($sql, [$fechaInicio, $fechaFin]);
    }

}
