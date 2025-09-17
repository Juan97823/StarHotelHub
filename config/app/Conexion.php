<?php
class Conexion {
    private $conect;

    public function __construct() {
        $dsn = "mysql:host=" . HOST . ";dbname=" . DATABASE . ";charset=utf8mb4";
        try {
            $this->conect = new PDO($dsn, USER, PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false, //  seguridad contra inyecciones
            ]);
        } catch (PDOException $e) {
            // ⚠️ No mostrar detalles en producción
            error_log("Error de conexión: " . $e->getMessage());
            die("Error en la conexión a la base de datos.");
        }
    }

    public function conectar() {
        return $this->conect;
    }

    // Consulta que devuelve solo un registro
    public function select($sql, $params = []) {
        $stmt = $this->conect->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    // Consulta que devuelve todos los registros
    public function selectAll($sql, $params = []) {
        $stmt = $this->conect->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Para INSERT, UPDATE, DELETE
    public function execute($sql, $params = []) {
        $stmt = $this->conect->prepare($sql);
        return $stmt->execute($params);
    }

    // Último ID insertado
    public function lastInsertId() {
        return $this->conect->lastInsertId();
    }
}
