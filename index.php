<?php
require_once 'init.php';

echo "<div>".Session::flash('success')."</div>";

$user = new User();

if ($user->isLoggedIn()) {
    echo "Hi! {$user->getData()->username}<br>";
    echo "<a href='logout.php'>Logout</a><br>";
    echo "<a href='changepassword.php'>Change password</a><br>";
    echo "<a href='update.php'>Update profile</a><br>";
    if ($user->hasPermissions('moderator')){
        echo "You are moderator!";
    }
} else {
    echo "<a href='login.php'>Login</a> or  <a href='register.php'>Register</a>";
}