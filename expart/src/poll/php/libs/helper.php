<?php

/**
* ユーザーに紐づいたトピックの件数を取得
* @param string $key
* @param mixed $default_val
* @param bool $is_post
* @return mixed
*/
function get_param($key, $default_val, $is_post = true): mixed
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
    } elseif ($path === GO_REFERER) {
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

/**
 * 正規表現(英数字チェック)
 * @param string $val
 * @return int | bool
 */
function is_alnum($val): int | bool
{
    return preg_match("/^[a-zA-Z0-9]+$/", $val);
}

/**
 * BASE_CONTEXT_PATHを付けたURLを返却する
 * @param string $path
 */
function the_url($path): void
{
    echo get_url($path);
}

/**
 * エスケープ処理を行う
 * 再帰的処理
 * @param mixed $data
 * @return mixed
 */
function escape($data): mixed
{
    if (is_array($data)) {
        //配列の場合
        foreach ($data as $prop => $val) {
            $data[$prop] = escape($val);
        }
        return $data;
    } elseif (is_object($data)) {
        //オブジェクトの場合
        foreach ($data as $prop => $val) {
            $data->$prop = escape($val);
        }
        return $data;
    } else {
        //文字列の場合
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}
