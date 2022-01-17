<?php

namespace model;

use Error;

//抽象クラス
abstract class AbstractModel
{
    protected static mixed $SESSION_NAME = null;

    /**
    *セッション情報を設定する
    * @param mixed $val
    */
    public static function setSession($val) : void
    {
        if (empty(static::$SESSION_NAME)) {
            throw new Error('$SESSION_NAMEを設定してください。');
        }
        $_SESSION[static::$SESSION_NAME] = $val;
    }

    /**
    *セッション情報を取得する
    *@return mixed
    */
    public static function getSession() : mixed
    {
        return $_SESSION[static::$SESSION_NAME] ?? null;
    }

    /**
     *セッション情報をクリアする
     */
    public static function clearSession() : void
    {
        static::setSession(null);
    }

    /**
     * セッションからデータを取得し、セッションの情報を空にする
     * @return mixed
     */
    public static function getSessionAndFlush() : mixed
    {
        try {
            return static::getSession();
        } finally {
            static::clearSession();
        }
    }
}
