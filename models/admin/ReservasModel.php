<?php
class ReservasModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getReservas()
    {
        // Consulta SQL corregida para usar solo el campo 'nombre' de la tabla usuarios.
        $sql = "SELECT r.*, h.estilo AS habitacion, u.nombre AS cliente
                FROM reservas r
                INNER JOIN habitaciones h ON r.id_habitacion = h.id
                INNER JOIN usuarios u ON r.id_usuario = u.id";
        
        // Ejecuta la consulta y devuelve los datos.
        $data = $this->selectAll($sql);
        return $data;
    }

    public function deleteReserva($id)
    {
        $sql = "DELETE FROM reservas WHERE id = ?";
        $params = [$id];
        // Usamos el método 'save' de la clase padre (Query) para ejecutar el borrado
        $data = $this->save($sql, $params);
        return $data;
    }
}
?>