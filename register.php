<?php
require_once 'init.php';
if (Input::exists()) {
    if (Token::check(Input::get('token'))) {

        if (!Input::get('checkbox')){
            Session::flash('danger', 'Необходимо принять правила сайта');
        }

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

        if ($validation && Input::get('checkbox')) {
            $pass = password_hash(Input::get('password'), PASSWORD_DEFAULT);
            $user = new User();
            $user->createUser([
                'email' => Input::get('email'),
                'username' => Input::get('username'),
                'password' => $pass,
                'date' => date('Y-m-d'),
            ]);
            Session::flash('success', 'Регистрация успешна');
            Redirect::to('login.php');
            exit();
        } elseif (!$validation) {
            $errors = $validate->getErrors();
        }
    }
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="text-center">
<form class="form-signin" method="post" enctype="multipart/form-data" action="">
    <img class="mb-4" src="images/apple-touch-icon.png" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>

    <?php
    if (isset($errors)):
        ?>
        <div class="alert alert-danger">
            <ul>
                <?php
                foreach ($errors as $error):
                    ?>
                    <li><?= $error ?></li>
                <?php
                endforeach;
                ?>
            </ul>
        </div>
    <?php
    endif;
    ?>
    <?php if (Session::exists('success')): ?>
        <div class="alert alert-success"><?= Session::flash('success') ?></div>
    <?php endif; ?>

    <?php if (Session::exists('danger')): ?>
        <div class="alert alert-danger"><?= Session::flash('danger') ?></div>
    <?php endif; ?>

    <div class="form-group">
        <input type="email" class="form-control" id="email" name="email" placeholder="Email"
               value="<?= Input::get('email') ?>">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="username" name="username" placeholder="Ваше имя"
               value="<?= Input::get('username') ?>">
    </div>
    <div class="form-group">
        <input type="password" class="form-control" id="password" name="password" placeholder="Пароль">
    </div>

    <div class="form-group">
        <input type="password" class="form-control" id="password_again" name="password_again"
               placeholder="Повторите пароль">
    </div>

    <div class="field">
        <input type="hidden" name="token" value="<?= Token::generate(); ?>">
    </div>

    <div class="checkbox mb-3">
        <label>
            <input type="checkbox" name="checkbox"> Согласен со всеми правилами
        </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Зарегистрироваться</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2017-2021</p>
</form>
</body>
</html>