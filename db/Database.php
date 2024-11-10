<?php

class Database{

    private $host = "localhost";
    private $user = "root";
    private $pass = "root";
    private $dbname = "user_registration";
    private $charset = "utf8mb4";
    private $pdo = null;

    public function __construct(){
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getConnection(){
        return $this->pdo;
    }
}