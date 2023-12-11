<?php
// Path: app/controllers/PlatosController.php
require_once __DIR__ . '/../repositories/PlatoRepository.php';

class PlatosController {
    private $platoRepository;

    public function __construct(PlatoRepository $platoRepository) {
        $this->platoRepository = $platoRepository;
    }

    public function processRequest($requestMethod, $data) {
        if ($requestMethod === 'GET') {
            $id = $data['id_restaurante'] ?? null;
            $id ? $this->getPlatosByRestauranteId($id) : $this->unprocessableEntityResponse("Método no reconocido.");
        } else {
            $this->unprocessableEntityResponse("Método no reconocido.");
        }
    }

    private function getPlatosByRestauranteId($id) {
        $platos = $this->platoRepository->getPlatosByRestauranteId($id);
        $this->okResponse($platos);
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
?>