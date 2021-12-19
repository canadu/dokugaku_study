<?php

namespace controller\login;

use lib\Auth;

function get()
{
    require_once SOURCE_BASE . 'views/login.php';
}

function post()
{
    //$id = isset($_POST['id']) ? $_POST['id'] : '';
    //$id = $_POST['id'] ?? '';
    $id = get_param('id', '');
    // $pwd = isset($_POST['pwd']) ? $_POST['pwd']: '';
    // $pwd = $_POST['pwd'] ?? '';
    $pwd = get_param('pwd', '');
    if (Auth::login($id, $pwd)) {
        echo '認証成功';
    } else {
        echo '認証失敗';
    }
}
