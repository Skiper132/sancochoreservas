<?php
// Path: app/repositories/PlatoRepository.php

require_once __DIR__ . '/../../config/db/DatabaseInterface.php';
require_once __DIR__ . '/../models/Plato.php';

class PlatoRepository {
    private $conn;
    private $tableName = "platos";

    public function __construct(DatabaseInterface $database) {
        $this->conn = $database->getConnection();
    }

    public function getPlatosByRestauranteId($idRestaurante) {
        $query = "SELECT * FROM " . $this->tableName . " WHERE id_restaurante = ?";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $idRestaurante);
        $stmt->execute();
    
        $platos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $platos[] = new Plato(
                $row['id_plato'],
                $row['nombre'],
                $row['descripcion'],
                $row['precio'],
                $row['imagen']
            );
        }
    
        return $platos;
    }
}
?>