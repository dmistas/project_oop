<?php

class Database
{
    private $pdo, $query, $error = false, $results, $count;
    private static $instance = null;

    private function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=project", "root", "");
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

    public function query($sql, $params = [])
    {
        $this->error = false;
        $this->query = $this->pdo->prepare($sql);

        if (count($params)) {
            $i = 1;
            foreach ($params as $param) {
                $this->query->bindValue($i, $param);
                $i++;
            }
        }

        if (!$this->query->execute()) {
            $this->error = true;
        } else {
            $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
            $this->count = $this->query->rowCount();
        }
        return $this;
    }

    private function action($action, $table, $where = [])
    {
        if (count($where) === 3) {

            $operators = ['<', '<=', '=', '>', '>='];

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if (in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field}  {$operator}  ?";
                if (!$this->query($sql, [$value])->error()) {
                    return $this;
                }
            }
        }
        return false;
    }

    public function insert($table, $fields = [])
    {
        $values = '';
        foreach ($fields as $item){
            $values .= "?,";
        }
        $sql = "INSERT INTO {$table} (`" . implode('`, `', array_keys($fields)) . "`) VALUES (". rtrim($values, ",") . ")";

        if (!$this->query($sql, $fields)){
            return true;
        }
        return false;
    }

    public function update($table, $id, $fields=[])
    {
        $sql = "UPDATE {$table} SET ". implode('=?,', array_keys($fields)). "=? WHERE id=?";
        $fields['id']=$id;

        if (!$this->query($sql, $fields)->error()){
            return true;
        }
        return false;
    }

    public function get($table, $where = [])
    {
        return $this->action('SELECT *', $table, $where);
    }

    public function delete($table, $where)
    {
        return $this->action('DELETE', $table, $where);
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

    /**
     * Возвращает первый элемент из массива results
     *
     * @return mixed
     */
    public function first()
    {
        return $this->results()[0];
    }
}
