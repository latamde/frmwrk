<?php
require_once __DIR__ . '/../bootstrap.php';
require_once ROOT_PATH. "/config/Router.php";
require_once ROOT_PATH. "/config/functions.php";
require_once ROOT_PATH. "/app/controllers/FormController.php";

$router = new Router();

$router->get('/', 'FormController::index');
$router->post('/', 'FormController::save');
$router->post('/descargarCSV', 'FormController::descargarCSV');



$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER['REQUEST_METHOD'];

if (!$router->resolve($request_method, $request_uri)) {
    http_response_code(404);
    echo 'Página no encontrada';
}
