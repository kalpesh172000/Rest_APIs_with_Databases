<?php
//keep the class name and file name same to ensure autoloading
class TaskController
{
    public function __construct(private TaskGateway $task_gateway) {}
    public function proccessRequest(string $method, ?string $id): void
    {
        if ($id === null) {
            if ($method == "GET") {
                echo json_encode($this->task_gateway->getAll());
            } else if ($method == "POST") {
                echo "create\n";
            } else {
                $this->responseMethodNotAllowed('GET, POST');
            }
        } else {
            $task = $this->task_gateway->get($id);
            if ($task === false) {
                $this->responseNotFound($id);
                return;
            }    

            if ($method == "GET") {
                echo json_encode($this->task_gateway->get($id));
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

    private function responseNotFound(string $id): void
    {
        http_response_code(404);
        echo json_encode(["error" => "Task $id not found"]);
    }
}
