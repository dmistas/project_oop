<?php


class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }
/**
 * Добавляет пользователя в базу данный 'users'
 * $fields = ['username'=>'name', 'password'=>'pass_hash']
 *
 * @param array $fields
 *
 * @return boolean
 */
    public function createUser($fields=[])
    {
        return $this->db->insert('users', $fields);
    }
}