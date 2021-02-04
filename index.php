<?php
include "Database.php";

$users = Database::getInstance();

$users->query("SELECT * FROM users");

if ($users->error()){
    echo "we have error";
    die();
}
foreach ($users->results() as $user){
    echo "<pre>";
    print_r($user);
    echo "<pre>";

}
echo $users->count();
