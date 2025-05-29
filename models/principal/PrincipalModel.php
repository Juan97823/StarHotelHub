<?php
class PrincipalModel extends Query{

    public function __construct(){
        parent::__construct();
    }
    //RECUPERAR LOS SLIDERS
    public function getSliders(){
        return $this->selectAll("SELECT * FROM sliders");
    }
    //RECUPERAR LAS HABITACIONES
    public function getHabitaciones(){
        return $this->selectAll("SELECT * FROM habitaciones");
    }

    public function getDisponible($f_llegada, $f_salida, $habitacion){
        return $this->selectAll("SELECT * FROM reservas 
        WHERE fecha_ingreso <= '$f_salida'
        AND fecha_salida >= '$f_llegada'
        AND id_habitacion = $habitacion");
    }

}
