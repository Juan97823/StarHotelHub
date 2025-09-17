<?php 
class Query extends Conexion
{
    private $con, $pdo;

    public function __construct()
    {
        $this->con = new Conexion();
        $this->pdo = $this->con->conectar();
    }
    // RECUPERAR UN SOLO REGISTRO
    public function select($sql,$params = [])
    {
        $result = $this ->pdo->prepare($sql);
        $result->execute($params);
        return $result->fetch(PDO::FETCH_ASSOC);
    
    }

    // RECUPERAR TODOS LOS REGISTROS
    public function selectAll($sql,$params = [])
    {
        $result = $this ->pdo->prepare($sql);
        $result->execute($params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    
    }
    // REGISTRAR
    public function insert($sql,$array)
    {
        $result = $this ->pdo->prepare($sql);
        $data = $result->execute($array);
        return $data ? $this->pdo->lastInsertId() : 0;
    }
    // MODIFICAR REGISTRO
    public function save($sql,$array)
    {
        $result = $this ->pdo->prepare($sql);
        $data = $result->execute($array);
        return $data ? 1 : 0;
    }
}