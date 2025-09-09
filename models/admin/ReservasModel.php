<?php
class ReservasModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtener reservas activas
    public function getReservas($soloActivas = true)
    {
        $sql = "SELECT r.*, h.estilo AS habitacion, u.nombre AS cliente
                FROM reservas r
                INNER JOIN habitaciones h ON r.id_habitacion = h.id
                INNER JOIN usuarios u ON r.id_usuario = u.id";
        
        if ($soloActivas) {
            $sql .= " WHERE r.estado = 1";
        }

        return $this->selectAll($sql) ?? [];
    }

    // Inhabilitar reserva (no borrar)
    public function inhabilitarReserva($id)
    {
        $sql = "UPDATE reservas SET estado = 0 WHERE id = ?";
        return $this->save($sql, [$id]);
    }

    // Reactivar reserva
    public function reingresarReserva($id)
    {
        $sql = "UPDATE reservas SET estado = 1 WHERE id = ?";
        return $this->save($sql, [$id]);
    }
}
?>
