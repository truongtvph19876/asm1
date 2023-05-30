<?php

require_once "models/env.php";

class DB
{
    private $conn;

    public function __construct()
    {
        $this->conn = $this->connect();
    }

    private function connect() {
        try {
            $dsn = "mysql:host=".DBHOST.";dbname=".DBNAME.";charset=".DBCHARSET;
            $options = [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ];
            return new PDO($dsn, DBUSER, DBPASS, $options);
        }catch(\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getData($query, $getAll = true)
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        if ($getAll) {
            return $stmt->fetchAll();
        }

        return $stmt->fetch();
    }
}