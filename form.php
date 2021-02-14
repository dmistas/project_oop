<?php
include "classes\Database.php";
include "classes\Config.php";
include "classes\Validate.php";
include "classes\Input.php";

$GLOBALS['config'] = [
    'mysql' => [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'projectc',
    ]

];

if (Input::exists()) {
    $validate = new Validate();

    $validation = $validate->check($_POST, [
        'username' => [
            'required' => true,
            'min' => 2,
            'max' => 15,
            'unique' => 'users'
        ],
        'password' => [
            'required' => true,
            'min' => 3,
        ],
        'password_again' => [
            'required' => true,
            'matches' => 'password',
        ],
    ]);

    if ($validation) {
        echo 'passed';
    } else {
        foreach ($validate->getErrors() as $error) {
            echo $error . "<br>";
        }
    }
}


?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?= Input::get('username');?>">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input type="text" id="password" name="password" value="">
    </div>

    <div class="field">
        <label for="">Password again</label>
        <input type="text" name="password_again" value="">
    </div>

    <div class="field">
        <button type="submit">Submit</button>
    </div>
</form>
