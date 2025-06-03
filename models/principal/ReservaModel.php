<?php
class ReservaModel extends Query{

    public function __construct(){
        parent::__construct();
    }
    public function getDisponible($f_llegada, $f_salida, $habitacion){
        return $this->selectAll("SELECT * FROM reservas 
        WHERE fecha_ingreso <= '$f_salida'
        AND fecha_salida >= '$f_llegada' AND id_habitacion = $habitacion");
    }

    public function getReservasHabitacion($habitacion){
        return $this->selectAll("SELECT * FROM reservas 
        WHERE id_habitacion = $habitacion");
    }
    
    //RECUPERAR LAS HABITACIONES
    public function getHabitaciones(){
        return $this->selectAll("SELECT * FROM habitaciones WHERE estado = 1");
    }
    //RECUPERAR LAS HABITACION
    public function getHabitacion($id_habitacion){
        return $this->select("SELECT * FROM habitaciones WHERE id = $id_habitacion");
    }
}
?>