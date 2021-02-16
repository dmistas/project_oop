<?php
require_once "../init.php";
$user = new User();

if (!($user->isLoggedIn() && $user->hasPermissions('admin') && Input::exists('get'))) {
    Redirect::to('index.php');
}

$id =  Input::get('id')??0;
if ($id){
    $delete = Database::getInstance()->delete('users', ['id', '=', $id]);
    if ($delete){
        Session::flash('success', 'Пользователь удален');
    } else {
        Session::flash('danger', 'Ошибка при удалении');
    }
    Redirect::to('index.php');
}