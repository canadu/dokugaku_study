<?php

namespace lib;

use db\UserQuery;
use model\UserModel;
use Throwable;

class Auth
{
    public static function login($id, $pwd)
    {
        try {
            $is_success = false;
            $user = UserQuery::fetchById($id);

            if (!empty($user) && $user->del_flg !== 1) {

                if (password_verify($pwd, $user->pwd)) {
                    $is_success = true;
                    //セッション変数にオブジェクトを格納する
                    UserModel::setSession(serialize($user));
                } else {
                    echo 'パスワードが一致しません。';
                }
            } else {
                echo 'ユーザーが見つかりません。';
            }
        } catch (throwable $e) {
            $is_success = false;
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, 'ログインの処理でエラーが発生しました。少し時間をおいてから再度お試しください。');
        }
        return $is_success;
    }

    public static function regist($user)
    {
        try {
            //入力チェック
            if (!$user->isValidId()) {
                return false;
            }
            $is_success = false;
            $exist_user = UserQuery::fetchById($user->id);
            if (!empty($exist_user)) {
                echo 'ユーザーが既に存在します。';
                return false;
            }
            $is_success = UserQuery::insert($user);
            if ($is_success) {
                UserModel::setSession(serialize($user));
            }
        } catch (throwable $e) {
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, 'ユーザー登録でエラーが発生しました。');
        }
        return $is_success;
    }

    public static function isLogin()
    {
        try {
            $user = unserialize(UserModel::getSession());
        } catch (throwable $e) {
            //エラーが起きた場合ユーザーをログアウトさせる
            UserModel::clearSession();
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, 'エラーが発生しました。再度ログインを行ってください。');
            return false;
        }
        if (isset($user)) {
            return true;
        } else {
            return false;
        }
    }
}
