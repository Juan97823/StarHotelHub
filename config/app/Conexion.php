<?php
class Conexion
{
    private $conect;
    private static $instance = null;

    public function __construct()
    {
        $dsn = "mysql:host=" . HOST . ";dbname=" . DATABASE . ";charset=utf8mb4";
        try {
            $this->conect = new PDO($dsn, USER, PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false, // Seguridad contra inyecciones
                PDO::ATTR_PERSISTENT => false, // No usar conexiones persistentes
            ]);
        } catch (PDOException $e) {
            error_log("Error de conexión a BD: " . $e->getMessage());
            die("Error en la conexión a la base de datos. Por favor, intente más tarde.");
        }
    }

    /**
     * Obtener instancia singleton de la conexión
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function conectar()
    {
        return $this->conect;
    }

    /**
     * Verificar si la conexión está activa
     */
    public function isConnected()
    {
        return $this->conect !== null;
    }

    /**
     * Cerrar conexión
     */
    public function close()
    {
        $this->conect = null;
    }
}
