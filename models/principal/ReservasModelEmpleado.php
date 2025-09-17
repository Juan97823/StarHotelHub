<?php

class ReservasModelEmpleado extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Obtener todas las reservas.
     */
    public function getReservas($soloActivas = false)
    {
        $sql = "SELECT r.id, r.cod_reserva, r.fecha_ingreso, r.fecha_salida, r.monto, r.descripcion, r.estado,
                       u.nombre AS cliente, h.estilo AS habitacion
                FROM reservas r
                INNER JOIN usuarios u ON r.id_usuario = u.id
                INNER JOIN habitaciones h ON r.id_habitacion = h.id";

        if ($soloActivas) {
            $sql .= " WHERE r.estado = 1";
        }

        $sql .= " ORDER BY r.fecha_ingreso DESC";

        return $this->selectAll($sql) ?? [];
    }

    /**
     * Contar todas las reservas.
     */
    public function getCantidadReservas()
    {
        $sql = "SELECT COUNT(id) AS total FROM reservas";
        return $this->select($sql);
    }

    /**
     * Contar reservas por estado (1 = activas, 0 = canceladas).
     */
    public function getCantidadReservasByEstado($estado)
    {
        $sql = "SELECT COUNT(id) AS total FROM reservas WHERE estado = ?";
        return $this->select($sql, [$estado]);
    }

    /**
     * Obtener últimas reservas registradas.
     */
    public function getUltimasReservas($limite = 5)
    {
        $limite = (int) $limite; // Seguridad
        $sql = "SELECT r.id, r.cod_reserva, r.fecha_ingreso, r.fecha_salida, r.estado,
                       u.nombre AS cliente, h.estilo AS habitacion
                FROM reservas r
                INNER JOIN usuarios u ON r.id_usuario = u.id
                INNER JOIN habitaciones h ON r.id_habitacion = h.id
                ORDER BY r.fecha_ingreso DESC
                LIMIT $limite";
        return $this->selectAll($sql) ?? [];
    }

    /**
     * Obtener una reserva por ID.
     */
    public function getReserva($id)
    {
        $sql = "SELECT r.id, r.cod_reserva, r.fecha_ingreso, r.fecha_salida, 
                       r.monto, r.descripcion, r.estado,
                       h.estilo AS habitacion, u.nombre AS cliente
                FROM reservas r
                INNER JOIN habitaciones h ON r.id_habitacion = h.id
                INNER JOIN usuarios u ON r.id_usuario = u.id
                WHERE r.id = ?";
        return $this->select($sql, [$id]);
    }

    /**
     * Crear nueva reserva (registrada por un empleado).
     */
    public function registrarReserva($datos)
    {
        $sql = "INSERT INTO reservas 
                    (id_habitacion, id_usuario, fecha_ingreso, fecha_salida, monto, descripcion, estado) 
                VALUES (?, ?, ?, ?, ?, ?, 1)";
        $params = [
            $datos['habitacion'],
            $datos['cliente'],
            $datos['fecha_ingreso'],
            $datos['fecha_salida'],
            $datos['monto'],
            $datos['descripcion'] ?? null
        ];
        return $this->save($sql, $params);
    }

    /**
     * Actualizar una reserva existente.
     */
    public function actualizarReserva($datos)
    {
        $sql = "UPDATE reservas 
                SET id_habitacion=?, id_usuario=?, fecha_ingreso=?, fecha_salida=?, monto=?, descripcion=? 
                WHERE id=?";
        $params = [
            $datos['habitacion'],
            $datos['cliente'],
            $datos['fecha_ingreso'],
            $datos['fecha_salida'],
            $datos['monto'],
            $datos['descripcion'] ?? null,
            $datos['idReserva']
        ];
        return $this->save($sql, $params);
    }

    /**
     * Cancelar (inhabilitar) una reserva.
     */
    public function cancelarReserva($id)
    {
        $sql = "UPDATE reservas SET estado = 0 WHERE id = ?";
        return $this->save($sql, [$id]);
    }
}
