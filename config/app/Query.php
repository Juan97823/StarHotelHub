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
        try {
            $result = $this->pdo->prepare($sql);
            $result->execute($params);
            return $result->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log("Error en SELECT: " . $e->getMessage());
            return null;
        }
    }

    // RECUPERAR TODOS LOS REGISTROS
    public function selectAll($sql, $params = [])
    {
        try {
            $result = $this->pdo->prepare($sql);
            $result->execute($params);
            return $result->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            error_log("Error en SELECT ALL: " . $e->getMessage());
            return [];
        }
    }

    // REGISTRAR
    public function insert($sql, $array)
    {
        try {
            $result = $this->pdo->prepare($sql);
            $result->execute($array);

            // Obtener el último ID insertado
            $id = $this->pdo->lastInsertId();

            // Si no devuelve nada (0 o vacío), devolvemos 1 para indicar que el insert fue exitoso
            return (!$id || $id === "0") ? 1 : $id;
        } catch (PDOException $e) {
            error_log("Error en INSERT: " . $e->getMessage());
            return 0;
        }
    }

    // MODIFICAR REGISTRO
    public function save($sql, $array)
    {
        try {
            $result = $this->pdo->prepare($sql);
            return $result->execute($array) ? 1 : 0;
        } catch (PDOException $e) {
            error_log("Error en UPDATE/DELETE: " . $e->getMessage());
            return 0;
        }
    }

    // ELIMINAR REGISTRO
    public function delete($sql, $array = [])
    {
        try {
            $result = $this->pdo->prepare($sql);
            return $result->execute($array) ? 1 : 0;
        } catch (PDOException $e) {
            error_log("Error en DELETE: " . $e->getMessage());
            return 0;
        }
    }

    // CONTAR REGISTROS
    public function count($sql, $array = [])
    {
        try {
            $result = $this->pdo->prepare($sql);
            $result->execute($array);
            $data = $result->fetch(PDO::FETCH_ASSOC);
            return $data['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Error en COUNT: " . $e->getMessage());
            return 0;
        }
    }
}