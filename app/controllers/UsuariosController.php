<?php
// app/controllers/UsuariosController.php

require_once __DIR__ . '/../repositories/UsuarioRepository.php';

class UsuariosController {
    private $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository) {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function processRequest($requestMethod, $data) {
        switch ($requestMethod) {
            case 'POST':
                $action = $data['action'] ?? null;

                if ($action === 'register') {
                    $this->registrarUsuario($data);
                } elseif ($action === 'login') {
                    $this->iniciarSesion($data);
                } else {
                    $this->unprocessableEntityResponse("Acción no reconocida.");
                }
                break;
            default:
                $this->unprocessableEntityResponse("Método no reconocido.");
                break;
        }
    }

    private function registrarUsuario($data) {
        $nombre = $data['nombre'] ?? null;
        $email = $data['email'] ?? null;
        $contrasena = $data['contrasena'] ?? null;

        //Verifica si el email ya existe
        if ($this->usuarioRepository->emailExists($email)) {
            $this->unprocessableEntityResponse("El email ya existe.");
            return;
        }

        //Verifica si los datos están completos
        if ($nombre && $email && $contrasena) {
            $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
            $usuario = new Usuario(null, $nombre, $email, $contrasenaHash);

            if ($this->usuarioRepository->registrar($usuario)) {
                $this->okResponse("Usuario registrado exitosamente.");
            } else {
                $this->internalServerErrorResponse("No se pudo registrar el usuario.");
            }
        } else {
            $this->unprocessableEntityResponse("Datos incompletos.");
        }
    }

    private function iniciarSesion($data) {
        $email = $data['email'] ?? null;
        $contrasena = $data['contrasena'] ?? null;

        // Verifica si los datos están completos
        if ($email && $contrasena) {
            if (!$this->usuarioRepository->emailExists($email)) {
                $this->unprocessableEntityResponse("El email no está registrado.");
                return;
            }
            // Verifica si las credenciales son válidas
            $usuario = $this->usuarioRepository->verificarCredenciales($email, $contrasena);

            // Si las credenciales son válidas, inicia sesión
            if ($usuario) {
                // Establecer la sesión
                session_start();
                $_SESSION['id_usuario'] = $usuario->getIdUsuario();
                $_SESSION['nombre_usuario'] = $usuario->getNombre();
                $this->okResponse("Inicio de sesión exitoso.");
            } else {
                $this->unprocessableEntityResponse("Credenciales inválidas.");
            }
        } else {
            $this->unprocessableEntityResponse("Datos incompletos.");
        }
    }

// Métodos de respuesta
    private function response($status, $data) {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode(['status' => $status, 'data' => $data]);
    }

    private function okResponse($data) {
        $this->response(200, $data);
    }

    private function unprocessableEntityResponse($message) {
        $this->response(422, ['message' => $message]);
    }

    private function notFoundResponse($message) {
        $this->response(404, ['message' => $message]);
    }

    private function internalServerErrorResponse($message) {
        $this->response(500, ['message' => $message]);
    }
}
?>