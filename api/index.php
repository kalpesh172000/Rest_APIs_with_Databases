<?php

declare(strict_types=1);


require __DIR__ . '/../vendor/autoload.php';
// require dirname(__DIR__) . '/vendor/autoload.php'; //both aproches are mostly same 

set_exception_handler('ErrorHandler::handleException');

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$parts = explode('/', $path);

$resourse = $parts[3];

$id = $parts[4] ?? null;

if ($resourse != "tasks") {
    echo "Error 404 not found\n";
    http_response_code(404);
    exit;
}

header('Content-Type: application/json; charset=UTF-8');

$controller = new TaskController;

$controller->proccessRequest($_SERVER['REQUEST_METHOD'], $id);