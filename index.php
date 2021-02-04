<?php
include "Database.php";

$users = Database::getInstance();

//$users->get('users', ['id', '=', '42']);

//if ($users->error()){
//    echo "we have error";
//    die();
//}

//foreach ($users->results() as $user){
//    echo "<pre>";
//    var_dump($user);
//    echo "<pre>";
//
//}
//echo $users->count();
//$users->delete('users', ['id', '=', 56]);

//"INSERT INTO users (`name`, `email`, `password`) VALUES (?, ?, ?)";
$filds = [
    'name' => 'John Dou',
    'email' => 'john@mail.com',
    'password' => '12345'
];

Database::getInstance()->update('users', 57, $filds);
//Database::getInstance()->insert('users', $filds);