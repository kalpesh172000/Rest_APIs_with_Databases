<?php
//api_db_user with pw test@123
declare(strict_types=1);


require __DIR__ . '/../vendor/autoload.php';
// require dirname(__DIR__) . '/vendor/autoload.php'; //both aproches are mostly same 

set_error_handler('ErrorHandler::handleError');
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

//for following 2 lines to work and to create $_ENV superglobal variable create .env file in root folder add variables to that file
//in that file add variables like 
// DB_HOST=localhost 
// DB_NAME=todo
// DB_USER=student_db
// DB_PASS=pass123
$env = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$env->load();

$database = new Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);

//$database->getConnection();
$task_gateway = new TaskGateway($database);

$controller = new TaskController($task_gateway);

$controller->proccessRequest($_SERVER['REQUEST_METHOD'], $id);