<?php
include "classes/Database.php";
include "classes/Config.php";

$GLOBALS['config'] = [
    'mysql'=>[
        'host'=>'localhost',
        'username'=>'root',
        'password'=>'',
        'database'=>'project',
    ]

];

$users = Database::getInstance();
$users->query('SELECT * FROM users');
var_dump($users);