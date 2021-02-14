<?php
require_once 'init.php';


$user = new User();
$anotherUser = new User(1);

if ($user->isLoggedIn()){
    echo "Hi! {$user->getData()->username}";
    echo "<a href='logout.php'>Logout</a>";
} else {
    echo "<a href='login.php'>Login</a> or  <a href='register.php'>Register</a>";
}