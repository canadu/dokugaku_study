<?php

namespace controller\topic\archive;

use lib\Auth;
use lib\Msg;
use db\TopicQuery;
use model\UserModel;

function get()
{
    //ログインしているかの確認
    Auth::requireLogin();

    //セッション情報を取得
    $user = unserialize(UserModel::getSession());
    
    //ユーザーに紐づくトピックを取得
    $topics = TopicQuery::fetchByUserID($user);

    if ($topics === false) {
        Msg::push(Msg::ERROR, 'ログインしてください。');
        redirect('login');
    }

    if (count($topics) > 0) {
        //1件でもある場合はviewに遷移
        \view\topic\archive\index($topics);
    } else {
        echo '<div class="alert alert-primary">トピックを投稿してみよう。</div>';
    }
}
