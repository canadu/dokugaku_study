<?php

namespace model;

use Error;

//抽象クラス
abstract class AbstractModel
{
    protected static $SESSION_NAME = null;

    /**
     *セッション情報を設定する 
     */
    public static function setSession($val)
    {
        if (empty(static::$SESSION_NAME)) {
            throw new Error('$SESSION_NAMEを設定してください。');
        }
        $_SESSION[static::$SESSION_NAME] = $val;
    }

    /**
     *セッション情報を取得する 
     */
    public static function getSession()
    {
        return $_SESSION[static::$SESSION_NAME] ?? null;
    }

    /**
     *セッション情報をクリアする 
     */
    public static function clearSession()
    {
        static::setSession(null);
    }

    /**
     * 
     */
    public static function getSessionAndFlush()
    {
        try {
            return static::getSession();
        } finally {
            static::clearSession();
        }
    }
}
