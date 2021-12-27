<?php

namespace controller\login;

use lib\Auth;
use lib\Msg;

function get(): void
{
    require_once SOURCE_BASE . 'views/login.php';
}

function post(): void
{
    //$id = isset($_POST['id']) ? $_POST['id'] : '';
    //↑をnull合体演算子で書き換えると↓になる
    //$id = $_POST['id'] ?? '';
    $id = get_param('id', '');
    $pwd = get_param('pwd', '');

    if (Auth::login($id, $pwd)) {
        Msg::push(Msg::INFO, '認証成功');
        redirect(GO_HOME);
    } else {
        Msg::push(Msg::ERROR, '認証失敗');
        redirect(GO_REFERER);
    }
}
