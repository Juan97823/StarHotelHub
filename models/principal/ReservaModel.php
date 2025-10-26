<?php
class ReservaModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }


    // Obtener reservas disponibles para una habitación específica entre fechas
    public function getDisponible($f_llegada, $f_salida, $habitacion)
    {
        $id_habitacion = intval($habitacion);
        $query = "SELECT * FROM reservas 
                WHERE fecha_ingreso < :f_salida
                AND fecha_salida > :f_llegada 
                AND id_habitacion = :habitacion";
        $params = [
            ':f_llegada' => $f_llegada,
            ':f_salida' => $f_salida,
            ':habitacion' => $id_habitacion
        ];
        return $this->selectAll($query, $params);
    }

    // Obtener todas las reservas de una habitación
    public function getReservasHabitacion($habitacion)
    {
        $id_habitacion = intval($habitacion);
        $query = "SELECT * FROM reservas 
                WHERE id_habitacion = :habitacion";
        $params = [':habitacion' => $id_habitacion];
        return $this->selectAll($query, $params);
    }

    // Recuperar todas las habitaciones disponibles
    public function getHabitaciones()
    {
        return $this->selectAll("SELECT * FROM habitaciones WHERE estado = 1");
    }

    // Recuperar información de una habitación específica
    public function getHabitacion($id_habitacion)
    {
        $query = "SELECT * FROM habitaciones WHERE id = :id_habitacion";
        $params = [':id_habitacion' => intval($id_habitacion)];
        return $this->select($query, $params);
    }

    // Recuperar información de una habitación específica por su slug
    public function getHabitacionBySlug($slug)
    {
        $query = "SELECT * FROM habitaciones WHERE slug = :slug";
        $params = [':slug' => $slug];
        return $this->select($query, $params);
    }
    public function getReservaById($id)
    {
        return $this->select("SELECT * FROM reservas WHERE id = :id", [':id' => $id]);
    }

    public function getUsuarioById($id)
    {
        return $this->select("SELECT * FROM usuarios WHERE id = :id", [':id' => $id]);
    }

    public function getFacturaByReserva($idReserva)
    {
        return $this->select("SELECT * FROM facturas WHERE reserva_id = :id", [':id' => $idReserva]);
    }


    // Obtener todas las reservas de un cliente
    public function getReservasCliente($id_usuario)
    {
        $query = "SELECT r.*, h.estilo AS tipo, h.foto, r.monto AS monto_total
                FROM reservas r
                JOIN habitaciones h ON r.id_habitacion = h.id
                WHERE r.id_usuario = :id_usuario";
        $params = [':id_usuario' => $id_usuario];
        return $this->selectAll($query, $params);
    }

    // Obtener detalle completo de una reserva
    public function getDetalleReserva($id_reserva)
    {
        $query = "SELECT r.*,
                         h.estilo AS tipo,
                         h.numero AS numero_habitacion,
                         h.categoria,
                         h.precio AS precio_noche,
                         u.nombre AS nombre_cliente,
                         u.correo AS email,
                         u.telefono
                FROM reservas r
                JOIN habitaciones h ON r.id_habitacion = h.id
                JOIN usuarios u ON r.id_usuario = u.id
                WHERE r.id = :id_reserva";
        $params = [':id_reserva' => intval($id_reserva)];
        return $this->select($query, $params);
    }

    // Contar el total de reservas de un cliente
    public function getCantidadReservas($id_usuario)
    {
        $query = "SELECT COUNT(*) AS total FROM reservas WHERE id_usuario = :id_usuario";
        $params = [':id_usuario' => $id_usuario];
        return $this->select($query, $params);
    }

    // Contar las reservas de un cliente por estado
    public function getCantidadReservasByEstado($id_usuario, $estado)
    {
        $query = "SELECT COUNT(*) AS total FROM reservas WHERE id_usuario = :id_usuario AND estado = :estado";
        $params = [':id_usuario' => $id_usuario, ':estado' => $estado];
        return $this->select($query, $params);
    }
    // Verifica si existe un usuario por su correo
    public function getUsuarioBycorreo($correo)
    {
        $query = "SELECT * FROM usuarios WHERE correo = :correo";
        $params = [':correo' => $correo];
        return $this->select($query, $params);
    }
    // Crea un usuario nuevo automáticamente
    public function crearUsuario($nombre, $correo, $clave, $telefono)
    {
        $sql = "INSERT INTO usuarios (nombre, correo, clave, telefono, rol) VALUES (?, ?, ?, ?, ?)";
        // Suponiendo que rol 3 = cliente
        $params = [$nombre, $correo, $clave, $telefono, 3];
        return $this->insert($sql, $params);
    }


    // Inserta la reserva asociada al usuario
    public function insertReservaPublica($data)
    {
        $sql = "INSERT INTO reservas (
                id_habitacion,
                id_usuario,
                fecha_ingreso,
                fecha_salida,
                descripcion,
                metodo,
                estado,
                monto
            ) VALUES (
                :id_habitacion,
                :id_usuario,
                :fecha_ingreso,
                :fecha_salida,
                :descripcion,
                :metodo,
                :estado,
                :monto
            )";

        return $this->insert($sql, $data);
    }


    // Genera la factura de la reserva
    public function crearFactura($idReserva)
    {
        // Obtener datos de la reserva y habitación
        $reserva = $this->select("SELECT r.*, h.precio, h.estilo 
                        FROM reservas r 
                        JOIN habitaciones h ON r.id_habitacion = h.id
                        WHERE r.id = :id", [':id' => $idReserva]);

        if (!$reserva)
            return false;

        // Calcular número de noches
        $fechaEntrada = new DateTime($reserva['fecha_ingreso']);
        $fechaSalida = new DateTime($reserva['fecha_salida']);
        $noches = $fechaEntrada->diff($fechaSalida)->days;

        $subtotal = $noches * $reserva['precio'];
        $impuestos = $subtotal * 0.19; // IVA 19%
        $total = $subtotal + $impuestos;

        $numeroFactura = "FAC-" . date("Ymd") . "-" . rand(1000, 9999);

        $sql = "INSERT INTO facturas (numero_factura, reserva_id, subtotal, impuestos, total, estado)
            VALUES (:numero, :reserva_id, :subtotal, :impuestos, :total, 'Pendiente')";
        $params = [
            ':numero' => $numeroFactura,
            ':reserva_id' => $idReserva,
            ':subtotal' => $subtotal,
            ':impuestos' => $impuestos,
            ':total' => $total
        ];
        return $this->insert($sql, $params);
    }
    // Obtener pago por reserva
    public function getPagoByReserva($id_reserva)
    {
        $sql = "SELECT * FROM pagos WHERE id_reserva = ?";
        return $this->select($sql, [$id_reserva]);
    }

    // Crear un registro de pago pendiente
    public function crearPagoPendiente($id_reserva)
    {
        $sql = "INSERT INTO pagos (id_reserva, metodo, facturacion, estado) VALUES (?, 'pendiente', 'Pago sin factura', 1)";
        return $this->insert($sql, [$id_reserva]);
    }

    // Actualizar pago tras confirmación


    public function registrarPago($data)
    {
        $sql = "INSERT INTO pagos (
                id_reserva,
                id_usuario,
                id_habitacion,
                monto,
                num_transaccion,
                cod_reserva,
                fecha_ingreso,
                fecha_salida,
                descripcion,
                metodo,
                facturacion,
                id_empleado,
                estado
            ) VALUES (
                :id_reserva,
                :id_usuario,
                :id_habitacion,
                :monto,
                :num_transaccion,
                :cod_reserva,
                :fecha_ingreso,
                :fecha_salida,
                :descripcion,
                :metodo,
                :facturacion,
                :id_empleado,
                :estado
            )";

        return $this->insert($sql, $data);
    }


    public function actualizarPago($id_reserva, $id_transaccion)
    {
        // 1. Actualizar el estado de la reserva a 'Completada' (estado = 2)
        $sqlReserva = "UPDATE reservas SET estado = ?, id_transaccion = ? WHERE id = ?";
        $paramsReserva = [2, $id_transaccion, $id_reserva];
        $reservaUpdated = $this->save($sqlReserva, $paramsReserva);

        // 2. Actualizar el estado de la factura a 'Pagada'
        $sqlFactura = "UPDATE facturas SET estado = ? WHERE reserva_id = ?";
        $paramsFactura = ['Pagada', $id_reserva];
        $facturaUpdated = $this->save($sqlFactura, $paramsFactura);

        // Devuelve true solo si ambas actualizaciones fueron exitosas
        return $reservaUpdated && $facturaUpdated;
    }

    public function cancelarReserva($idReserva)
    {
        $sql = "UPDATE reservas SET estado = ? WHERE id = ?";
        $params = [3, $idReserva]; // 3 = cancelado
        return $this->save($sql, $params);
    }

}
?>