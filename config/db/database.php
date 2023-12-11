<?php
include_once 'DatabaseInterface.php';
class Database implements DatabaseInterface {
    private $host = 'localhost';
    private $dbname = 'sancochoreservas';
    private $username = 'root';
    private $password = '';
    public $connection;
    private static $instance = null;

    public function prepare($statement) {
        return $this->connection->prepare($statement);
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new self();
            self::$instance->getConnection();
        }
        return self::$instance;
    }

    // Método para obtener la conexión a la base de datos
    public function getConnection(): DatabaseInterface {
        $this->connection = null;

        try {
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            die(json_encode(array("status" => "error", "message" => "La conexión a la base de datos falló")));
        }

        return $this; // Devuelve la instancia de Database, que implementa DatabaseInterface
    }
}
?>
