<?php

namespace lib;

use db\TopicQuery;
use db\UserQuery;
use model\UserModel;
use Throwable;

class Auth
{
    public static function login($id, $pwd)
    {
        try {

            if (
                !(UserModel::validateId($id)
                    * UserModel::validatePwd($id))
            ) {
                return false;
            }

            $is_success = false;
            $user = UserQuery::fetchById($id);

            if (!empty($user) && $user->del_flg !== 1) {

                if (password_verify($pwd, $user->pwd)) {
                    $is_success = true;
                    //セッション変数にオブジェクトを格納する
                    UserModel::setSession(serialize($user));
                } else {
                    Msg::push(Msg::ERROR, 'パスワードが一致しません。');
                }
            } else {
                Msg::push(Msg::ERROR, 'ユーザーが見つかりません。');
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
            if (
                !($user->isValidId()
                    * $user->isValidPwd()
                    * $user->isValidNickname())
            ) {
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
        if (!isset($user) || $user === false) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * ログアウト
     */
    public static function logout()
    {
        try {
            UserModel::clearSession();
        } catch (throwable $e) {
            //エラーが起きた場合ユーザーをログアウトさせる
            Msg::push(Msg::DEBUG, $e->getMessage());
            return false;
        }
        return true;
    }

    public static function requireLogin()
    {
        if (!static::isLogin()) {
            Msg::push(Msg::ERROR, 'ログインしてください');
            redirect('login');
        }
    }
    public static function hasPermission($topic_id, $user)
    {
        return TopicQuery::isUserOwnTopic($topic_id, $user);
    }
    public static function requirePermission($topic_id, $user)
    {
        if (!static::hasPermission($topic_id, $user)) {
            Msg::push(Msg::ERROR, '編集権限がありません。ログインして再度試してみてください。');
            redirect('login');
        }
    }
}
