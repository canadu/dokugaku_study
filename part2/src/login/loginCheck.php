<?php

require_once('./db.php');

session_start();
header("Content-type: text/html; charset-utf8");

//var_dump(password_hash($_POST['password'],PASSWORD_DEFAULT));
$errors = array();

//クロスサイトリクエストフォージェリ
if (isset($_POST['token'])) {
    if ($_POST['token'] != $_SESSION['token']) {
        echo "不正アクセスの可能性あり";
        exit();
    }
} else {
    echo "不正アクセスの可能性あり";
    exit();
}

//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

//前後にある半角スペースを削除する関数
function spaceTrim($str) {
    //行頭
    $str = preg_replace('/^[ ]+/u', '', $str);
    //末尾
    $str = preg_replace('/[ ]+$/u', '', $str);
    return $str;
}

//データベース接続
require_once("db.php");
$dbh = db_connect();

if(empty($_POST)) {
    header('Location:login.php');
    exit();
} else {
    //postされた変数をデータに格納する
    $account = isset($_POST['account']) ? $_POST['account'] : NULL;
    $password = isset($_POST['password']) ? $_POST['password'] : NULL;

    //前後にある半角全角スペースを削除
    $account = spaceTrim($account);
    $password = spaceTrim($password);

    //アカウント入力判定
    if ($account == '') {
        $errors['account'] = 'アカウントが入力されていません。';
    } elseif (mb_strlen($account) > 10) {
        $errors['account_length'] = 'アカウントは10文字以内で入力して下さい。';
    }

    //パスワード入力判定
    if ($password == '') {
        $errors['password'] = 'パスワードが入力されていません。';
    } elseif (!preg_match('/^[0-9a-zA-Z]{5,30}$/', $_POST['password'])) {
        $errors['password_length'] = 'パスワードは半角英数字の5文字以上30文字以下で入力して下さい。';
    } else {
        $password_hide = str_repeat('*', strlen($password));
    }

    //エラーが無ければ実行する
    if(count($errors) === 0){
        try{
		    //例外処理を投げる（スロー）ようにする
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
            //アカウントで検索
            $statement = $dbh->prepare("SELECT * FROM member WHERE account=(:account) AND flag =1");
            $statement->bindValue(':account', $account, PDO::PARAM_STR);
            $statement->execute();

            //アカウントが一致
            if($row = $statement->fetch()){
                $password_hash = $row['password'];
                //パスワードが一致
                if (password_verify($password, $password_hash)) {
                    //セッションハイジャック対策 
                    //乗っ取りを防ぐため、新しいセッションを再生成
                    session_regenerate_id(true);
                    $_SESSION['account'] = $account;
                    header("Location: admin.php");
                    exit();
                }else{
                    $errors['password'] = "アカウント及びパスワードが一致しません。";
                }
            }else{
                $errors['account'] = "アカウント及びパスワードが一致しません。";
            }
		    //データベース接続切断
            $dbh = null;
        }catch (PDOException $e){
            print('Error:'.$e->getMessage());
            die();
        }
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
    <?php if(count($errors) > 0): ?>
    <?php
    foreach($errors as $value){
        echo "<p>".$value."</p>";
    }
    ?>
    <input type="button" value="戻る" onClick="history.back()">
    <?php endif; ?>
</body>
</html>
