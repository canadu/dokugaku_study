<?php

require_once 'config.php';

//library
require_once SOURCE_BASE . 'libs/helper.php';
require_once SOURCE_BASE . 'libs/auth.php';

//model
require_once SOURCE_BASE . 'models/user.model.php';

//db
require_once SOURCE_BASE . 'db/dataSource.php';
require_once SOURCE_BASE . 'db/user.query.php';

require_once SOURCE_BASE . 'partials/header.php';

//オブジェクトをセッションに格納した場合にはsession_startの前に雛形のクラス(user.model.php)を読みこ無必要がある。
session_start();

$rPath = str_replace(BASE_CONTEXT_PATH, '', $_SERVER['REQUEST_URI']);
$method = strtolower($_SERVER['REQUEST_METHOD']);
route($rPath, $method);

function route($rPath, $method)
{
    if ($rPath == '') {
        $rPath = 'home';
    }
    $targetFile = SOURCE_BASE . "controllers/{$rPath}.php";

    if (!file_exists($targetFile)) {
        require_once SOURCE_BASE . "/views/404.php";
        return;
    }
    require_once $targetFile;
    $fn = "\\controller\\{$rPath}\\{$method}";
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
