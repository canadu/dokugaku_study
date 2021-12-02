<?php

require_once('db.php');

session_start();
header("Content-type: text/html; charset-utf8");

if ($_POST['token'] != $_SESSION['token'] ) {
    echo '不正アクセスの疑いあり';
    exit();
}

//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');
//エラーメッセージの初期化
$errors = array();
if(empty($_POST)) {
    header("Location: registration_mail_form.php");
	exit();
}
//入力情報を受け取る
$mail = $_SESSION['mail'];
$account = $_SESSION['account'];
$password_hash = password_hash($_SESSION['password'], PASSWORD_DEFAULT);

try {

    //データベース接続
    $dbh = db_connect();
    
    //トランザクション開始
    $dbh->beginTransaction();

    //例外処理を投げる
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //memberテーブルに登録する
    $statement = $dbh->prepare("INSERT INTO member(account, email, password) VALUES (:account,:mail,:password_hash)");

    //プレースホルダ―へ実際の値を設定する
    $statement->bindValue(':account', $account, PDO::PARAM_STR);
    $statement->bindValue(':mail',$mail, PDO::PARAM_STR);
    $statement->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
    $statement->execute();

    //pre_memberのflagを1にする
    $statement = $dbh->prepare("UPDATE pre_member SET flag=1 WHERE mail=(:mail)");
    $statement->bindValue(':mail', $mail, PDO::PARAM_STR);
    $statement->execute();

    //トランザクションを完了（コミット）
    $dbh->commit();
	
    // セッション変数を全て解除
    $_SESSION = array();

    //セッションクッキーの削除
    if (isset($_COOKIE['PHPSESSID'])) {
        setcookie('PHPSESSID', '', time() - 1800, '/');
    }

    //セッションを破棄する
    session_destroy();
    
}catch (PDOException $e){
	//トランザクション取り消し（ロールバック）
	$dbh->rollBack();
	$errors['error'] = "もう一度やりなおして下さい。";
	print('Error:'.$e->getMessage());
} finally {
    //データベース接続切断
    $dbh = null;   
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
<?php if (count($errors) === 0): ?>
    <h1>会員登録完了画面</h1>
    <p>登録完了いたしました。ログイン画面からどうぞ。</p>
    <p><a href="">ログイン画面（未リンク）</a></p>
<?php elseif(count($errors) > 0): ?>
<?php
    foreach($errors as $value){
        echo "<p>".$value."</p>";
    }
?>
<?php endif; ?>
</body>
</html>

