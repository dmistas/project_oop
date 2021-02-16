<?php
require_once "../init.php";
$user = new User();
if (!$user->hasPermissions('admin')) {
    Redirect::to('../index.php');
    exit();
}

$all_users = Database::getInstance()->get('users', ['id', '>', '0'])->results();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Users</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
</head>

<body>
<?php include 'nav.php' ?>
<div class="container">
    <div class="col-md-12">
        <?php if (Session::exists("danger")): ?>
            <div class="alert alert-danger">
                <?= Session::flash('danger') ?>
            </div>
        <?php endif; ?>
        <?php if (Session::exists("success")): ?>
            <div class="alert alert-success">
                <?= Session::flash('success') ?>
            </div>
        <?php endif; ?>
        <h1>Пользователи</h1>

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Действия</th>
            </tr>
            </thead>

            <tbody>
            <?php
            foreach ($all_users as $single_user):
                $temp_user = new User($single_user->id);
                ?>
                <tr>
                <td><?= $single_user->id ?? ""; ?></td>
                <td><?= $single_user->username ?? ""; ?></td>
                <td><?= $single_user->email ?? ""; ?></td>
                <td>
                <?php if ($temp_user->hasPermissions('admin')): ?>
                <a href="edit_role.php?id=<?=$single_user->id ?? "";?>&set=1" class="btn btn-danger">Разжаловать</a>
                <?php else: ?>
                <a href="edit_role.php?id=<?=$single_user->id ?? "";?>&set=2" class="btn btn-success">Назначить администратором</a>
                <?php endif; ?>
                <a href="../user_profile.php?id=<?=$single_user->id ?? "";?>" class="btn btn-info">Посмотреть</a>
                <a href="edit.php?id=<?=$single_user->id ?? "";?>" class="btn btn-warning">Редактировать</a>
                <a href="delete_user.php?id=<?=$single_user->id ?? "";?>" class="btn btn-danger" onclick="return confirm('Вы уверены?');">Удалить</a>
                </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
