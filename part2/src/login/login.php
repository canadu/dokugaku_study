<?php

session_start();
header("Content-type: text/html; charset-utf8");

//クロスサイトリクエストフォージェリ(CSRF)対策
$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
$token = $_SESSION['token'];

//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');
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
    <form action="loginCheck.php" method="POST">
        <p>account: <input type="text" name="account" size="50"></p>
        <p>password: <input type="text" name="password" size="50"></p>
        <input type="hidden" name="token" value="<? echo $token; ?>">
        <input type="submit" value="ログインする">
    </form>
</body>
</html>