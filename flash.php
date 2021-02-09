<?php
session_start();

require_once "classes\Database.php";
require_once "classes\Config.php";
require_once "classes\Validate.php";
require_once "classes\Input.php";
require_once "classes\Token.php";
require_once "classes\Session.php";


$GLOBALS['config'] = [
    'mysql' => [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'projectc',
    ],
    'session' => [
        'token_name' => 'token',
    ],

];

if (Input::exist()) {
    if (Token::check(Input::get('token'))) {
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
//            echo 'passed';
            Session::flash('success', 'Register success');
//            header('Location: test.php');
        } else {
            foreach ($validate->getErrors() as $error) {
                echo $error . "<br>";
            }
        }
    }
}


?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="flash">
        <?= Session::flash('success')?>
    </div>
    <div class="field">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?= Input::get('username'); ?>">
    </div>

    <div class="field">
        <label for="">Password</label>
        <input type="text" name="password" value="">
    </div>

    <div class="field">
        <label for="">Password again</label>
        <input type="text" name="password_again" value="">
    </div>

    <div class="field">
        <input type="hidden" name="token" value="<?= Token::generate(); ?>">
    </div>

    <div class="field">
        <button type="submit">Submit</button>
    </div>
</form>
