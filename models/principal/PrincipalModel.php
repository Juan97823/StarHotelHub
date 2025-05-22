<?php
class PrincipalModel extends Query {

    public function __construct(){
        parent::__construct();
        
}
//RECUPERAR LOS SLIDERS
    public function getSliders(){
       return $this->selectAll("SELECT * FROM sliders");
    }
    //RECUPERAR LAS HABITACIONES
    public function gethabitaciones(){
       return $this->selectAll("SELECT * FROM habitaciones");
    }
}

?>