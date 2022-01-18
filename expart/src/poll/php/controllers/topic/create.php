<?php

namespace controller\topic\create;

use db\TopicQuery;
use lib\Auth;
use lib\Msg;
use model\TopicModel;
use model\UserModel;
use Throwable;

function get(): void
{
    Auth::requireLogin();

    //セッションからデータを取得
    $topic = unserialize(TopicModel::getSessionAndFlush());

    //セッションが取得できない場合
    if (empty($topic)) {
        $topic = new TopicModel();
        //editを使用するためダミーで値を設定する
        $topic->id = -1;
        $topic->title = '';
        $topic->published = 1;
    }

    \view\topic\edit\index($topic, false);
}

function post(): void
{
    Auth::requireLogin();
    $topic = new TopicModel();
    $topic->id = get_param('topic_id', -1);
    $topic->title = get_param('title', '');
    $topic->published = get_param('published', 1);

    $user = unserialize(UserModel::getSession());

    try {
        $is_success = TopicQuery::insert($topic, $user);
    } catch (Throwable $e) {
        Msg::push(Msg::DEBUG, $e->getMessage());
        $is_success = false;
    }

    if ($is_success) {
        Msg::push(Msg::INFO, 'トピックの登録に成功しました。');
        redirect('topic/archive');
    } else {
        //エラーが発生した場合
        Msg::push(Msg::ERROR, 'トピックの登録に失敗しました。');
        //エラーになっても入力内容をセッションに保存する
        TopicModel::setSession(serialize($topic));
        //リダイレクトにより、上記のGetメソッドが呼ばれる
        redirect(GO_REFERER);
    }
}
