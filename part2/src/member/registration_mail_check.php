<?php

session_start();
header("Content-type: text/html; charset-utf8");

if ($_POST['token'] != $_SESSION['token'] ) {
    echo '不正アクセスの疑いあり';
    exit();
}

//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

//データベース接続
require_once('db.php');
$dbh = db_connect();

//エラーメッセージ
$errors = array();

if (empty($_POST)) {
    header("Location:registration_mail_form.php");
    exit();
} else {
    //postされたデータを変数に入れるには
    $mail = isset($_POST['mail']) ? $_POST['mail'] :  NULL;
    //メールの入力判定
    if ($mail == '') {
        $errors['mail'] == 'メールが入力されていません。';
    } else {
        //メール入力判定
        if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail)) {
            $errors['mail_check'] = "メールアドレスの形式が正しくありません。";
        }
        /*
            ここで本登録用のmemberテーブルにすでに登録されているmailかどうかをチェックする。
            $errors['member_check'] = "このメールアドレスはすでに利用されております。";
        */
    }
}

if (count($errors) === 0) {
    $urlToken = hash('sha256',uniqid(rand(),1));
    $url = "http://c7sandbox.local:50080/member/registration_form.php" . "?urlToken=" . $urlToken;
    //ここでDBに登録する
    try {
        //例外処理を投げる(スローする)
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $dbh->prepare("INSERT INTO pre_member(urlToken,mail,date) VALUES(:urlToken,:mail,now())");
        $statement->bindValue(':urlToken', $urlToken, PDO::PARAM_STR);
        $statement->bindValue(':mail', $mail, PDO::PARAM_STR);
        $statement->execute();
        //データベース接続切断
        $dbh = null;
    } catch (PDOException $e) {
        print('Error:' . $e->getMessage());
    }
    //メールの宛先
    $mailTo = $mail;
    //リターンパスに指定するメールアドレス
    $returnMail = 'nakada.keisuke@ring-and-link.co.jp';
    $name = '送信メールテスト';
    $mail = 'nakada.keisuke@ring-and-link.co.jp';
    $subject = '会員登録用URLのお知らせ';
$body = <<< EOM
下記のURLからご登録ください。
{$url}
EOM;
    mb_language("ja");
    mb_internal_encoding('UTF-8');

    //Fromヘッダーを作成
    $header  = "MIME-Version: 1.0 \n" ;
    $header .= "From: " .
        "".mb_encode_mimeheader (mb_convert_encoding($name,"ISO-2022-JP","AUTO")) ."" .
        "<".$returnMail."> \n";
    $header .= "Reply-To: " .
        "".mb_encode_mimeheader (mb_convert_encoding($name,"ISO-2022-JP","AUTO")) ."" .
        "<".$returnMail."> \n";

    var_dump($header) . PHP_EOL;
    var_dump($mailTo) . PHP_EOL;
    var_dump($subject) . PHP_EOL;
    var_dump($body) . PHP_EOL;
    var_dump($returnMail) . PHP_EOL;

    $sendmail_params  = "-f$returnMail";
    var_dump($sendmail_params) . PHP_EOL;

    if (mb_send_mail($mailTo, $subject, $body, $header, $sendmail_params)) {

        //セッション変数を全て解除
        $_SESSION = array();
        //クッキーの削除
        if(isset($_COOKIE['PHPSESSID'])) {
                setcookie('PHPSESSID','',time() - 1800, '/');
        }
        //セッションを破棄する
        session_destroy();
        $message = 'メールをお送りしました。';
    } else {
        $errors['mail_error'] = 'メールの送信に失敗しました。';
    }
}
?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>確認画面</title>
</head>
<body>
    <h1>メール確認画面</h1>
    <?php if (count($errors) === 0) : ?>
        <p><?php $message ?></p>
        <p>↓このURLが記載されたメールが届きます。</p>
        <a href="<?=$url?>"><?=$url?></a>
    <?php elseif(count($errors) > 0): ?>
    <?php
        foreach($errors as $value){
        echo "<p>".$value."</p>";
    }
    ?>
        <input type="button" value="戻る" onClick="history.back()">
    <?php endif; ?>
</body>
</html> 