<?php

if (!empty($_POST)) {

    // session_start();
    //header("Content-type: text/html; charset=utf-8");
    
    require_once('./lib/DataSource.php');
    require_once('./lib/Common.php');

    //クロスサイトリクエストフォージェリ対策のトークン判定
    if($_POST['token'] != $_SESSION['token']) {
        die();
    }
    //header('X-FRAME-OPTIONS: DENY');

    //エラーメッセージの初期化
    $errors = array();

    if (empty($_POST)) {
        header("Location: login.php");
        exit();
    } else {
        $mail = isset($_POST['mailAddress']) ? $_POST['mailAddress'] : NULL;
        $password = isset($_POST['password']) ? $_POST['password'] : NULL;

        //前後にある半角全角スペースを削除
        $mail = spaceTrim($mail);
        $password = spaceTrim($password);
        
        // //アカウント入力判定
        // if ($account = '') {
        //     $errors['account'] = "アカウントが入力されていません。";
        // } elseif(mb_strlen(($account)) > 10) {
        //     $errors['account_length'] = "アカウントは10文字以内で入力してください";
        // }

        // //パスワード入力判定
        // if ($password == '') {
        //     $errors['password'] = "パスワードが入力されていません。";
        // } elseif (!preg_match('/^[0-9a-zA-Z]{5,30}$/', $_POST['password'])) {
        //     $errors['password_length'] = "パスワードは半角英数字の5文字以上30文字以下で入力して下さい";
        // } else {
        //     $password_hide = str_repeat('*', strlen($password));
        // }

    }

    //エラーが無ければ実行する
    if (count($errors) === 0) {
        try {
            $db = new DataSource();
            $sql = "SELECT * FROM USERS WHERE email = :email";
            $resultsAccount->selectOne($sql, [':email' => $mail, ':password' => $password]);
            if (count($$resultsAccount) > 0) {
                $password_hash = $resultsAccount['email'];
                //パスワードが一致
                if(password_verify($password, $password_hash)) {
                    //セッションハイジャック対策
                    session_regenerate_id(true);
                    $_SESSION['account'] = $account;
                    header("Location: index.php");
                    exit();
                } else {
                    $errors['password'] = "アカウント及びパスワードが一致しません。";
                }
            } else {
                $errors['account'] = "アカウント及びパスワードが一致しません。";
            }
        } catch (PDOException $e) {
            print('Error:' . $e->getMessage());
            die();
        }
    }



} 
