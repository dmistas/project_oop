<?php
require_once 'init.php';

$user = new User();

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();

        $validation = $validate->check($_POST, [
            'username' => [
                'required' => true,
                'min' => 2,
                'max' => 15,
            ],
        ]);

        if ($validation) {
            $update = $user->update(['username' => Input::get('username')]);
            if ($update) {
                Session::flash('success', 'Data was updated');
                Redirect::to('update.php');
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
    <div class="flash">
        <?= Session::flash('success') ?>
    </div>
    <div class="field">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?= $user->getData()->username ?>">
    </div>

    <div class="field">
        <input type="hidden" name="token" value="<?= Token::generate(); ?>">
    </div>

    <div class="field">
        <button type="submit">Update</button>
    </div>
</form>