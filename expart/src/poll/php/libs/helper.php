<?php

function get_param($key, $default_val, $is_post = true)
{
    //スーパーグローバル変数はここでアクセスするようにする
    $array = $is_post ? $_POST : $_GET;
    return $array[$key] ?? $default_val;
}

/**
 * リダイレクト処理を行う
 * @param string $path リダイレクト先
 */
function redirect(string $path): void
{
    $is_Referer = false;
    if ($path === GO_HOME) {
        $path = get_url('');
    } else if ($path === GO_REFERER) {
        $is_Referer = true;
        $path = $_SERVER['HTTP_REFERER'];
    } else {
        $path = get_url($path);
    }
    if ($is_Referer) {
        //リファラーにリダイレクト
        header("Location: {$path}");
    } else {
        $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
        header("Location: {$protocol}{$_SERVER['HTTP_HOST']}{$path}");
    }
    die();
}
/**
 * urlを取得する
 * @param string $path
 * @return string
 */
function get_url(string $path): string
{
    return BASE_CONTEXT_PATH . trim($path, '/');
}

function is_alnum($val)
{
    return preg_match("/^[a-zA-Z0-9]+$/", $val);
}
