<?php
require_once 'init.php';


$user = new User();

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();

        $validation = $validate->check($_POST, [
            'password_current' => [
                'required' => true,
                'min' => 2,
                'max' => 15,
            ],
            'password' => [
                'required' => true,
                'min' => 2,
                'max' => 15,
            ],
            'password_confirm' => [
                'required' => true,
                'matches' => 'password',
            ],
        ]);

        if ($validation) {
            if (password_verify(Input::get('password_current'), $user->getData()->password)){
                $user->update(['password' => (password_hash(Input::get('password'), PASSWORD_DEFAULT))]);
                Session::flash('success', 'Password has been updated');

            } else {
                Session::flash('danger', 'Wrong password');
            }
            Redirect::to('changepassword.php');
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
    <div class="success">
        <?= Session::flash('success') ?>
    </div>
    <div class="danger">
        <?= Session::flash('danger') ?>
    </div>
    <div class="field">
        <label for="password_current">Current password</label>
        <input type="text" id="password_current" name="password_current">
    </div>
    <div class="field">
        <label for="password">New password</label>
        <input type="text" id="password" name="password">
    </div>
    <div class="field">
        <label for="password_confirm">Confirm password</label>
        <input type="text" id="password_confirm" name="password_confirm">
    </div>

    <div class="field">
        <input type="hidden" name="token" value="<?= Token::generate(); ?>">
    </div>

    <div class="field">
        <button type="submit">Update</button>
    </div>
</form>