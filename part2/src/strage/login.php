<?php

require_once(__DIR__ . 'functions.php');

$token = escape(getCSRFToken());

$loginId = '';
$pass = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $loginId = escape($_POST['loginId']);
    $pass = escape($_POST['pass']);

    function validateCSRFToken($post_token) 
    {
        return isset($_COOKIE['XSRF-TOKEN']) && $_COOKIE['XSRF-TOKEN'] === $post_token;
    }

    if(isset($POST['csrf_token']) && validateCSRFToken($_POST['csrf_token'])) {
        //OKだったら空文字でスルー
        echo '';
    } else {
        echo 'トークンが不正です。';
        exit();
    }
    header('Access-Control-Allow-Origin:path');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('X-Frame-Options: SAMEORIGIN');

    //IDとパスワード設定
    if($loginId === 'a' && $pass === 'a') {
        session_start();
        $_SESSION['login'] = 1;
        //ファイル一覧へリロード
        header('Location: file_list.php');
        exit();
    } elseif ($loginId === '' || $pass === '') {
        $errMsg = '';
    } else {
        $errMsg = '';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <main id="topMain">
        <form action="" method="post" class="clearfix">
            <!-- トークンを追加 -->
            <input type="hidden" name="csrf_token" value="<?php echo $token;?>">
            <label for="loginId">ログインID</label>
            <input type="text" name="loginId">
            <label for="pass">パスワード</label>
            <input type="password" name="pass">
            <p = "logBtn"><input type="submit" value="ログイン"></p>
        </form>
    </main>
</body>
</html>
