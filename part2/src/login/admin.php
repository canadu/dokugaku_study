<?php

use phpDocumentor\Reflection\PseudoTypes\HtmlEscapedString;

session_start();
header("Content-type: text/html; charset-utf8");

//ログイン状態のチェック
if (!isset($_SESSION['account'])) {
    header('Location: login.php');
    exit();
}
$account = $_SESSION['account'];
echo '<p>' . htmlspecialchars($account, ENT_QUOTES) . 'さんこんにちわ</p>';
echo "<a href='logout.php'>ログアウトする</a>";