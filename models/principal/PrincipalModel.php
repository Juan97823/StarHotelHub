<?php
class PrincipalModel extends Query {

    public function __construct(){
        parent::__construct();
        
}
    public function getSliders(){
       return $this->selectAll("SELECT * FROM sliders");
    }
}

?>