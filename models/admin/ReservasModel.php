<?php

class ReservasModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtener todas las reservas
    public function getReservas($soloActivas = false)
    {
        $sql = "SELECT r.id, r.monto, r.num_transaccion, r.cod_reserva, r.fecha_ingreso, r.fecha_salida, r.descripcion, r.estado,
                   h.estilo AS habitacion, u.nombre AS cliente
            FROM reservas r
            INNER JOIN habitaciones h ON r.id_habitacion = h.id
            INNER JOIN usuarios u ON r.id_usuario = u.id";

        if ($soloActivas) {
            $sql .= " WHERE r.estado IN (1, 2)"; // 1 = Pendiente, 2 = Confirmado
        }

        $sql .= " ORDER BY r.fecha_ingreso DESC";

        return $this->selectAll($sql) ?? [];
    }

    // Obtener una reserva por ID
    public function getReserva($id)
    {
        $sql = "SELECT * FROM reservas WHERE id = ?";
        return $this->select($sql, [$id]);
    }
    
    // Guardar o actualizar reserva
    public function guardarReserva($datos)
    {
        if (empty($datos['idReserva'])) {
            $sql = "INSERT INTO reservas (id_habitacion, id_usuario, fecha_ingreso, fecha_salida, monto, estado)
                    VALUES (?, ?, ?, ?, ?, 1)"; // Por defecto, estado 1 = Pendiente
            $params = [
                $datos['habitacion'],
                $datos['cliente'],
                $datos['fecha_ingreso'],
                $datos['fecha_salida'],
                $datos['monto']
            ];
            return $this->save($sql, $params);
        } else {
            $sql = "UPDATE reservas SET id_habitacion=?, id_usuario=?, fecha_ingreso=?, fecha_salida=?, monto=?
                    WHERE id=?";
            $params = [
                $datos['habitacion'],
                $datos['cliente'],
                $datos['fecha_ingreso'],
                $datos['fecha_salida'],
                $datos['monto'],
                $datos['idReserva']
            ];
            return $this->save($sql, $params);
        }
    }

    // Cambiar el estado de una reserva
    public function cambiarEstadoReserva($id, $estado)
    {
        $sql = "UPDATE reservas SET estado = ? WHERE id = ?";
        return $this->save($sql, [$estado, $id]);
    }
}
