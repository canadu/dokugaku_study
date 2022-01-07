<?php

namespace lib;

use Throwable;
//use Error;

function route(string $rPath, string $methods): void
{
    try {
        //意図的にエラーを発生させる場合
        //throw new Error();
        if ($rPath === '') {
            $rPath = 'home';
        }
        $targetFile = SOURCE_BASE . "controllers/{$rPath}.php";
        if (!file_exists($targetFile)) {
            //ファイルが存在しない場合404ファイルを読み込み
            require_once SOURCE_BASE . "/views/404.php";
            return;
        }
        require_once $targetFile;
        $rPath = str_replace('/', '\\', $rPath);
        $fn = "\\controller\\{$rPath}\\{$methods}";
        $fn();
    } catch (throwable $e) {
        Msg::push(Msg::DEBUG, $e->getMessage());
        Msg::push(Msg::DEBUG, '何かがおかしいようです..');
        require_once SOURCE_BASE . "/views/404.php";
    }
}
