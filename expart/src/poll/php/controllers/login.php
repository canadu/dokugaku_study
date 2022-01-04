<?php

namespace controller\login;

use lib\Auth;
use lib\Msg;
use model\UserModel;

function get(): void
{

    // \view\login\index();
}

function post(): void
{
    //$id = isset($_POST['id']) ? $_POST['id'] : '';
    //↑をnull合体演算子で書き換えると↓になる
    //$id = $_POST['id'] ?? '';
    $id = get_param('id', '');
    $pwd = get_param('pwd', '');

    if (Auth::login($id, $pwd)) {
        $user = unserialize(UserModel::getSession());
        Msg::push(Msg::INFO, "{$user->nickname}さん、ようこそ。");
        redirect(GO_HOME);
    } else {
        redirect(GO_REFERER);
    }
}
