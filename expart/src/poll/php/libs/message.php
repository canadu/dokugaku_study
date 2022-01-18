<?php

namespace lib;

use model\AbstractModel;
use Throwable;

class Msg extends AbstractModel
{
    protected static mixed $SESSION_NAME = '_msg';
    public const ERROR = 'error';
    public const INFO = 'info';
    public const DEBUG = 'debug';

    /**
    * セッション上にメッセージを追加するメソッド
    * @param mixed $type
    * @param string $msg
    */
    public static function push($type, $msg): void
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
    public static function flush(): void
    {
        try {
            $msg_with_type = Msg::getSessionAndFlush() ?? [];

            echo '<div id="messages">';
            foreach ($msg_with_type as $type => $msgs) {
                if ($type === static::DEBUG && !DEBUG) {
                    //メッセージタイプがDebug、且つ、フラグが本番環境の場合はメッセージを表示しない
                    continue;
                }
                $color = $type === static::INFO ? 'alert-info' : 'alert-danger';
                foreach ($msgs as $msg) {
                    //echo "<div>{$type}:{$msg}</div>";
                    echo "<div class='alert $color'>{$msg}</div>";
                }
            }
            echo '</div>';
        } catch (throwable $e) {
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, 'Msg::Flushで例外が発生しました。');
        }
    }
    /**
     *初期化
     */
    private static function init(): void
    {
        static::setSession([
            static::ERROR => [],
            static::INFO => [],
            static::DEBUG => []
        ]);
    }
}
