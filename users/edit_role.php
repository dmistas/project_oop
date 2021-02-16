<?php
require_once '../init.php';
$user = new User();
if (!($user->isLoggedIn() && $user->hasPermissions('admin') && Input::exists('get'))) {
    Redirect::to('index.php');
}


if (Input::get('id')){
    switch (Input::get('set')){
        case '1':
            $user->update(['group_id'=>1], intval(Input::get('id')));
            Session::flash('success', 'Пользователь разжалован');
            break;
        case '2':
            $user->update(['group_id'=>2], intval(Input::get('id')));
            Session::flash('success', 'Пользователь стал админом');
            break;
        default:
            Session::flash('danger', 'Роль не поменялась');
    }

    Redirect::to('index.php');
}