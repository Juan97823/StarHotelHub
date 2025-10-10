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
    public function select($sql, $params = [])
    {
        $result = $this->pdo->prepare($sql);
        $result->execute($params);
        return $result->fetch(PDO::FETCH_ASSOC);

    }

    // RECUPERAR TODOS LOS REGISTROS
    public function selectAll($sql, $params = [])
    {
        $result = $this->pdo->prepare($sql);
        $result->execute($params);
        return $result->fetchAll(PDO::FETCH_ASSOC);

    }
    // REGISTRAR
    public function insert($sql, $array)
    {
        try {
            $result = $this->pdo->prepare($sql);
            $result->execute($array);

            // Intentamos obtener el último ID insertado
            $id = $this->pdo->lastInsertId();

            // Si no devuelve nada (0 o vacío), devolvemos 1 para indicar que el insert fue exitoso
            if (!$id || $id === "0") {
                return 1;
            }

            return $id;
        } catch (PDOException $e) {
            error_log("Error en INSERT: " . $e->getMessage());
            return 0;
        }
    }

    // MODIFICAR REGISTRO
    public function save($sql, $array)
    {
        $result = $this->pdo->prepare($sql);
        $data = $result->execute($array);
        return $data ? 1 : 0;
    }
}