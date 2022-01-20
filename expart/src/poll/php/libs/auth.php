<?php

namespace lib;

use db\TopicQuery;
use db\UserQuery;
use model\UserModel;
use Throwable;

/**
 * ユーザー関連の処理を行うクラス
 */
class Auth
{
    /**
     * ログイン処理
     * @param string $id
     * @param string $pwd
     * @return bool
     */
    public static function login(string $id, string $pwd): bool
    {
        try {
            //ID、パスワードの入力チェック
            if (!(UserModel::validateId($id) * UserModel::validatePwd($pwd))) {
                return false;
            }

            $isSuccess = false;
            //ユーザーデータを取得
            $user = UserQuery::fetchById($id);
            if (!empty($user) && $user->del_flg !== 1) {
                //パスワードのチェック
                if (password_verify($pwd, $user->pwd)) {
                    $isSuccess = true;
                    //セッション変数にオブジェクトを格納する
                    UserModel::setSession(serialize($user));
                } else {
                    Msg::push(Msg::ERROR, 'パスワードが一致しません。');
                }
            } else {
                //ユーザーが存在しない場合、もしくは削除済みの場合
                Msg::push(Msg::ERROR, 'ユーザーが見つかりません。');
            }
        } catch (throwable $e) {
            $isSuccess = false;
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, 'ログインの処理でエラーが発生しました。少し時間をおいてから再度お試しください。');
        }
        return $isSuccess;
    }

    /**
     * ユーザーの登録
     * @param UserModel $user
     * @return bool
     */
    public static function register(UserModel $user): bool
    {
        $isSuccess = false;
        try {
            //入力チェック
            if (!($user->isValidId() * $user->isValidPwd() * $user->isValidNickname())) {
                return false;
            }
            $existUser = UserQuery::fetchById($user->id);
            if (!empty($existUser)) {
                Msg::push(Msg::ERROR, 'ユーザーが既に存在します。');
                return false;
            }
            //ユーザーの登録
            $isSuccess = UserQuery::insert($user);
            if ($isSuccess) {
                //セッションを登録
                UserModel::setSession(serialize($user));
            }
        } catch (throwable $e) {
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, 'ユーザー登録でエラーが発生しました。');
        }
        return $isSuccess;
    }

    /**
     * ログインチェック
     * @return bool
     */
    public static function isLogin(): bool
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
     * @return bool
     */
    public static function logout(): bool
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

    /**
     * ログインしていない場合リダイレクトする
     */
    public static function requireLogin(): void
    {
        if (!static::isLogin()) {
            Msg::push(Msg::ERROR, 'ログインしてください');
            redirect('login');
        }
    }

    /**
     * 編集権限を持っているかどうかチェックする
     * @param int $topic_id
     * @param UserModel $user
     * @return bool
     */
    public static function hasPermission($topic_id, $user): bool
    {
        return TopicQuery::isUserOwnTopic($topic_id, $user);
    }

    /**
     * 編集権限を持っているかどうかチェックを行い、持っていない場合はリダイレクトを行う
     * @param int $topic_id
     * @param UserModel $user
     */
    public static function requirePermission($topic_id, $user): void
    {
        if (!static::hasPermission($topic_id, $user)) {
            Msg::push(Msg::ERROR, '編集権限がありません。ログインして再度試してみてください。');
            redirect('login');
        }
    }
}
