<?php

namespace lib;

use db\UserQuery;
// use model\UserModel;

class Auth
{
    public static function login(string $id, string $pwd)
    {
        $is_success = false;
        $user = UserQuery::fetchById($id);
        if (!empty($user) && $user->del_flg !== 1) {
            if (password_verify($pwd, $user->pwd)) {
                $is_success = true;
                //セッション変数にオブジェクトを格納する
                $_SESSION['user'] = $user;
            } else {
                echo 'パスワードが一致しません。';
            }
        } else {
            echo 'ユーザーが見つかりません。';
        }
        return $is_success;
    }

    public static function regist($user)
    {
        $is_success = false;
        $exist_user = UserQuery::fetchById($user->id);
        if (!empty($exist_user)) {
            echo 'ユーザーが既に存在します。';
            return false;
        }
        $is_success = UserQuery::insert($user);
        if ($is_success) {
            $_SESSION['user'] = $user;
        }
        return $is_success;
    }
}
