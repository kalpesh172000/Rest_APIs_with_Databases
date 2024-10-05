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
                // http post http://localhost/restDB/api/tasks name=kalpesh priority:=7 is_complete:=false
                $data = (array) json_decode(file_get_contents('php://input'), true);
                $errors = $this->getValidationError($data);
                if(! empty($errors))
                {
                    $this->respondUnprocessableEntity($errors);
                    return;
                }
                $this->respondCreated($this->task_gateway->create($data));
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
                $data = (array) json_decode(file_get_contents('php://input'), true);
                $errors = $this->getValidationError($data);
                if(! empty($errors))
                {
                    $this->respondUnprocessableEntity($errors);
                    return;
                }
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

    private function respondCreated(string $id): void
    {
        http_response_code(201);
        echo json_encode(["message" => 'task created', "id" => $id]);
    }

    private function getValidationError(array $data): array
    {
        $errors = [];

        if (empty($data["name"])) {
            $errors[] = "name is required";
        }

        if (! empty($data["priority"])) {
            if(!filter_var($data["priority"],FILTER_VALIDATE_INT)){
                $errors[] = "priority must be interger";
            }
        }
        return $errors; 
    }

    private function respondUnprocessableEntity(array $errors): void
    {
        http_response_code(422);
        echo json_encode(["errors" => $errors]);
    }
}
