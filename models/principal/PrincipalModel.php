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
        return $this->selectAll("SELECT * FROM habitaciones WHERE estado = 1");
    }
    
    //RECUPERAR LAS ENTRADAS RECIENTES DEL BLOG
    public function getEntradasRecientes()
    {
        return $this->selectAll("SELECT e.*, u.nombre AS autor FROM entradas e INNER JOIN usuarios u ON e.id_usuario = u.id WHERE e.estado = 1 ORDER BY e.fecha DESC LIMIT 3");
    }
}
