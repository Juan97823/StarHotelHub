<?php
class ReservaModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }

    // ... (todos los métodos existentes de getDisponible a crearFactura) ...

    // Obtener reservas disponibles para una habitación específica entre fechas
    public function getDisponible($f_llegada, $f_salida, $habitacion)
    {
        $query = "SELECT * FROM reservas 
                WHERE fecha_ingreso <= :f_salida
                AND fecha_salida >= :f_llegada 
                AND id_habitacion = :habitacion";
        $params = [
            ':f_llegada' => $f_llegada,
            ':f_salida' => $f_salida,
            ':habitacion' => $habitacion
        ];
        return $this->selectAll($query, $params);
    }

    // Obtener todas las reservas de una habitación
    public function getReservasHabitacion($habitacion)
    {
        $query = "SELECT * FROM reservas 
                WHERE id_habitacion = :habitacion";
        $params = [':habitacion' => $habitacion];
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
        $params = [':id_habitacion' => $id_habitacion];
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
        $query = "SELECT r.*, h.estilo AS tipo, r.monto AS monto_total
                FROM reservas r
                JOIN habitaciones h ON r.id_habitacion = h.id
                WHERE r.id_usuario = :id_usuario";
        $params = [':id_usuario' => $id_usuario];
        return $this->selectAll($query, $params);
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
    public function crearUsuario($nombre, $correo, $clave)
    {
        $sql = "INSERT INTO usuarios (nombre, correo, clave, rol) VALUES (?, ?, ?, ?)";
        // Suponiendo que rol 1 = cliente
        $params = [$nombre, $correo, $clave, 3];
        return $this->insert($sql, $params);
    }


    // Inserta la reserva asociada al usuario
    public function insertReservaPublica($data)
    {
        $sql = "INSERT INTO reservas 
        (id_habitacion, id_usuario, fecha_ingreso, fecha_salida, descripcion, estado, metodo)
        VALUES 
        (:id_habitacion, :id_usuario, :fecha_ingreso, :fecha_salida, :descripcion, :estado, :metodo)";

        $params = [
            ':id_habitacion' => $data['habitacion_id'],
            ':id_usuario' => $data['usuario_id'],
            ':fecha_ingreso' => $data['fecha_ingreso'],
            ':fecha_salida' => $data['fecha_salida'],
            ':descripcion' => $data['descripcion'] ?? '',
            ':estado' => $data['estado'],
            ':metodo' => $data['metodo'] ?? 1
        ];

        return $this->insert($sql, $params);
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
    public function registrarPago($data)
    {
        $sql = "INSERT INTO pagos (
                monto, num_transaccion, cod_reserva, fecha_ingreso, fecha_salida,
                descripcion, estado, metodo, facturacion, id_habitacion, id_usuario, id_empleado
            ) VALUES (
                :monto, :num_transaccion, :cod_reserva, :fecha_ingreso, :fecha_salida,
                :descripcion, :estado, :metodo, :facturacion, :id_habitacion, :id_usuario, :id_empleado
            )";

        $params = [
            ':monto' => $data['monto'],
            ':num_transaccion' => $data['num_transaccion'],
            ':cod_reserva' => $data['cod_reserva'],
            ':fecha_ingreso' => $data['fecha_ingreso'],
            ':fecha_salida' => $data['fecha_salida'],
            ':descripcion' => $data['descripcion'],
            ':estado' => $data['estado'] ?? 1, // por defecto activo
            ':metodo' => $data['metodo'],
            ':facturacion' => $data['facturacion'],
            ':id_habitacion' => $data['id_habitacion'],
            ':id_usuario' => $data['id_usuario'],
            ':id_empleado' => $data['id_empleado'] ?? null
        ];

        return $this->insert($sql, $params);
    }


    /**
     * NUEVO MÉTODO: Actualiza el estado de la reserva y la factura después de un pago exitoso.
     */
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

}
?>