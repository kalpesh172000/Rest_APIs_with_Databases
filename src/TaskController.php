<?php
//keep the class name and file name same to ensure autoloading
class TaskController
{
    public function proccessRequest(string $method, ?string $id): void
    {
        if ($id === null) {
            if ($method == "GET") {
                echo "index\n";
            } else if ($method == "POST") {
                echo "create\n";
            } else {
                $this->responseMethodNotAllowed('GET, POST');
            }
        } else {
            if ($method == "GET") {
                echo "show $id\n";
            } else if ($method == "PATCH") {
                echo "update $id\n";
            } else if ($method == "DELETE") {
                echo "delete $id\n";
            } else {
                $this->responseMethodNotAllowed('GET, PATCH, DELETE');
            }
        }
        return;
    }

    private function responseMethodNotAllowed($allowedMethods): void
    {
        http_response_code(405);
        header("Allow: $allowedMethods");
    }
}
