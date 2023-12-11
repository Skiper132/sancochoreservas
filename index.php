<?php
// index.php

// Inicializa la configuración de errores de PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Requiere las clases necesarias
require_once 'config/db/Database.php';
require_once 'app/controllers/UsuariosController.php';
require_once 'app/repositories/UsuarioRepository.php';
require_once 'app/controllers/RestaurantesController.php';
require_once 'app/repositories/RestauranteRepository.php';

// Obtiene la instancia de la base de datos
$database = Database::getInstance();

// Función para parsear la URL y extraer la ID
function parseUrlForId($url) {
    $urlParts = explode('/', $url);
    return end($urlParts); // Devuelve el último elemento del array
}

// Analiza la URL para saber qué acción tomar
$url = $_GET['url'] ?? ''; // Esto vendría del archivo .htaccess que reescribe las URL
$urlParts = explode('/', $url);

// Verifica si la URL sigue el formato esperado "restaurante/{id}"
if ($urlParts[0] === 'restaurante' && isset($urlParts[1])) {
    // Obtiene la ID del restaurante
    $restauranteId = $urlParts[1];
    // Crea una instancia del controlador de restaurantes
    $restauranteRepository = new RestauranteRepository($database);
    $restaurantesController = new RestaurantesController($restauranteRepository);
    // Llama al método del controlador para cargar la página de detalles del restaurante
    $restaurantesController->showRestauranteDetails($restauranteId);
} else {
    // Maneja las solicitudes a la API como antes
    $data = json_decode(file_get_contents('php://input'), true);
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $route = $data['route'] ?? null;

    // Tabla de enrutamiento
    $routes = [
        'usuario' => [
            'controller' => 'UsuariosController',
            'repository' => 'UsuarioRepository',
        ],
        'restaurante' => [
            'controller' => 'RestaurantesController',
            'repository' => 'RestauranteRepository',
        ],
    ];

    // Enrutador básico
    if (isset($routes[$route])) {
        $controllerName = $routes[$route]['controller'];
        $repositoryName = $routes[$route]['repository'];
        
        $repository = new $repositoryName($database);
        $controller = new $controllerName($repository);

        $controller->processRequest($requestMethod, $data);
    } else {
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['error' => 'Route not found']);
        exit;
    }
}
?>