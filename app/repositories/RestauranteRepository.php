<?php
// Path: app/repositories/RestauranteRepository.php
require_once __DIR__ . '/../../config/db/DatabaseInterface.php';
require_once __DIR__ . '/../models/Restaurante.php';

class RestauranteRepository {
    private $conn;
    private $tableName = "restaurantes";

    public function __construct(DatabaseInterface $database) {
        $this->conn = $database->getConnection();
    }

    public function getRestauranteById($id) {
        $query = "SELECT * FROM " . $this->tableName . " WHERE id_restaurante = :id";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Restaurante(
                (int) $row['id_restaurante'], $row['nombre'], $row['direccion'], 
                $row['tipo_comida'], (double) $row['rango_precios'], $row['horario_apertura'], 
                $row['horario_cierre'], $row['ubicacion'], $row['descripcion'], 
                $row['telefono'], $row['imagen']
            );
        }
        return null;
    }

    public function getRestaurantes() {
        $query = "SELECT * FROM " . $this->tableName;
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        $restaurantes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $restaurantes[] = new Restaurante(
                (int) $row['id_restaurante'], $row['nombre'], $row['direccion'], 
                $row['tipo_comida'], (double) $row['rango_precios'], $row['horario_apertura'], 
                $row['horario_cierre'], $row['ubicacion'], $row['descripcion'], 
                $row['telefono'], $row['imagen']
            );
        }
    
        return $restaurantes;
    }
}
?>