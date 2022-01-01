<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheets/css/app.css">
    <title>みんなのアンケート</title>
    <link rel="stylesheet" href="<?php echo BASE_CSS_PATH ?>style.css">
</head>

<body>
    <?php

    use lib\auth;
    use lib\Msg;

    Msg::flush();
    if (Auth::isLogin()) {
        //echo 'ログインしています';
    } else {
        //echo 'ログインしていません。';
    }
