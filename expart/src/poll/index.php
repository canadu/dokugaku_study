<?php

//オブジェクトをセッションに格納した場合にはsession_startの前に雛形のクラス(user.model.php)を読みこむ必要がある。
session_start();

require_once 'config.php';

//library
require_once SOURCE_BASE . 'libs/helper.php';
require_once SOURCE_BASE . 'libs/auth.php';
require_once SOURCE_BASE . 'libs/router.php';

//model
require_once SOURCE_BASE . 'models/abstract.model.php';
require_once SOURCE_BASE . 'models/user.model.php';
require_once SOURCE_BASE . 'models/topic.model.php';
require_once SOURCE_BASE . 'models/comment.model.php';

//Message
require_once SOURCE_BASE . 'libs/message.php';

//db
require_once SOURCE_BASE . 'db/dataSource.php';
require_once SOURCE_BASE . 'db/user.query.php';
require_once SOURCE_BASE . 'db/topic.query.php';
require_once SOURCE_BASE . 'db/comment.query.php';

//partials
require_once SOURCE_BASE . 'partials/header.php';
require_once SOURCE_BASE . 'partials/footer.php';
require_once SOURCE_BASE . 'partials/topic-list-item.php';
require_once SOURCE_BASE . 'partials/topic-header-items.php';

//view
require_once SOURCE_BASE . 'views/home.php';
require_once SOURCE_BASE . 'views/login.php';
require_once SOURCE_BASE . 'views/register.php';
require_once SOURCE_BASE . 'views/topic/archive.php';
require_once SOURCE_BASE . 'views/topic/detail.php';
require_once SOURCE_BASE . 'views/topic/edit.php';

use function lib\route;

try {
    // headerを関数としてcall
    \partials\header();
    $url = parse_url(CURRENT_URI);
    $rPath = str_replace(BASE_CONTEXT_PATH, '', $url['path']);
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    //対応したcontrollersのファイルを呼び出す
    route($rPath, $method);
    \partials\footer();
} catch (throwable $e) {
    die('<h1>なにか凄くおかしいようです。</h1>');
}

/**
 * 呼び出されたURIに応じてコントローラーのファイルを呼び出し、存在しない場合は
 * 404.phpを呼び出す
 * @rPath パス
 * @methods メソッド
 */

//URLが増えてくるので管理が面倒になる
// if ($_SERVER['REQUEST_URI'] === '/poll/login') {
//     require_once SOURCE_BASE . 'controllers/login.php';
// } elseif ($_SERVER['REQUEST_URI'] === '/poll/register') {
//     require_once SOURCE_BASE . 'controllers/register.php';
// } elseif ($_SERVER['REQUEST_URI'] === '/poll/') {
//     require_once SOURCE_BASE . 'controllers/home.php';
// }
