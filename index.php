<?php
require_once 'init.php';
$user = new User();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Main</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<?php include 'templates/nav.php'; ?>

<div class="container">
    <?php if (!($user->isLoggedIn())): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="jumbotron">
                    <h1 class="display-4">Привет, мир!</h1>
                    <p class="lead">Это дипломный проект по разработке на PHP. На этой странице список наших
                        пользователей.</p>
                    <hr class="my-4">
                    <p>Чтобы стать частью нашего проекта вы можете пройти регистрацию.</p>
                    <a class="btn btn-primary btn-lg" href="register.php" role="button">Зарегистрироваться</a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12">
            <h1>Пользователи</h1>
            <table class="table">
                <thead>
                <tr>
                    <th>№</th>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Дата</th>
                </tr>
                </thead>
                <?php
                $login_user_id = isset($user->getData()->id)?$user->getData()->id:0;
                $all_users = Database::getInstance()->get('users', ['id', '>=', '0'])->results();
                $i = 0;
                foreach ($all_users as $single_user):
                    $i++;
                    ?>
                    <tbody>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $single_user->id ?></td>
                        <?php if ($user->hasPermissions('admin') || $single_user->id == $login_user_id ): ?>
                        <td class="alert alert-info"><a href="profile.php"><?= $single_user->username?></a></td>
                        <?php else: ?>
                        <td><a href="user_profile.php?id=<?=$single_user->id?>"><?= $single_user->username?></a></td>
                        <?php endif; ?>
                        <td><?= $single_user->email ?></td>
                        <td><?= $single_user->status ?></td>
                        <td><?= $single_user->date ?></td>
                    </tr>
                    </tbody>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
</body>
</html>