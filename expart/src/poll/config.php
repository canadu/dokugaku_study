<?php

// define('BASE_CONTEXT_PATH', $_SERVER['REQUEST_URI']);
define('BASE_CONTEXT_PATH', '/poll/');
define('CURRENT_URI', $_SERVER['REQUEST_URI']);

//画像までのパス
define('BASE_IMAGE_PATH', BASE_CONTEXT_PATH . 'images/');
define('BASE_JS_PATH', 'js/');
define('BASE_CSS_PATH', 'css/');
define('SOURCE_BASE', __DIR__ . '/php/');


define('GO_HOME', 'home');
define('GO_REFERER', 'referer');

//デバッグフラグ。開発の場合はtrueに設定し、falseの場合は本番環境とする
define('DEBUG', false);
