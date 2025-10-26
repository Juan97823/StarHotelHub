<?php
class EmpleadoModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    // ... (métodos existentes de getDatos, getReservas, etc.) ...
    // Método genérico para obtener datos de una tabla (usado para habitaciones y clientes) - SEGURO
    public function getDatos($table)
    {
        // Validar tabla permitida
        $tablasPermitidas = ['clientes', 'habitaciones'];
        if (!in_array($table, $tablasPermitidas)) {
            return [];
        }

        if ($table == 'clientes') {
            // Los clientes son usuarios con rol 3
            $sql = "SELECT id, nombre FROM usuarios WHERE rol = 3 AND estado = 1";
        } else {
            // Obtener habitaciones activas con precio
            $sql = "SELECT id, estilo, numero, precio FROM habitaciones WHERE estado = 1";
        }
        return $this->selectAll($sql);
    }

    // Obtener todas las reservas para el DataTable del empleado
// Obtener todas las reservas para el DataTable del empleado
public function getReservas()
{
    $sql = "SELECT 
                r.id,
                h.estilo AS estilo_habitacion,
                u.nombre AS nombre_cliente,
                r.fecha_ingreso,
                r.fecha_salida,
                r.monto,
                CASE r.estado
                    WHEN 0 THEN 'Cancelada'
                    WHEN 1 THEN 'Confirmada'
                    WHEN 2 THEN 'Activa'
                    WHEN 3 THEN 'Completada'
                    ELSE 'Desconocido'
                END AS estado
            FROM reservas r
            INNER JOIN habitaciones h ON r.id_habitacion = h.id
            INNER JOIN usuarios u ON r.id_usuario = u.id
            ORDER BY r.id DESC";
    return $this->selectAll($sql);
}


    // Crear una nueva reserva
    public function crearReserva($idHabitacion, $idCliente, $fechaIngreso, $fechaSalida, $monto, $estadoStr)
    {
        $estadoInt = $this->mapEstadoToInt($estadoStr);
        $sql = "INSERT INTO reservas (id_habitacion, id_usuario, fecha_ingreso, fecha_salida, monto, estado, num_transaccion, cod_reserva, metodo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        // Generar valores temporales para campos no nulos
        $num_transaccion = 'EMP-' . time();
        $cod_reserva = 'EMP-' . rand(1000, 9999);
        $metodo = 3; // 3 = Manual/Empleado
        $datos = [$idHabitacion, $idCliente, $fechaIngreso, $fechaSalida, $monto, $estadoInt, $num_transaccion, $cod_reserva, $metodo];
        return $this->save($sql, $datos);
    }

    // Actualizar una reserva existente
    public function actualizarReserva($idReserva, $idHabitacion, $idCliente, $fechaIngreso, $fechaSalida, $monto)
    {
        $sql = "UPDATE reservas SET id_habitacion = ?, id_usuario = ?, fecha_ingreso = ?, fecha_salida = ?, monto = ? WHERE id = ?";
        $datos = [$idHabitacion, $idCliente, $fechaIngreso, $fechaSalida, $monto, $idReserva];
        return $this->save($sql, $datos);
    }

    // Cambiar el estado de una reserva (Check-In, Check-Out, Cancelar)
    public function cambiarEstadoReserva($idReserva, $nuevoEstadoStr)
    {
        $nuevoEstadoInt = $this->mapEstadoToInt($nuevoEstadoStr);
        $sql = "UPDATE reservas SET estado = ? WHERE id = ?";
        $datos = [$nuevoEstadoInt, $idReserva];
        return $this->save($sql, $datos);
    }
    
    // --- MÉTODOS PARA EL DASHBOARD DEL EMPLEADO ---

    // Contar reservas según fecha y estado
    public function contarReservasPorFecha($campoFecha, $estado)
    {
        $sql = "SELECT COUNT(id) AS total FROM reservas WHERE DATE($campoFecha) = CURDATE() AND estado = ?";
        return $this->select($sql, [$estado]);
    }

    // Contar habitaciones ocupadas (estado = Activa)
    public function contarHabitacionesOcupadas()
    {
        $sql = "SELECT COUNT(id) AS total FROM reservas WHERE estado = 2"; // 2 = Activa
        return $this->select($sql);
    }

    // Obtener la actividad del día (llegadas y salidas)
    public function getActividadDia()
    {
        $sql = "SELECT r.*, u.nombre as nombre_cliente, h.estilo as nombre_habitacion,
                (CASE WHEN r.fecha_ingreso = CURDATE() THEN 'llegada' ELSE 'salida' END) as tipo
                FROM reservas r
                INNER JOIN usuarios u ON r.id_usuario = u.id
                INNER JOIN habitaciones h ON r.id_habitacion = h.id
                WHERE (r.fecha_ingreso = CURDATE() AND r.estado = 1) OR (r.fecha_salida = CURDATE() AND r.estado = 2)";
        return $this->selectAll($sql);
    }

    // Obtener llegadas esperadas para hoy
    public function getLlegadasHoy()
    {
        $sql = "SELECT r.id, r.fecha_ingreso, r.fecha_salida, u.nombre as nombre_cliente, h.estilo as nombre_habitacion
                FROM reservas r
                INNER JOIN usuarios u ON r.id_usuario = u.id
                INNER JOIN habitaciones h ON r.id_habitacion = h.id
                WHERE DATE(r.fecha_ingreso) = CURDATE() AND r.estado = 1
                ORDER BY r.fecha_ingreso ASC";
        return $this->selectAll($sql);
    }

    // Obtener salidas esperadas para hoy
    public function getSalidasHoy()
    {
        $sql = "SELECT r.id, r.fecha_ingreso, r.fecha_salida, u.nombre as nombre_cliente, h.estilo as nombre_habitacion
                FROM reservas r
                INNER JOIN usuarios u ON r.id_usuario = u.id
                INNER JOIN habitaciones h ON r.id_habitacion = h.id
                WHERE DATE(r.fecha_salida) = CURDATE() AND r.estado = 2
                ORDER BY r.fecha_salida ASC";
        return $this->selectAll($sql);
    }

    // Contar habitaciones disponibles
    public function contarHabitacionesDisponibles()
    {
        $sql = "SELECT COUNT(id) AS total FROM habitaciones WHERE estado = 1 AND id NOT IN (
                    SELECT id_habitacion FROM reservas WHERE estado = 2
                )";
        return $this->select($sql);
    }

    // Función auxiliar para mapear el estado de string a entero
    private function mapEstadoToInt($estadoStr)
    {
        $map = [
            'Cancelada' => 0,
            'Confirmada' => 1,
            'Activa' => 2,
            'Completada' => 3
        ];
        return $map[$estadoStr] ?? 1; // Por defecto, 'Confirmada'
    }
}
?>