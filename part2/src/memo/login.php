<?php

session_start();
header("Content-type: text/html; charset=utf-8");
$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
$token = $_SESSION['token'];
//クリックジャッキング対策
header('X-FRAME-OPTIONS: DENY');
require_once('loginConfirm.php');

if (!empty($errors)) {
    echo "エラーあり";
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheets/css/app.css">
    <link rel="stylesheet" href="stylesheets/css/custom.css">
    <title>ログイン</title>
</head>
<body class="text-center">
    <form class="form-signIn" action="loginConfirm.php" method="POST">
        <img class="mb-4" src="img/memo.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Memo</h1>
        <div class="form-group mb-3">
            <label for="inputEmail" class="sr-only">メールアドレス</label>
            <input type="email" id="inputEmail" name="mailAddress" class="form-control" placeholder="メールアドレス" required autofocus>
        </div>
        <div class="form-group mb-1">
            <label for="inputPassword" class="sr-only">パスワード</label>
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="パスワード" required>
        </div>
        <input type="hidden" name="token" value=<?php $token ?>>
        <div class="checkbox mb-1">
            <label> 
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="btn btn-md btn-outline-primary btn-block" type="submit">ログイン</button>
        <!-- <p class="mt-5 mb-3 text-muted">&copy;2021</p> -->
    </form>
</body>
</html>
