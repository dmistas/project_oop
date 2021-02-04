<?php

class Database
{
    private $pdo, $query, $error = false, $results, $count;
    private static $instance;

    private function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=project", "root", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (PDOException $exception) {
            echo "Невозможно установить соединение с БД" . $exception->getMessage();
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function query($sql)
    {
        $this->error = false;
        $this->query = $this->pdo->prepare($sql);
        if (!$this->query->execute()) {
            $this->error = true;
        } else {
            $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
            $this->count = $this->query->rowCount();
        }
        return $this;
    }

    public function error()
    {
        return $this->error;
    }

    public function results()
    {
        return $this->results;
    }

    public function count()
    {
        return $this->count;
    }

}
