<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$parts = explode('/', $path);

$resourse = $parts[3];

$id = $parts[4] ?? null;


// echo $resourse . " " . $id . "\n";

// echo $_SERVER['REQUEST_METHOD'] . "\n";


if ($resourse != "task") {
    http_response_code(404);
    exit;
}
else{
    echo "Hello World\n";
}
