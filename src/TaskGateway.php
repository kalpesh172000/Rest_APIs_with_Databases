<?php

class TaskGateway
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT * from task ORDER BY name";
        
        $stmt = $this->conn->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get(string $id) : array | false 
    {
        $sql = "SELECT * FROM task WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): string 
    {
        // http post http://localhost/restDB/api/tasks name="kalpesh" priority:=7 is_complete:=false
        // priority and is_complete doesn't need to be specified.
        $sql = "INSERT into task (name, priority, is_complete) VALUES (:name, :priority, :is_complete)";
        $stmt = $this->conn->prepare(query: $sql);
        $stmt->bindValue(':name',$data["name"],PDO::PARAM_STR);
        if(empty($data["priority"])){
            $stmt->bindValue(':priority',null,PDO::PARAM_INT);
        }
        else
        {
            $stmt->bindValue(':priority',$data["priority"],PDO::PARAM_INT);
        }
        $stmt->bindValue(':is_complete',$data["is_complete"] ?? false ,PDO::PARAM_BOOL);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }
}
