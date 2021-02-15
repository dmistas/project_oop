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
            if (password_verify(Input::get('password_current'), $user->getData()->password)) {
                $user->update(['password' => (password_hash(Input::get('password'), PASSWORD_DEFAULT))]);
                Session::flash('success', 'Password has been updated');

            } else {
                Session::flash('danger', 'Wrong password');
            }
            Redirect::to('changepassword.php');
            exit();
        } else {
            $errors = $validate->getErrors();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<?php include 'templates/nav.php' ?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>Изменить пароль</h1>
            <?php if (Session::exists('success')): ?>
                <div class="alert alert-success"><?= Session::flash('success') ?></div>
            <?php endif; ?>
            <?php if (Session::exists('danger')): ?>
                <div class="alert alert-danger"><?= Session::flash('danger') ?></div>
            <?php endif; ?>

            <?php if (isset($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <ul>
                <li><a href="profile.php">Изменить профиль</a></li>
            </ul>

            <form action="" method="post" class="form">
                <div class="form-group">
                    <label for="password_current">Текущий пароль</label>
                    <input type="password" id="password_current" name="password_current" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Новый пароль</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password_confirm">Повторите новый пароль</label>
                    <input type="password" id="password_confirm" name="password_confirm" class="form-control">
                </div>

                <div class="field">
                    <input type="hidden" name="token" value="<?= Token::generate(); ?>">
                </div>

                <div class="form-group">
                    <button class="btn btn-warning">Изменить</button>
                </div>
            </form>

        </div>
    </div>
</div>
</body>
</html>