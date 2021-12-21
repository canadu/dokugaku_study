<?php

namespace model;

use Error;

//抽象クラス
abstract class AbstractModel
{
    protected static $SESSION_NAME = null;

    public static function setSession($val)
    {
        if (empty(static::$SESSION_NAME)) {
            throw new Error('$SESSION_NAMEを設定してください。');
        }
        $_SESSION[static::$SESSION_NAME] = $val;
    }
}
