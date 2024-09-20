<?php

class TaskGateway
{
    private PDO $pdo;

    public function __construct(Database $database)
    {
        $this->pdo = $database->getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT * from task ORDER BY name";
        
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get(string $id) : array | false 
    {
        $sql = "SELECT * FROM task WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
