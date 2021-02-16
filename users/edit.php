<?php
require_once '../init.php';
$user = new User();
if (!$user->hasPermissions('admin')) {
    Redirect::to('../index.php');
    exit();
}
$id = intval(Input::get('id'))??null;
$edit_user = new User($id);
if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();

        $validation = $validate->check($_POST, [
            'username' => [
                'required' => true,
                'min' => 2,
                'max' => 15,
            ],
            'status' => [
                'required' => true,
                'min' => 2,
            ]
        ]);

        if ($validation) {
            $update = $edit_user->update(['username' => Input::get('username'), 'status' => Input::get('status')], $id);
            if ($update) {
                Session::flash('success', 'Профиль обновлен');
                Redirect::to("edit.php?id=".$id);
                exit();
            }
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
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<?php include 'nav.php' ?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>Профиль пользователя - <?= $edit_user->getData()->username ?></h1>
            <?php if (Session::exists('success')): ?>
                <div class="alert alert-success"><?= Session::flash('success') ?></div>
            <?php endif; ?>
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

            <form action="" method="post" enctype="multipart/form-data" class="form">
                <div class="form-group">
                    <label for="username">Имя</label>
                    <input type="text" id="username" name="username" class="form-control"
                           value="<?= $edit_user->getData()->username ?>">
                </div>
                <div class="form-group">
                    <label for="status">Статус</label>
                    <input type="text" id="status" name="status" class="form-control"
                           value="<?= $edit_user->getData()->status ?>">
                </div>
                <div class="field">
                    <input type="hidden" name="token" value="<?= Token::generate(); ?>">
                </div>

                <div class="form-group">
                    <button class="btn btn-warning">Обновить</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>