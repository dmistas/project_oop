<?php
require_once 'init.php';
if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();

        $validation = $validate->check($_POST, [
            'email' => [
                'required' => true,
                'email' => true,
            ],
            'password' => [
                'required' => true,
            ],
        ]);

        if ($validation) {
            $user = new User();
            $remember = (Input::get('remember')) === 'on';
            $login = $user->login(Input::get('email'), Input::get('password'), $remember);
            if ($login) {
                echo "You have been logged in";
            } else {
                echo "Wrong pair login password";
            }

        } else {
            foreach ($validate->getErrors() as $error) {
                echo $error . "<br>";
            }
        }
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="field">
        <label for="email">Email</label>
        <input type="text" id="email" name="email" value="<?= Input::get('email'); ?>">
    </div>

    <div class="field">
        <label for="">Password</label>
        <input type="text" name="password" value="">
    </div>

    <div class="field">
        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Remember me</label>
    </div>

    <div class="field">
        <input type="hidden" name="token" value="<?= Token::generate(); ?>">
    </div>

    <div class="field">
        <button type="submit">Submit</button>
    </div>
</form>
