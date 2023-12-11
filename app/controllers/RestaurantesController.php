<?php
// Path: app/controllers/RestaurantesController.php

require_once __DIR__ . '/../repositories/RestauranteRepository.php';

class RestaurantesController {
    private $restauranteRepository;

    public function __construct(RestauranteRepository $restauranteRepository) {
        $this->restauranteRepository = $restauranteRepository;
    }

    public function processRequest($requestMethod, $data) {
        // ...
        $action = $data['action'] ?? null;
        switch ($action) {
            case 'getAbiertos':
                $this->getRestaurantesAbiertos();
                break;
            case 'get':
                $id = $data['id_restaurante'] ?? null;
                $id ? $this->getRestaurante($id) : $this->unprocessableEntityResponse("No se pudo procesar la solicitud");
                break;
            case 'getAll':
                $this->getRestaurantes();
                break;
            case 'getPorTipo':
                $tipoComida = $data['tipo_comida'] ?? null;
                $tipoComida ? $this->getRestaurantesPorTipo($tipoComida) : $this->unprocessableEntityResponse("No se pudo procesar la solicitud");
                break;
            case "getPorNombre":
                $nombre = $data['nombre'] ?? null;
                $nombre ? $this->getRestaurantesPorNombre($nombre) : $this->unprocessableEntityResponse("No se pudo procesar la solicitud");
                break;
            default:
            $this->unprocessableEntityResponse("Acción no permitida: " + $action);
            }
    } 


    private function getRestaurante($id) {
        $restaurante = $this->restauranteRepository->getRestauranteById($id);
        if ($restaurante) {
            $this->okResponse($restaurante);
        } else {
            $this->notFoundResponse("Restaurante no encontrado.");
        }
    }

    private function getRestaurantes() {
        $restaurantes = $this->restauranteRepository->getRestaurantes();
        if ($restaurantes) {
            $this->okResponse($restaurantes);
        } else {
            $this->notFoundResponse("No hay restaurantes.");
        }
    }

    private function getRestaurantesAbiertos() {
        // obtener restaurantes donde estaAbierto() == true
        $restaurantes = $this->restauranteRepository->getRestaurantes();
        $restaurantesAbiertos = [];
        foreach ($restaurantes as $restaurante) {
            if ($restaurante->estaAbierto()) {
                $restaurantesAbiertos[] = $restaurante;
            }
        }
        if ($restaurantesAbiertos) {
            $this->okResponse($restaurantesAbiertos);
        } else {
            $this->notFoundResponse("En este momento no hay restaurantes abiertos.");
        }
    }

    private function getRestaurantesPorTipo($tipoComida) {
        // obtener restaurantes donde tipoComida == $tipoComida
        $restaurantes = $this->restauranteRepository->getRestaurantes();
        $restaurantesPorTipo = [];
        foreach ($restaurantes as $restaurante) {
            if ($restaurante->getTipoComida() == $tipoComida) {
                $restaurantesPorTipo[] = $restaurante;
            }
        }
        if ($restaurantesPorTipo) {
            $this->okResponse($restaurantesPorTipo);
        } else {
            $this->notFoundResponse("No hay restaurantes de este tipo.");
        }
    }

    private function getRestaurantesPorNombre($nombre) {
        // obtener restaurantes donde nombre == $nombre
        $restaurantes = $this->restauranteRepository->getRestaurantes();
        $restaurantesPorNombre = [];
        foreach ($restaurantes as $restaurante) {
            if ($restaurante->getNombre() == $nombre) {
                $restaurantesPorNombre[] = $restaurante;
            }
        }
        if ($restaurantesPorNombre) {
            $this->okResponse($restaurantesPorNombre);
        } else {
            $this->notFoundResponse("No hay restaurantes con este nombre.");
        }
    }

    public function showRestauranteDetails($id) {
        $restaurante = $this->restauranteRepository->getRestauranteById($id);
        if ($restaurante) {
            // Asigna los datos del restaurante a la vista
            // Por ejemplo, puedes incluir una plantilla PHP que muestre los detalles
            include __DIR__ . '/../view/restaurantes/restaurante_detalle.php';
        } else {
            // Maneja el caso en que el restaurante no se encuentre
            // Por ejemplo, puedes redirigir a una página de error o mostrar un mensaje
            include '/../view/restaurantes/restaurante_no_encontrado.php';
        }
    }
// Métodos de respuesta
    private function response($status, $data) {
        header('Content-Type: application/json; charset=utf-8');
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