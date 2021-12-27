<?php

namespace lib;

use model\AbstractModel;

use function PHPUnit\Framework\isNull;

class Msg extends AbstractModel {

    protected static $SESSION_NAME = '_msg';
    public const ERROR = 'error';
    public const INFO = 'info';
    public const DEBUG = 'debug';

    /**
     * セッション上にメッセージを追加するメソッド
     *
     */
    public static function push($type, $msg)
    {
        if (!is_array(Msg::getSession())) {
            Msg::init();
        }
        $msgs = Msg::getSession();
        $msgs[$type][] = $msg;
        static::setSession($msgs);
    }

    /**
     *メッセージを表示するメソッド
     */
    public static function flush()
    {
        $msg_with_type = Msg::getSessionAndFlush() ?? [];
        foreach ($msg_with_type as $type => $msgs) {
            foreach ($msgs as $msg) {
                echo "<div>{$msg}</div>";
            }
        }
    }

    /**
     *初期化
     */
    private static function init()
    {
        static::setSession([
            static::ERROR => [],
            static::INFO => [],
            static::DEBUG => []
        ]);
    }
}
