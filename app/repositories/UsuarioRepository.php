<?php

require_once __DIR__ . '/../../config/db/DatabaseInterface.php';
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioRepository {
    private $conn;
    private $tableName = "usuarios";

    public function __construct(DatabaseInterface $database) {
        $this->conn = $database->getConnection();
    }

    public function emailExists($email) {
        $query = "SELECT id_usuario FROM " . $this->tableName . " WHERE email = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num > 0;
    }

    public function registrar(Usuario $usuario) {
        $query = "INSERT INTO " . $this->tableName . " SET
            nombre = :nombre,
            email = :email,
            contrasena = :contrasena";

        $stmt = $this->conn->prepare($query);

        $nombre = $usuario->getNombre();
        $email = $usuario->getEmail();
        $contrasena = $usuario->getContrasena();

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contrasena', $contrasena);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function verificarCredenciales($email, $contrasena) {
        $query = "SELECT id_usuario, nombre, email, contrasena FROM " . $this->tableName . " WHERE email = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();

        $num = $stmt->rowCount();
            if ($num > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
                $idUsuario = $row['id_usuario'];
                $nombre = $row['nombre'];
                $email = $row['email'];
                $contrasenaHash = $row['contrasena'];
        
                if (password_verify($contrasena, $contrasenaHash)) {
                    return new Usuario($idUsuario, $nombre, $email, $contrasenaHash);
                }
            }
        return null;
    }
}
?>