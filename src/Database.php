<?php

class Database
{
    public function __construct(private string $host,private string $db,private string $user,private string $password)
    {
    }

    public function getConnection(): PDO 
    {
        //data source name
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8";

        return new PDO($dsn, $this->user, $this->password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false, //no need but being cautious
            PDO::ATTR_STRINGIFY_FETCHES => false //no need but being cautious
        ]);
    }
}
