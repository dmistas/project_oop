<?php
require_once 'init.php';

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();

        $validation = $validate->check($_POST, [
            'username' => [
                'required' => true,
                'min' => 2,
                'max' => 15,
            ],
            'email' => [
                'required' => true,
                'email' => true,
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
            $pass = password_hash(Input::get('password'), PASSWORD_DEFAULT);
            $user = new User();
            $user->createUser([
                'email' => Input::get('email'),
                'username' => Input::get('username'),
                'password' => $pass,
            ]);
            Session::flash('success', 'Register success');
            Redirect::to('test.php');
            exit();
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
        <?= Session::flash('success') ?>
    </div>
    <div class="field">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?= Input::get('username'); ?>">
    </div>
    <div class="field">
        <label for="username">email</label>
        <input type="email" id="email" name="email" value="<?= Input::get('email'); ?>">
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
