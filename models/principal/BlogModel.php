<?php
class BlogModel extends Query {

    public function __construct()
    {
        parent::__construct();
    }

    //RECUPERAR LAS ENTRADAS DEL BLOG
    public function getEntradas()
    {
        return $this->selectAll("SELECT * FROM entradas WHERE estado = 1 ORDER BY fecha DESC");
    }
}
