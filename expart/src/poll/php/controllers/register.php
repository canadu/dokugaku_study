<?php

namespace controller\register;

use lib\Auth;
use model\UserModel;

function get(): void
{
    require_once SOURCE_BASE . 'views/register.php';
}

function post(): void
{
    $user = new UserModel();
    $user->id = get_param('id', '');
    $user->pwd = get_param('pwd', '');
    $user->nickname = get_param('nickname', '');

    //$id = isset($_POST['id']) ? $_POST['id'] : '';
    //↑をnull合体演算子で書き換えると↓になる
    //$id = $_POST['id'] ?? '';
    if (Auth::regist($user)) {
        echo '登録成功';
    } else {
        echo '登録失敗';
    }
}
