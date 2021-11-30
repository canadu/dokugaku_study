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
    <h1>登録</h1>
    <form action="registration_mail_check.php" method="post">
        <p>メールアドレス：<input type="text" name="mail" size="50"></p>
        <input type="hidden" name="token" value="<?=$token?>">
        <input type="submit" value="登録する">
    </form>
</body>
</html>
