<?php
class Conexion {
    private $conect;

    public function __construct() {
        $pdo = "mysql:host=" . HOST . ";dbname=" . DATABASE . ";" . CHARSET;
        try {
            $this->conect = new PDO($pdo, USER, PASS);
            $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error en la conexion:" . $e->getMessage();
        }
    }

    public function conectar() {
        return $this->conect;
    }

    public function select($sql, $params = []) {
        $stmt = $this->conect->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function selectAll($sql, $params = []) {
        $stmt = $this->conect->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
