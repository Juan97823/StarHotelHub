<?php
class SlidersModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    // Método para obtener todos los sliders activos
    public function getSliders()
    {
        $sql = "SELECT * FROM sliders WHERE estado = 1";
        return $this->selectAll($sql);
    }
}
?>