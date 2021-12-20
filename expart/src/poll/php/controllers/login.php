<?php

namespace controller\login;

use lib\Auth;

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
        echo '認証成功';
    } else {
        echo '認証失敗';
    }
}
