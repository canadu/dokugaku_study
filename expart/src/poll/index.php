<?php

//オブジェクトをセッションに格納した場合にはsession_startの前に雛形のクラス(user.model.php)を読みこ無必要がある。
session_start();

require_once 'config.php';

//library
require_once SOURCE_BASE . 'libs/helper.php';
require_once SOURCE_BASE . 'libs/auth.php';

//model
require_once SOURCE_BASE . 'models/abstract.model.php';
require_once SOURCE_BASE . 'models/user.model.php';

//Message
require_once SOURCE_BASE . 'libs/message.php';

//db
require_once SOURCE_BASE . 'db/dataSource.php';
require_once SOURCE_BASE . 'db/user.query.php';

require_once SOURCE_BASE . 'partials/header.php';

$rPath = str_replace(BASE_CONTEXT_PATH, '', $_SERVER['REQUEST_URI']);
$method = strtolower($_SERVER['REQUEST_METHOD']);
route($rPath, $method);

/**
 * 呼び出されたURIに応じてコントローラーのファイルを呼び出し、存在しない場合は
 * 404.phpを呼び出す
 * @rPath パス
 * @methods メソッド
 */
function route(string $rPath, string $methods): void
{
    if ($rPath == '') {
        $rPath = 'home';
    }
    $targetFile = SOURCE_BASE . "controllers/{$rPath}.php";
    if (!file_exists($targetFile)) {
        //ファイルが存在しない場合404ファイルを読み込み
        require_once SOURCE_BASE . "/views/404.php";
        return;
    }
    require_once $targetFile;
    $fn = "\\controller\\{$rPath}\\{$methods}";
    $fn();
}

//URLが増えてくるので管理が面倒になる
// if ($_SERVER['REQUEST_URI'] === '/poll/login') {
//     require_once SOURCE_BASE . 'controllers/login.php';
// } elseif ($_SERVER['REQUEST_URI'] === '/poll/register') {
//     require_once SOURCE_BASE . 'controllers/register.php';
// } elseif ($_SERVER['REQUEST_URI'] === '/poll/') {
//     require_once SOURCE_BASE . 'controllers/home.php';
// }

require_once SOURCE_BASE . 'partials/footer.php';
